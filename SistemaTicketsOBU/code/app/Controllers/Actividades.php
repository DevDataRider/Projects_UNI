<?php

namespace App\Controllers;

use App\Models\ActividadEstudiantesModel;
use App\Models\EstudiantesModel;
use CodeIgniter\Controller;

class Actividades extends Controller
{
    protected $actividadModel;
    protected $estudiantesModel;

    public function __construct()
    {
        $this->actividadModel = new ActividadEstudiantesModel();
        $this->estudiantesModel = new EstudiantesModel();
    }

    public function index()
    {
        $data['actividades'] = $this->actividadModel->obtenerActividadesConEstudiantes();
        $data['estudiantes'] = $this->estudiantesModel->findAll();  // ✅ Aquí obtenemos todos los estudiantes

        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('actividades/listaactividades', $data);
        echo view('layout/footer');
    }

    public function insertar()
    {
        $datos = [
            'student_id' => $this->request->getPost('student_id'),
            'accion' => $this->request->getPost('accion'),
        ];

        $this->actividadModel->insert($datos);
        return redirect()->to(base_url('actividades'));
    }

    public function editar()
    {
        $id = $this->request->getPost('id');
        $datos = [
            'accion' => $this->request->getPost('accion'),
        ];

        $this->actividadModel->update($id, $datos);
        return redirect()->to(base_url('actividades'));
    }

    public function eliminar($id)
    {
        $this->actividadModel->delete($id);
        return redirect()->to(base_url('actividades'));
    }

    public function registrarPorEstudiante()
{
    $data = [
        'student_id' => session()->get('id'),
        'accion' => $this->request->getPost('accion'),
        'fecha' => date('Y-m-d H:i:s')
    ];

    $this->actividadModel->insert($data);

    return redirect()->to(base_url('panel_estudiante'))->with('success', 'Actividad registrada');
}

}
