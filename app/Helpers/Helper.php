<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Exception;

class Helper
{
    // Expresiones regulares para validaciones
    public const REGEX_TEXTO = '/^[a-zA-ZÁáÉéÍíÓóÚúÜü]+( [a-zA-ZÁáÉéÍíÓóÚúÜü]+)*$/'; // Solo letras y espacios
    public const REGEX_DNI = '/^[MF]?\d{7,8}$/'; // 7-8 dígitos o 'M/F' seguido de 7 dígitos
    public const REGEX_TELEFONO = '/^\d{8,12}$/'; // Entre 8 y 12 dígitos
    public const REGEX_PASSWORD = '/^(?=.*[a-zA-Z])(?=(.*\d){5,})[A-Za-z0-9]{6,8}$/'; // al menos 5 números y 1 letra
    public const REGEX_PATENTE = '/^[A-Z]{3}\d{3}|[A-Z]{2}\d{3}[A-Z]{2}$/'; // Formato patente Argentina

    /**
     * Verifica si una fecha dada es feriado en Argentina.
     *
     * @param string $fecha Fecha en formato 'YYYY-MM-DD'
     * @return bool Retorna true si es feriado, false en caso contrario
     */
    public static function esFeriado(string $fecha): bool
    {
        try {
            $fecha = Carbon::parse($fecha); // Convertir la fecha a Carbon
            $anio = $fecha->year; // Obtener el año

            // Verificar si los datos ya están en caché
            $cacheKey = "fechasFeriados";
            if (Cache::has($cacheKey)) {
                $fechasFeriados = Cache::get($cacheKey);
            } else {
                // Hacer la solicitud a la API para obtener feriados
                $res = Http::get("https://date.nager.at/api/v3/PublicHolidays/{$anio}/AR");

                if (!$res->successful()) {
                    return false; // Si falla la API, asumimos que no es feriado
                }

                $feriados = $res->json();
                $fechasFeriados = array_column($feriados, 'date'); // Extraer solo las fechas

                // Guardar en caché por 1 día
                Cache::put($cacheKey, $fechasFeriados, now()->addDay());
            }

            // Verificar si la fecha consultada es un feriado
            return in_array($fecha->toDateString(), $fechasFeriados);
        } catch (Exception $e) {
            \Log::error("Error al verificar feriado: " . $e->getMessage());
            return false;
        }
    }
}