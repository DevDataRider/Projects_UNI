<?php

namespace App\Controllers;

use App\Models\IncidenciasModel;
use App\Models\EstudiantesModel;
use CodeIgniter\Controller;

class Incidencias extends Controller
{
    protected $incidenciasModel;

    public function __construct()
    {
        $this->incidenciasModel = new IncidenciasModel();
    }

    public function index()
    {
        $data['incidencias'] = $this->incidenciasModel->obtenerIncidenciasConEstudiantes();

        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('incidencias/listaincidencias', $data);
        echo view('layout/footer');
    }

    public function insertar()
    {
        $datos = [
            'student_id' => $this->request->getPost('student_id'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha' => $this->request->getPost('fecha')
        ];

        $this->incidenciasModel->insert($datos);
        return redirect()->to(base_url('incidencias'));
    }

    public function editar()
    {
        $id = $this->request->getPost('id');
        $datos = [
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha' => $this->request->getPost('fecha')
        ];

        $this->incidenciasModel->update($id, $datos);
        return redirect()->to(base_url('incidencias'));
    }

    public function eliminar($id)
    {
        $this->incidenciasModel->delete($id);
        return redirect()->to(base_url('incidencias'));
    }

    public function registrarPorEstudiante()
{
    $data = [
        'student_id' => session()->get('id'),
        'descripcion' => $this->request->getPost('descripcion'),
        'fecha' => date('Y-m-d H:i:s')
    ];

    $this->incidenciasModel->insert($data);

    return redirect()->to(base_url('panel_estudiante'))->with('success', 'Incidencia registrada');
}

}


