<?php

namespace App\Models;

use CodeIgniter\Model;

class CajasModels extends Model
{
    // Obtener estudiantes
    public function getEstudiantes()
    {
        $estudiantes = $this->db->query("SELECT * FROM students");
        return $estudiantes->getResult();
    }

    // Obtener los platos registrados
    public function getPlatosDelDia()
    {
        $platos = $this->db->query("SELECT * FROM platos_del_dia ORDER BY fecha DESC");
        return $platos->getResult();
    }

    // Obtener los tickets generados
    public function getTickets()
    {
        $tickets = $this->db->query("
            SELECT 
                t.id,
                t.student_id,
                t.fecha,
                t.tipo_comida_id,
                t.estado,
                t.created_at,
                s.full_name,
                s.university_code
            FROM tickets t
            JOIN students s ON t.student_id = s.id
            ORDER BY t.fecha DESC
        ");
        return $tickets->getResult();
    }

    // Obtener total de asistencias
    public function getTotalAsistencias()
    {
        $asistencias = $this->db->query("SELECT * FROM asistencias");
        return $asistencias->getResult();
    }

    // Obtener total de incidencias
    public function getTotalIncidencias()
    {
        $incidencias = $this->db->query("SELECT * FROM incidencias");
       return $incidencias->getResult();
    }

    // Obtener total de actividades estudiantiles
    public function getTotalActividad()
    {
        $actividad = $this->db->query("SELECT * FROM actividad_estudiantes");
        return $actividad-> getResult();
    }
    public function getTotalBecados()
{
    return $this->db->table('students')->where('is_scholarship', 1)->countAllResults();
}

public function getTotalNoBecados()
{
    return $this->db->table('students')->where('is_scholarship', 0)->countAllResults();
}

}
