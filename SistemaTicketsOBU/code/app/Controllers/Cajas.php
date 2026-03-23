<?php

namespace App\Controllers;

use App\Models\CajasModels;
use App\Models\PlatoModel;
use App\Models\TicketModel; // ✅ Agrega esto

class Cajas extends BaseController
{
    protected $CajasModels;

    public function __construct()
    {
        $this->CajasModels = new CajasModels();
    }

    public function index()
    {
        // Obtener turno según hora actual
        $horaActual = date('H:i:s');
        $turno = null;

        if ($horaActual >= '07:00:00' && $horaActual <= '08:30:00') {
            $turno = 'desayuno';
        } elseif ($horaActual >= '12:00:00' && $horaActual <= '14:00:00') {
            $turno = 'almuerzo';
        } elseif ($horaActual >= '18:00:00' && $horaActual <= '19:30:00') {
            $turno = 'cena';
        }

        $plato = null;
        if ($turno) {
            $platoModel = new PlatoModel();
            $plato = $platoModel
                ->where('fecha', date('Y-m-d'))
                ->first();
        }

        // ✅ Obtener ticket del estudiante si ya fue generado hoy
        $ticketModel = new TicketModel();
        $ticket = $ticketModel
            ->where('student_id', session('id_estudiante'))
            ->where('fecha', date('Y-m-d'))
            ->where('tipo_comida_id', 1)
            ->first();

        $data = [
            "estudiantes" => $this->CajasModels->getEstudiantes(),
            "plato"       => $plato,
            "tickets"     => $this->CajasModels->getTickets(),
            "ticket"      => $ticket // ✅ pasamos esto a la vista
        ];

        echo view('layout/header');
        echo view('layout/aside');
        echo view('inicio/cajas', $data);
        echo view('layout/footer');
    }
}
