<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class TurnoController extends Controller
{
    // Prioridades de los estados de los turnos para ordenamiento
    private $estadoPrioridad = ['Pendiente' => 0, 'Cancelado' => 1, 'Finalizado' => 2];

    // Intervalo entre turnos disponibles (en minutos)
    private $intervaloTurnos = 15;

    // Tolerancia para limpieza y descanso del personal (en minutos)
    private $tolerancia = 15;

    // Jornadas de trabajo definidas como horas de inicio y fin
    private $jornadas = [
        ['inicio' => '08:00', 'fin' => '12:00'],
        ['inicio' => '14:00', 'fin' => '18:00'],
    ];

    /**
     * Muestra la lista de turnos.
     *
     * @return View
     */
    public function index()
    {
        // Obtener los turnos ordenados por fecha y estado
        $turnos = $this->obtenerTurnosOrdenados();

        // Obtener servicios y vehículos para los filtros
        $servicios = Servicio::latest()->get();
        $vehiculos = $this->obtenerVehiculos();

        // Retornar la vista con los datos necesarios
        return view('turnos.index', compact('turnos', 'servicios', 'vehiculos'));
    }

    /**
     * Muestra el formulario para reservar un turno o procesa la reserva.
     *
     * @param Request $req
     * @return RedirectResponse|View
     */
    public function reservar(Request $req)
    {
        // Si es una solicitud GET, mostrar el formulario de reserva
        if ($req->isMethod('get')) {
            $servicios = Servicio::latest()->get();
            $vehiculos = $this->obtenerVehiculos();
            return view('turnos.reservar', compact('servicios', 'vehiculos'));
        }

        // Validar los datos del turno
        try {
            $datos = $this->validarTurno($req);
        } catch (ValidationException $e) {
            // Si la validación falla, manejar el error y mostrar los horarios disponibles
            $horariosDisponibles = $this->calcularHorariosDisponibles($req->servicios ?? []);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($req->all() + ['horariosDisponibles' => $horariosDisponibles]);
        }

        // Crear el turno y asociar los servicios
        $turno = Auth::user()->turnos()->create($datos);
        $turno->servicios()->attach($datos['servicios']);

        // Redirigir con un mensaje de éxito
        return redirect()->route('turnos')->with('msj', 'Se reservó el turno exitosamente.');
    }

    /**
     * Muestra el formulario para modificar un turno o procesa la modificación.
     *
     * @param Request $req
     * @param string $id
     * @return RedirectResponse|View
     */
    public function modificar(Request $req, string $id)
    {
        // Obtener el turno a modificar
        $turno = Auth::user()->turnos()->findOrFail($id);

        // Verificar si el turno está en estado "Pendiente"
        if ($turno->estado !== 'Pendiente') {
            return redirect()->route('turnos')->with('error', "No es posible modificar el turno, ya que se encuentra {$turno->estado}.");
        }

        // Si es una solicitud GET, mostrar el formulario de modificación
        if ($req->isMethod('get')) {
            $servicios = Servicio::latest()->get();
            $vehiculos = $this->obtenerVehiculos();
            $servicioIds = $turno->servicios->pluck('id')->toArray();
            $horariosDisponibles = $this->calcularHorariosDisponibles($servicioIds, $turno->id);

            return view('turnos.modificar', compact('turno', 'servicios', 'vehiculos', 'horariosDisponibles'));
        }

        // Validar los datos del turno
        try {
            $datos = $this->validarTurno($req, $turno->id);
        } catch (ValidationException $e) {
            // Si la validación falla, manejar el error y mostrar los horarios disponibles
            $horariosDisponibles = $this->calcularHorariosDisponibles($req->servicios ?? [], $turno->id);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($req->all() + ['horariosDisponibles' => $horariosDisponibles]);
        }

        // Actualizar el turno y sincronizar los servicios
        $turno->update($datos);
        $turno->servicios()->sync($datos['servicios']);

        // Redirigir con un mensaje de éxito
        return redirect()->route('turnos')->with('msj', 'Se modificó el turno exitosamente.');
    }

    /**
     * Cancela un turno.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function cancelar(string $id)
    {
        // Obtener el turno a cancelar
        $turno = Turno::findOrFail($id);

        // Verificar si el turno ya pasó
        if ($turno->fechaHora->isPast()) {
            return redirect()->route('turnos')->with('error', 'No se puede cancelar un turno que ya pasó.');
        }

        // Actualizar el estado del turno a "Cancelado"
        $turno->update(['estado' => 'Cancelado']);

        // Redirigir con un mensaje de éxito
        return redirect()->route('turnos')->with('msj', 'Se canceló el turno exitosamente.');
    }

    /**
     * Finaliza un turno.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function finalizar(string $id)
    {
        // Obtener el turno a finalizar
        $turno = Turno::findOrFail($id);

        // Verificar si el turno ya ocurrió
        if (!$turno->fechaHora->isPast()) {
            return redirect()->route('turnos')->with('error', 'Solo se pueden finalizar turnos que ya ocurrieron.');
        }

        // Actualizar el estado del turno a "Finalizado"
        $turno->update(['estado' => 'Finalizado']);

        // Redirigir con un mensaje de éxito
        return redirect()->route('turnos')->with('msj', 'Se finalizó el turno exitosamente.');
    }

    /**
     * Valida los datos del turno.
     *
     * @param Request $req
     * @param int $idTurnoReprogramado
     * @return array
     * @throws ValidationException
     */
    private function validarTurno(Request $req, $idTurnoReprogramado = 0)
    {
        return $req->validate([
            'servicios' => 'required|array',
            'servicios.*' => 'exists:servicios,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'fechaHora' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($req, $idTurnoReprogramado) {
                    if (
                        !$this->estaDisponible(
                            Carbon::parse($req->fechaHora),
                            $this->calcularDuracion($req->servicios),
                            $idTurnoReprogramado
                        )
                    ) {
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

    /**
     * Actualiza los horarios disponibles en función de los servicios seleccionados.
     *
     * @param Request $req
     * @return JsonResponse
     */
    public function actualizarHorarios(Request $req)
    {
        $req->validate([
            'servicios' => 'required|array',
            'servicios.*' => 'exists:servicios,id',
        ], [
            'servicios.required' => 'Debes seleccionar al menos un servicio.',
            'servicios.*.exists' => 'Uno o más servicios seleccionados no son válidos.',
        ]);

        $horariosDisponibles = $this->calcularHorariosDisponibles($req->servicios, $req->idTurnoReprogramado);

        return response()->json($horariosDisponibles);
    }

    /**
     * Calcula los horarios disponibles para los servicios seleccionados.
     *
     * @param array $servicios IDs de los servicios seleccionados.
     * @param int $idTurnoReprogramado ID del turno que se está reprogramando (opcional).
     * @return array Lista de horarios disponibles en formato 'Y-m-d H:i'.
     */
    private function calcularHorariosDisponibles($servicios, $idTurnoReprogramado = 0)
    {
        // Fecha actual, comenzando desde el inicio del día (00:00:00)
        $fechaActual = Carbon::now()->startOfDay();

        // Fecha límite para calcular horarios (7 días después de la fecha actual)
        $fechaFin = $fechaActual->copy()->addDays(7);

        // Array para almacenar los horarios disponibles
        $horariosDisponibles = [];

        // Calcular la duración total de los servicios seleccionados (incluyendo la tolerancia)
        $duracionTotal = $this->calcularDuracion($servicios);

        // Iterar día por día dentro del rango de fechas
        while ($fechaActual->lte($fechaFin)) {
            // Si el día es fin de semana o feriado, saltar al siguiente día
            if ($fechaActual->isWeekend() || Helper::esFeriado($fechaActual)) {
                $fechaActual->addDay();
                continue;
            }

            // Obtener los horarios disponibles para el día actual
            $horariosDelDia = $this->obtenerHorariosDisponibles($fechaActual, $duracionTotal, $idTurnoReprogramado);

            // Agregar los horarios del día al array de horarios disponibles
            $horariosDisponibles = array_merge($horariosDisponibles, $horariosDelDia);

            // Pasar al siguiente día
            $fechaActual->addDay();
        }

        return $horariosDisponibles;
    }

    /**
     * Obtiene los horarios disponibles para una fecha específica.
     *
     * @param Carbon $fechaHora Fecha y hora para la cual se calculan los horarios.
     * @param int $duracionTotal Duración total del turno (en minutos).
     * @param int $idTurnoReprogramado ID del turno que se está reprogramando (opcional).
     * @return array Lista de horarios disponibles en formato 'Y-m-d H:i'.
     */
    private function obtenerHorariosDisponibles($fechaHora, $duracionTotal, $idTurnoReprogramado = 0)
    {
        // Array para almacenar los horarios disponibles
        $horariosDisponibles = [];

        foreach ($this->jornadas as $jornada) {
            // Convertir la hora de inicio y fin de la jornada a objetos Carbon
            $horarioActual = Carbon::parse($fechaHora->toDateString() . ' ' . $jornada['inicio']);
            $jornadaFin = Carbon::parse($fechaHora->toDateString() . ' ' . $jornada['fin']);

            // Iterar en intervalos de $intervaloTurnos minutos dentro de la jornada
            while ($horarioActual->copy()->addMinutes($duracionTotal)->lte($jornadaFin)) {
                // Si el horario actual es anterior a la hora actual, saltar al siguiente intervalo
                if ($horarioActual->lessThan(Carbon::now()->setSeconds(0))) {
                    $horarioActual->addMinutes($this->intervaloTurnos);
                    continue;
                }

                // Verificar si el horario está disponible
                if ($this->estaDisponible($horarioActual, $duracionTotal, $idTurnoReprogramado)) {
                    // Si está disponible, agregarlo a la lista de horarios disponibles
                    $horariosDisponibles[] = $horarioActual->format('Y-m-d H:i');
                }

                // Pasar al siguiente intervalo
                $horarioActual->addMinutes($this->intervaloTurnos);
            }
        }

        return $horariosDisponibles;
    }

    /**
     * Verifica si un horario está disponible.
     *
     * @param Carbon $horarioInicio Horario de inicio propuesto.
     * @param int $duracionTotal Duración total del turno (en minutos).
     * @param int $idTurnoReprogramado ID del turno que se está reprogramando (opcional).
     * @return bool True si el horario está disponible, False si no.
     */
    private function estaDisponible($horarioInicio, $duracionTotal, $idTurnoReprogramado = 0)
    {
        // Calcular el horario de fin del turno propuesto
        $horarioFin = $horarioInicio->copy()->addMinutes($duracionTotal);

        // Obtener los turnos del día que están en estado "Pendiente"
        $turnosDelDia = $this->obtenerTurnosPorDia($horarioInicio, $idTurnoReprogramado);

        // Verificar cada turno existente para detectar superposiciones
        foreach ($turnosDelDia as $turno) {
            // Convertir la fecha y hora del turno existente a un objeto Carbon
            $turnoInicio = Carbon::parse($turno->fechaHora);

            // Calcular el horario de fin del turno existente
            $turnoFin = $turnoInicio->copy()->addMinutes($this->calcularDuracion($turno->servicios->pluck('id')->toArray()));

            // Verificar si hay superposición entre el turno propuesto y el turno existente
            if (!$horarioFin->lte($turnoInicio) && !$horarioInicio->gte($turnoFin)) {
                // Si hay superposición, el horario no está disponible
                return false;
            }
        }

        // Si no hay superposiciones, el horario está disponible
        return true;
    }

    /**
     * Calcula la duración total de los servicios seleccionados.
     *
     * @param array $servicios IDs de los servicios seleccionados.
     * @return int Duración total en minutos (incluyendo la tolerancia).
     */
    private function calcularDuracion($servicios)
    {
        // Sumar la duración de todos los servicios seleccionados
        $duracion = Servicio::whereIn('id', $servicios)->sum('duracion');

        // Agregar la tolerancia para limpieza y descanso
        return $duracion + $this->tolerancia;
    }

    /**
     * Obtiene los vehículos del usuario o todos los vehículos si es administrador.
     *
     * @return Collection
     */
    private function obtenerVehiculos()
    {
        return (Auth::user()->rol == 'Cliente')
            ? Auth::user()->vehiculos->sortByDesc('created_at')
            : Vehiculo::latest()->get();
    }

    /**
     * Obtiene los turnos ordenados por fecha y estado.
     *
     * @return Collection
     */
    private function obtenerTurnosOrdenados()
    {
        return (Auth::user()->rol == 'Cliente')
            ? Auth::user()->turnos
                ->sortBy('fechaHora')
                ->sortBy(fn($turno) => $this->estadoPrioridad[$turno->estado] ?? 3)
            : Turno::orderBy('fechaHora')->get()
                ->sortBy(fn($turno) => $this->estadoPrioridad[$turno->estado] ?? 3);
    }

    /**
     * Obtiene los turnos para un día específico, excluyendo un turno que se está reprogramando (si se proporciona).
     * Si no se excluye el turno reprogramado, el sistema lo considerará como un turno ocupado, lo que impediría seleccionar su horario actual.
     * 
     * @param Carbon $fechaHora Fecha y hora para la cual se buscan los turnos.
     * @param int $idTurnoReprogramado ID del turno que se está reprogramando (opcional).
     * @return Collection Lista de turnos para el día especificado.
     */
    private function obtenerTurnosPorDia($fechaHora, $idTurnoReprogramado = 0)
    {
        return Turno::where('fechaHora', 'like', $fechaHora->toDateString() . '%')
            ->where('id', '!=', $idTurnoReprogramado) // Excluir el turno que se está reprogramando
            ->where('estado', 'Pendiente') // Solo considerar turnos en estado "Pendiente"
            ->get(); 
    }
}