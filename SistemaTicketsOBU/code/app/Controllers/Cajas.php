<?php

namespace App\Controllers;

use App\Libraries\HorarioComedor;
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
        $tipoComidaId = HorarioComedor::turnoActual();

        $plato = null;
        $ticket = null;

        if ($tipoComidaId !== null) {
            $platoModel = new PlatoModel();
            $plato = $platoModel->obtenerPlatoDelDia(date('Y-m-d'), $tipoComidaId);

            // ✅ Obtener ticket del estudiante si ya fue generado hoy para el turno actual
            $ticketModel = new TicketModel();
            $ticket = $ticketModel
                ->where('student_id', session('id_estudiante'))
                ->where('fecha', date('Y-m-d'))
                ->where('tipo_comida_id', $tipoComidaId)
                ->first();
        }

        $data = [
            "estudiantes" => $this->CajasModels->getEstudiantes(),
            "plato"       => $plato,
            "tickets"     => $this->CajasModels->getTickets(),
            "ticket"      => $ticket, // ✅ pasamos esto a la vista
            "turnoNombre" => $tipoComidaId !== null ? HorarioComedor::nombre($tipoComidaId) : null,
        ];

        echo view('layout/header');
        echo view('layout/aside');
        echo view('inicio/cajas', $data);
        echo view('layout/footer');
    }
}
