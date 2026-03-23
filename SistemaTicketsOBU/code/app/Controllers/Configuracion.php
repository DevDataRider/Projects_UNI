<?php
namespace App\Controllers;

use App\Models\ConfiguracionModel;
use CodeIgniter\Controller;

class Configuracion extends Controller
{
    protected $configuracionModel;

    public function __construct()
    {
        $this->configuracionModel = new ConfiguracionModel();
    }

    public function index()
    {
        $data['configuraciones'] = $this->configuracionModel->obtenerTodas();

        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('configuracion/listaconfiguracion', $data);
        echo view('layout/footer');
    }

    public function editar()
    {
        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');

        $this->configuracionModel->actualizarValor($id, $valor);

        return redirect()->to(base_url('configuracion'));
    }
}
