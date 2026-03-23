<?php

namespace App\Controllers;

use App\Models\EstudianteModel;
use CodeIgniter\Controller;

class EstudiantePerfil extends BaseController
{
    public function index()
    {
        $id = session()->get('id_estudiante');
        $modelo = new EstudianteModel();

        $data['perfil'] = $modelo->find($id);

        return view('Layout/header')
            . view('Layout/aside')
            . view('EstudiantePerfil/index', $data)
            . view('Layout/footer');
    }

    public function actualizar()
    {
        $id = session()->get('id_estudiante');
        $modelo = new EstudianteModel();

        $datos = [
            'full_name' => $this->request->getPost('full_name'),
            'email_institutional' => $this->request->getPost('email_institutional'),
        ];

        $modelo->update($id, $datos);
        session()->setFlashdata('success', 'Perfil actualizado correctamente.');
        return redirect()->to(base_url('perfil'));
    }
}
