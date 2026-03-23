<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketEstudianteModel extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id', 'fecha', 'tipo_comida_id', 'estado', 'created_at'];

    public function obtenerTicketHoy($studentId)
    {
        $fechaHoy = date('Y-m-d');
        return $this->where('student_id', $studentId)
                    ->where('fecha', $fechaHoy)
                    ->first();
    }

    public function obtenerHistorial($studentId)
    {
        return $this->where('student_id', $studentId)
                    ->orderBy('fecha', 'DESC')
                    ->findAll();
    }

    public function obtenerTicketPorId($ticketId)
    {
        return $this->select('tickets.*, students.full_name, students.university_code, students.email_institutional, students.is_scholarship')
                    ->join('students', 'students.id = tickets.student_id')
                    ->where('tickets.id', $ticketId)
                    ->first();
    }
}
