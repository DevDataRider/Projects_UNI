<?php

namespace App\Models;

use CodeIgniter\Model;

class IncidenciasModel extends Model
{
    protected $table = 'incidencias';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_id',
        'descripcion',
        'fecha'
    ];

    protected $useTimestamps = false;

    public function obtenerIncidenciasConEstudiantes()
    {
        return $this->select('incidencias.*, students.full_name, students.university_code')
                    ->join('students', 'students.id = incidencias.student_id')
                    ->orderBy('incidencias.fecha', 'DESC')
                    ->findAll();
    }
}
