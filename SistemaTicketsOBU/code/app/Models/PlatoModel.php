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
                    ->orderBy('fecha', 'ASC')
                    ->findAll();
    }
}
