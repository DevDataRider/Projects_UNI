<?php

namespace App\Controllers;

use App\Models\TicketModel;
use CodeIgniter\Controller;

class Tickets extends Controller
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
    }

    // ✔️ Método principal para el administrador: listar todos los tickets
    public function index()
    {
        $tickets = $this->ticketModel->listarConEstudiantes();

        $data = [
            'tickets' => $tickets,
        ];

        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('tickets/listatickets', $data);
        echo view('layout/footer');
    }

    // ✔️ Método para eliminar ticket desde admin
    public function eliminar($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket no encontrado.');
        }

        $this->ticketModel->delete($id);

        return redirect()->back()->with('success', 'Ticket eliminado correctamente.');
    }
}
