<?php

namespace App\Models;

use CodeIgniter\Model;

class PlatoModel extends Model
{
    protected $table = 'platos_del_dia';
    protected $primaryKey = 'id';
    protected $allowedFields = ['fecha', 'tipo_comida_id', 'descripcion'];
    protected $useTimestamps = false;

    // Relacionar con tipo_comida (si necesitas el nombre)
    public function obtenerPlatosConTipo()
    {
        return $this->select('platos_del_dia.*, tipo_comida.nombre AS tipo_comida')
                    ->join('tipo_comida', 'tipo_comida.id = platos_del_dia.tipo_comida_id')
                    ->orderBy('fecha', 'DESC')
                    ->findAll();
    }

    /**
     * Menú fijo de desayunos usado cuando no hay un plato cargado para la fecha exacta.
     */
    private const MENUS_DESAYUNO_RESPALDO = [
        'Pan con queso, pan con palta, cuaquer y mandarina',
        'Pan con mermelada, pan con torreja, cafe con leche y 1 huevo sancochado',
        'Pan con lomo, pan con jamonada, soya y galleta rellenitas',
        'Pan integral con palta, pan con tortilla, emoliente y queque',
    ];

    /**
     * Devuelve el plato del día para la fecha/turno pedidos. Si no hay uno cargado
     * exactamente para esa fecha, usa un respaldo razonable en vez de dejar el
     * turno sin menú: desayuno rota entre un set fijo de menús, y cena reutiliza
     * el almuerzo del día (que a su vez rota entre los almuerzos ya cargados en BD)
     * cuando tampoco hay un plato de cena propio.
     */
    public function obtenerPlatoDelDia(string $fecha, int $tipoComidaId): ?array
    {
        $plato = $this->where('fecha', $fecha)->where('tipo_comida_id', $tipoComidaId)->first();
        if ($plato) {
            return $plato;
        }

        $diaSemana = (int) date('N', strtotime($fecha)); // 1 = lunes ... 7 = domingo

        if ($tipoComidaId === 1) {
            $indice = ($diaSemana - 1) % count(self::MENUS_DESAYUNO_RESPALDO);

            return [
                'fecha'          => $fecha,
                'tipo_comida_id' => 1,
                'descripcion'    => self::MENUS_DESAYUNO_RESPALDO[$indice],
            ];
        }

        if ($tipoComidaId === 2) {
            $almuerzos = $this->where('tipo_comida_id', 2)->orderBy('fecha', 'ASC')->findAll();
            if (empty($almuerzos)) {
                return null;
            }

            return $almuerzos[($diaSemana - 1) % count($almuerzos)];
        }

        if ($tipoComidaId === 3) {
            // Sin menú propio de cena: se reutiliza el almuerzo del día.
            return $this->obtenerPlatoDelDia($fecha, 2);
        }

        return null;
    }
}
