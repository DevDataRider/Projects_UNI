<?php

namespace App\Controllers;

use App\Models\AsistenciasModel;
use App\Models\TicketModel;
use CodeIgniter\Controller;

class Asistencias extends Controller
{
    protected $asistenciasModel;
    protected $ticketsModel;

    public function __construct()
    {
        $this->asistenciasModel = new AsistenciasModel();
        $this->ticketsModel = new TicketModel();
    }

    public function index()
    {
        $data['asistencias'] = $this->asistenciasModel->obtenerAsistenciasConTickets();
        $data['tickets'] = $this->ticketsModel->where('estado', 'generado')->findAll();
        $data['total_asistencias'] = $this->asistenciasModel->contarAsistencias();

        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('asistencias/listaasistencias', $data);
        echo view('layout/footer');
    }

    public function insertar()
    {
        $ticket_id = $this->request->getPost('ticket_id');

        $datos = [
            'ticket_id' => $ticket_id,
            'fecha_ingreso' => date('Y-m-d H:i:s')  // Registra fecha y hora actual
        ];

        $this->asistenciasModel->insert($datos);

        // Marcar ticket como usado automáticamente
        $this->ticketsModel->update($ticket_id, ['estado' => 'usado']);

        return redirect()->to(base_url('asistencias'));
    }

    public function editar()
    {
        $id = $this->request->getPost('id');
        $fecha_ingreso = $this->request->getPost('fecha_ingreso');

        $this->asistenciasModel->update($id, [
            'fecha_ingreso' => $fecha_ingreso
        ]);

        return redirect()->to(base_url('asistencias'));
    }

    public function eliminar($id)
    {
        $this->asistenciasModel->delete($id);
        return redirect()->to(base_url('asistencias'));
    }
}
