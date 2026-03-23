<?php

namespace App\Controllers;

use App\Models\PlatoModel;
use CodeIgniter\Controller;

class Platos extends Controller
{
    protected $platoModel;

    public function __construct()
    {
        $this->platoModel = new PlatoModel();
    }

    public function index()
    {
        $data['platos'] = $this->platoModel->obtenerPlatosConTipo();
        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('platos/listaplatos', $data);
        echo view('layout/footer');
    }

    public function insertar()
    {
        $datos = [
            'fecha' => $this->request->getPost('fecha'),
            'tipo_comida_id' => $this->request->getPost('tipo_comida_id'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $this->platoModel->insert($datos);
        return $this->response->setJSON(['status' => 'ok']);
    }

    public function editar()
    {
        $id = $this->request->getPost('id');
        $datos = [
            'fecha' => $this->request->getPost('fecha'),
            'tipo_comida_id' => $this->request->getPost('tipo_comida_id'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $this->platoModel->update($id, $datos);
        return $this->response->setJSON(['status' => 'ok']);
    }

    public function eliminar($id)
    {
        $this->platoModel->delete($id);
        return redirect()->to(base_url('platos'));
    }
}
