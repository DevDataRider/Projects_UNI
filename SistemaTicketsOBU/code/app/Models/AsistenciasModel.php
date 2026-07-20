<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenciasModel extends Model
{
    protected $table = 'asistencias';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'ticket_id',
        'fecha_ingreso'
    ];

    protected $useTimestamps = false;

    // Obtener asistencias con datos de tickets y estudiantes
    public function obtenerAsistenciasConTickets()
    {
        return $this->select('asistencias.*, tickets.student_id, tickets.fecha, tickets.tipo_comida_id, tickets.estado as estado_ticket, students.full_name')
                    ->join('tickets', 'tickets.id = asistencias.ticket_id')
                    ->join('students', 'students.id = tickets.student_id')
                    ->orderBy('asistencias.fecha_ingreso', 'DESC')
                    ->findAll();
    }

    // Contar todas las asistencias en general
    public function contarAsistencias()
    {
        return $this->countAll();
    }
}
