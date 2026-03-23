<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiantesModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'full_name',
        'dni',
        'university_code',
        'email_institutional',
        'mobile',
        'gender',
        'is_scholarship',
        'created_at'
    ];

    // Obtener todos los estudiantes
    public function getEstudiantes()
    {
        return $this->asArray()->orderBy('id', 'ASC')->findAll();
    }

    // Obtener un estudiante por ID
    public function getEstudiantePorId($id)
    {
        return $this->asArray()->find($id);
    }

    // Insertar nuevo estudiante
    public function crearEstudiante($datos)
    {
        return $this->insert($datos);
    }

    // Actualizar estudiante
    public function updateEstudiante($id, $datos)
    {
        return $this->update($id, $datos);
    }

    // Eliminar estudiante y relaciones si existen
    public function eliminarEstudiante($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // Eliminar datos relacionados si existen esas tablas
        $db->table('actividad_estudiantes')->where('student_id', $id)->delete();
        $db->table('incidencias')->where('student_id', $id)->delete();

        $this->delete($id);

        $db->transComplete();
        return $db->transStatus();
    }
}
