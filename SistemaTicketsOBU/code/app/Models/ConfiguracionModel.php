<?php
namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table = 'configuracion';
    protected $primaryKey = 'id';
    protected $allowedFields = ['clave', 'valor'];

    public function obtenerTodas()
    {
        return $this->findAll();
    }

    public function obtenerValor($clave)
    {
        return $this->where('clave', $clave)->first();
    }

    public function actualizarValor($id, $valor)
    {
        return $this->update($id, ['valor' => $valor]);
    }
}
