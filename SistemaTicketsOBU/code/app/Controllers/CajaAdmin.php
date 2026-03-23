<?php

namespace App\Controllers;

use App\Models\CajasModels;

class CajaAdmin extends BaseController
{
    protected $CajasModels;

    public function __construct()
    {
        $this->CajasModels = new CajasModels();
    }

    public function index()
    {
        $data = [
            "estudiantes"       => $this->CajasModels->getEstudiantes(),
            "platos"            => $this->CajasModels->getPlatosDelDia(),
            "tickets"           => $this->CajasModels->getTickets(),
            "asistencias"       => $this->CajasModels->getTotalAsistencias(),
            "incidencias"       => $this->CajasModels->getTotalIncidencias(),
            "actividad"         => $this->CajasModels->getTotalActividad(),
            "total_becados"     => $this->CajasModels->getTotalBecados(),
            "total_no_becados"  => $this->CajasModels->getTotalNoBecados()
        ];

        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('inicio/caja_admin', $data);
        echo view('layout/footer');
    }
}
