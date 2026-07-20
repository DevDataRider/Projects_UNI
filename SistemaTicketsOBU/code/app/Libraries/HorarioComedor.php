<?php

namespace App\Libraries;

/**
 * Fuente única de verdad para los turnos de atención del comedor
 * (horario y día hábil). Usada por el dashboard del estudiante,
 * el registro de tickets y la gestión de platos del día.
 */
class HorarioComedor
{
    private const TURNOS = [
        1 => ['nombre' => 'Desayuno', 'inicio' => '07:00:00', 'fin' => '09:30:00'],
        2 => ['nombre' => 'Almuerzo', 'inicio' => '12:00:00', 'fin' => '14:00:00'],
        3 => ['nombre' => 'Cena',     'inicio' => '17:00:00', 'fin' => '19:00:00'],
    ];

    /**
     * Devuelve el tipo_comida_id del turno activo, o null si el comedor
     * está cerrado (fin de semana o fuera de todos los rangos horarios).
     */
    public static function turnoActual(?string $hora = null, ?int $diaSemana = null): ?int
    {
        if (!self::esDiaHabil($diaSemana)) {
            return null;
        }

        $hora ??= date('H:i:s');

        foreach (self::TURNOS as $tipoComidaId => $rango) {
            if ($hora >= $rango['inicio'] && $hora <= $rango['fin']) {
                return $tipoComidaId;
            }
        }

        return null;
    }

    public static function esDiaHabil(?int $diaSemana = null): bool
    {
        $diaSemana ??= (int) date('N'); // 1 = Lunes, ..., 7 = Domingo

        return $diaSemana <= 5;
    }

    public static function nombre(int $tipoComidaId): ?string
    {
        return self::TURNOS[$tipoComidaId]['nombre'] ?? null;
    }

    /**
     * @return array<int, array{nombre: string, inicio: string, fin: string}>
     */
    public static function rangos(): array
    {
        return self::TURNOS;
    }
}
