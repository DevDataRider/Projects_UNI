<?php

namespace App\Models;

use CodeIgniter\Model;

class ActividadEstudiantesModel extends Model
{
    protected $table = 'actividad_estudiantes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id', 'accion', 'fecha'];

    public function obtenerActividadesConEstudiantes()
    {
        return $this->select('actividad_estudiantes.*, students.full_name, students.university_code')
                    ->join('students', 'students.id = actividad_estudiantes.student_id')
                    ->orderBy('actividad_estudiantes.fecha', 'DESC')
                    ->findAll();
    }
}
