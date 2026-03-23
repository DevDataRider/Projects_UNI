<?php
namespace App\Models;
use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id', 'fecha', 'tipo_comida_id', 'estado', 'created_at'];

    // ✔️ Verifica si el estudiante ya tiene ticket para ese día y comida
    public function verificarDisponibilidad($studentId, $fecha, $tipoComidaId)
{
    return !$this->where('student_id', $studentId)
                 ->where('fecha', $fecha)
                 ->where('tipo_comida_id', $tipoComidaId)
                 ->first();
}


    // ✔️ Cuenta la cantidad de tickets emitidos por fecha, tipo y si es becado
    public function contarTicketsEmitidos($fecha, $tipoComidaId, $becado)
    {
        return $this->db->table($this->table)
            ->join('students', 'students.id = tickets.student_id')
            ->where('fecha', $fecha)
            ->where('tipo_comida_id', $tipoComidaId)
            ->where('students.is_scholarship', $becado)
            ->countAllResults();
    }

    // ✔️ Listar todos los tickets con datos del estudiante
    public function listarConEstudiantes()
    {
        return $this->select('tickets.*, students.full_name')
                    ->join('students', 'students.id = tickets.student_id')
                    ->orderBy('tickets.fecha', 'DESC')
                    ->findAll();
    }
}
