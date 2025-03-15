<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Exception;
use Hamcrest\Core\IsSame;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TurnoController extends Controller
{
    public function index()
    {
        // Ordenar en orden descendente (el más reciente primero)
        $estadoPrioridad = ['Pendiente' => 0, 'Cancelado' => 1, 'Finalizado' => 2];

        $turnos = (Auth::user()->rol == 'Cliente')
            ? Auth::user()->turnos
                ->sortBy('fechaHora') // Primero ordena por fecha más reciente
                ->sortBy(fn($turno) => $estadoPrioridad[$turno->estado] ?? 3) // Luego ordena por prioridad de estado
            : Turno::orderBy('fechaHora')
                ->get()
                ->sortBy(fn($turno) => $estadoPrioridad[$turno->estado] ?? 3);

        // Obtener los servicios y vehiculos para los filtros
        $servicios = Servicio::orderBy('created_at', 'DESC')->get();
        $vehiculos = (Auth::user()->rol == 'Cliente')
            ? Auth::user()->vehiculos->sortByDesc('created_at')
            : Vehiculo::orderBy('created_at', 'DESC')->get();

        // Crear un array y retornar la vista
        return view('turnos.index', compact('turnos', 'servicios', 'vehiculos'));
    }

    public function reservar(Request $req)
    {
        // Si la solicitud es get, retornar vista
        if ($req->isMethod('get')) {
            // Obtener los servicios y vehiculos para los selects
            $servicios = Servicio::orderBy('created_at', 'DESC')->get();
            $vehiculos = (Auth::user()->rol == 'Cliente')
                ? Auth::user()->vehiculos->sortByDesc('created_at')
                : Vehiculo::orderBy('created_at', 'DESC')->get();
            return view('turnos.reservar', compact('servicios', 'vehiculos'));
        }

        // Validar los datos
        try {
            $datos = $this->validarTurno($req);
        } catch (ValidationException $e) {
            // Obtener los horarios disponibles antes de redirigir
            $horariosDisponibles = $this->calcularHorariosDisponibles($req->servicios ?? []);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($req->all() + ['horariosDisponibles' => $horariosDisponibles]);
        }

        // Crear el turno con los datos validados
        $turno = Auth::user()->turnos()->create($datos);

        // Asociar los servicios seleccionados al turno
        $turno->servicios()->attach($datos['servicios']);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('turnos')->with('msj', 'Se reservó el turno exitosamente.');
    }

    public function modificar(Request $req, string $id)
    {
        // Buscar el vehículo por el id proporcionado
        $turno = Auth::user()->turnos()->findOrFail($id);

        if ($turno->estado !== 'Pendiente') {
            return redirect()->route('turnos')
                ->with('error', "No es posible modificar el turno, ya que se encuentra {$turno->estado}.");
        }

        // Si la solicitud es get, retornar vista
        if ($req->isMethod('get')) {
            // Obtener los servicios y vehiculos para los selects
            $servicios = Servicio::orderBy('created_at', 'DESC')->get();
            $vehiculos = (Auth::user()->rol == 'Cliente')
                ? Auth::user()->vehiculos->sortByDesc('created_at')
                : Vehiculo::orderBy('created_at', 'DESC')->get();
                
            $servicioIds = $turno->servicios->pluck('id')->toArray();
            $horariosDisponibles = $this->calcularHorariosDisponibles($servicioIds, $turno->id);

            return view('turnos.modificar', compact('turno', 'servicios', 'vehiculos', 'horariosDisponibles'));
        }

        // Validar los datos
        try {
            $datos = $this->validarTurno($req, $turno->id);
        } catch (ValidationException $e) {
            // Obtener los horarios disponibles antes de redirigir
            $horariosDisponibles = $this->calcularHorariosDisponibles($req->servicios ?? [], $turno->id);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($req->all() + ['horariosDisponibles' => $horariosDisponibles]);
        }

        // Actualizar el turno con los datos validados
        $turno->update($datos);

        // Asociar los servicios seleccionados al turno
        $turno->servicios()->sync($datos['servicios']);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('turnos')->with('msj', 'Se modificó el turno exitosamente.');
    }

    public function cancelar(string $id)
    {
        // Buscar el turno por el id proporcionado
        $turno = Turno::findOrFail($id);

        // Verificar que el turno aún no ha pasado
        if ($turno->fechaHora->isPast()) {
            return redirect()->route('turnos')->with('error', 'No se puede cancelar un turno que ya pasó.');
        }

        // Cancelar el turno 
        $turno->update(['estado' => 'Cancelado']);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('turnos')->with('msj', 'Se canceló el turno exitosamente.');
    }

    public function finalizar(string $id)
    {
        // Buscar el turno por el id proporcionado
        $turno = Turno::findOrFail($id);

        // Verificar que el turno ya pasó
        if (!$turno->fechaHora->isPast()) {
            return redirect()->route('turnos')->with('error', 'Solo se pueden finalizar turnos que ya ocurrieron.');
        }

        // Finalizar el turno
        $turno->update(['estado' => 'Finalizado']);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('turnos')->with('msj', 'Se finalizó el turno exitosamente.');
    }

    private function validarTurno(Request $req, $idTurnoReprogramado = 0)
    {
        return $req->validate([
            'servicios' => 'required|array', // Debe ser un array y no estar vacío
            'servicios.*' => 'exists:servicios,id', // Cada ID debe existir en la tabla `servicios`
            'vehiculo_id' => 'required|exists:vehiculos,id', // Debe seleccionar un vehículo válido
            'fechaHora' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($req, $idTurnoReprogramado) {
                    $horariosDisponibles = $this->obtenerHorariosDisponibles(Carbon::parse($value), $req->servicios, idTurnoReprogramado: $idTurnoReprogramado);
                    if (empty($horariosDisponibles)) {
                        $fail('La fecha y hora seleccionada no está disponible.');
                    }
                }
            ],
        ], [
            'servicios.required' => 'Debes seleccionar al menos un servicio.',
            'servicios.*.exists' => 'Uno o más servicios seleccionados no son válidos.',
            'vehiculo_id.required' => 'Debes seleccionar un vehículo.',
            'vehiculo_id.exists' => 'El vehículo seleccionado no es válido.',
            'fechaHora.required' => 'Debes seleccionar una fecha y hora.',
            'fechaHora.date' => 'La fecha y hora seleccionada no es válida.',
        ]);
    }

    public function actualizarHorarios(Request $req)
    {
        // Validar que se hayan enviado servicios
        $req->validate([
            'servicios' => 'required|array',
            'servicios.*' => 'exists:servicios,id',
        ], [
            'servicios.required' => 'Debes seleccionar al menos un servicio.',
            'servicios.*.exists' => 'Uno o más servicios seleccionados no son válidos.',
        ]);

        // Calcular los horarios disponibles
        $horariosDisponibles = $this->calcularHorariosDisponibles($req->servicios, $req->idTurnoReprogramado);

        return response()->json($horariosDisponibles);
    }

    private function calcularHorariosDisponibles($servicios, $idTurnoReprogramado = 0)
    {
        // Inicializar variables
        $fechaActual = Carbon::now()->startOfDay(); // Fecha de hoy
        $fechaFin = $fechaActual->copy()->addDays(7); // Fecha de fin (7 días después)

        $horariosDisponibles = [];

        // Definir jornadas de trabajo
        $jornadas = [
            ['inicio' => '08:00', 'fin' => '12:00'],
            ['inicio' => '14:00', 'fin' => '18:00'],
        ];

        // Iterar sobre cada día a partir de hoy hasta 7 días después
        while ($fechaActual->lte($fechaFin)) {
            // Verificar si el día es fin de semana o feriado
            if (!$fechaActual->isWeekend() || Helper::esFeriado($fechaActual)) {
                $fechaActual->addDay(); // Avanzar al siguiente día
                continue;
            }

            // Obtener horarios disponibles para el día actual
            $horariosDelDia = $this->obtenerHorariosDisponibles($fechaActual, $servicios, $jornadas, $idTurnoReprogramado);

            // Agregar los horarios disponibles al array general
            $horariosDisponibles = array_merge($horariosDisponibles, $horariosDelDia);

            // Avanzar al siguiente día
            $fechaActual->addDay();
        }

        return $horariosDisponibles;
    }

    // Verificar la disponobilidad de muchos horarios dentro de una jornada en una misma fecha
    private function obtenerHorariosDisponibles($fechaHora, $servicios, $jornadas = null, $idTurnoReprogramado = 0)
    {
        $turnosDelDia = Turno::where('fechaHora', 'like', $fechaHora->toDateString() . '%')
            ->where('id', '!=', $idTurnoReprogramado) // Excluir el turno reprogramado
            ->where('estado', 'Pendiente') // Filtrar solo los turnos pendientes
            ->get();

        $horariosDisponibles = [];

        // Calcular la duración total a partir de servicios seleccionados
        $duracionTotal = $this->calcularDuracion($servicios);
        $intervaloTurnos = 15; // Intervalo entre turnos disponibles consecutivos

        if ($jornadas != null) {
            // Iterar sobre los horarios de trabajo, por ejemplo:
            // - Primera jornada: de 8:00 a 12:00
            // - Segunda jornada: de 14:00 a 16:00
            foreach ($jornadas as $jornada) {
                $horarioActual = Carbon::parse($fechaHora->toDateString() . ' ' . $jornada['inicio']); // Empieza en el inicio de la jornada
                $jornadaFin = Carbon::parse($fechaHora->toDateString() . ' ' . $jornada['fin']); // Fin de la jornada (12:00 o 18:00)

                // Calcular horarios disponibles cada 15 minutos según el intervalo definido
                // Verificar si el horario actual, más la duración total de los servicios, no excede el final de la jornada
                while ($horarioActual->copy()->addMinutes($duracionTotal)->lte($jornadaFin)) {

                    // Si el horario ya pasó, saltar a la siguiente iteración
                    if ($horarioActual->lessThan(Carbon::now()->setSeconds(0))) {
                        //var_dump(Carbon::now()->setSeconds(0));
                        $horarioActual->addMinutes($intervaloTurnos);
                        continue;
                    }

                    if ($this->estaDisponible($horarioActual, $duracionTotal, $turnosDelDia)) {
                        $horariosDisponibles[] = $horarioActual->format('Y-m-d H:i'); // Formatear el horario 
                    }

                    // Avanzar 15 minutos
                    $horarioActual->addMinutes($intervaloTurnos);
                }
            }
        } else {
            // Si el horario ya pasó, no retornar nada
            if ($fechaHora->lessThan(Carbon::now()->setSeconds(0))) {
                return [];
            }

            // Verificar disponibilidad para un solo horario
            if ($this->estaDisponible($fechaHora, $duracionTotal, $turnosDelDia)) {
                $horariosDisponibles[] = $fechaHora->format('Y-m-d H:i');
            }
        }
        return $horariosDisponibles;
    }

    private function estaDisponible($horarioInicio, $duracionTotal, $turnosDelDia)
    {
        $horarioFin = Carbon::parse($horarioInicio->copy()->addMinutes($duracionTotal));

        // Verificar si el horario no coincide con un turno existente
        $disponible = true;
        foreach ($turnosDelDia as $turno) {
            $turnoInicio = Carbon::parse($turno->fechaHora);

            $servicioIds = $turno->servicios->pluck('id')->toArray(); // Esto es necesario porque calcularDuracion espera los ids de los servicios
            $turnoFin = $turnoInicio->copy()->addMinutes($this->calcularDuracion($servicioIds));

            //var_dump($turno->servicios);

            // Si el horario evaluado termina justo antes de que empiece un turno, o empieza justo después de que termine un turno, está disponible
            if ($horarioFin->lte($turnoInicio) || $horarioInicio->gte($turnoFin)) {
                continue; // No coincide con este turno, avanzar al siguiente
            } else {
                $disponible = false; // Coincide con este turno, por ende no está disponible
                break;
            }
        }

        return $disponible;
    }

    private function calcularDuracion($servicios)
    {
        $duracion = 0;
        $tolerancia = 15; // Tolerancia para limpieza y descanso del personal

        if (!empty($servicios)) {
            // Recuperar los servicios desde la base de datos usando los IDs
            //$servicios = Arr::flatten($servicios);
            $servicios = Servicio::whereIn('id', $servicios)->get();

            // Calcular la duración total
            foreach ($servicios as $servicio) {
                $duracion += $servicio->duracion;
            }
            $duracion += $tolerancia;
        }

        return $duracion;
    }
}