<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;

class Estudiantes extends BaseController
{
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = new EstudiantesModel();
    }

    public function index()
    {
        $data = [
            "estudiantes" => $this->studentModel->getEstudiantes()
        ];

        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('estudiantes/listaestudiantes', $data);
        echo view('layout/footer');
    }

    public function insertar()
    {
        $datos = [
            "full_name" => $this->request->getPost("full_name"),
            "dni" => $this->request->getPost("dni"),
            "university_code" => $this->request->getPost("university_code"),
            "email_institutional" => $this->request->getPost("email_institutional"),
            "facultad" => $this->request->getPost("facultad"),
            "mobile" => $this->request->getPost("mobile"),
            "gender" => $this->request->getPost("gender"),
            "is_scholarship" => $this->request->getPost("is_scholarship")
        ];

        $respuesta = $this->studentModel->crearEstudiante($datos);

        if ($respuesta != null) {
            return redirect()->to(base_url('estudiantes'));
        } else {
            $data = [
                "EstudianteError" => "No se pudo registrar el estudiante",
                "estudiantes" => $this->studentModel->getEstudiantes()
            ];
            echo view('layout/header');
            echo view('layout/aside_admin');
            echo view('estudiantes/listaestudiantes', $data);
            echo view('layout/footer');
        }
    }

    public function ajaxEstudiante($id)
    {
        $respuesta = $this->studentModel->getEditarEstudiante($id);
        echo json_encode($respuesta);
    }

    public function editar()
    {
        $id = $this->request->getPost("id");

        $datos = [
            "full_name" => $this->request->getPost("full_name"),
            "dni" => $this->request->getPost("dni"),
            "university_code" => $this->request->getPost("university_code"),
            "email_institutional" => $this->request->getPost("email_institutional"),
            "facultad" => $this->request->getPost("facultad"),
            "mobile" => $this->request->getPost("mobile"),
            "gender" => $this->request->getPost("gender"),
            "is_scholarship" => $this->request->getPost("is_scholarship")
        ];

        $respuesta = $this->studentModel->updateEstudiante($id, $datos);

        if ($respuesta != null) {
            return redirect()->to(base_url('estudiantes'));
        } else {
            $data = [
                "editarEstudianteError" => "No se pudo editar el estudiante",
                "estudiantes" => $this->studentModel->getEstudiantes()
            ];
            echo view('layout/header');
            echo view('layout/aside_admin');
            echo view('estudiantes/listaestudiantes', $data);
            echo view('layout/footer');
        }
    }

    public function eliminar($id)
    {
        $respuesta = $this->studentModel->eliminarEstudiante($id);

        if ($respuesta != null) {
            return redirect()->to(base_url('estudiantes'));
        } else {
            $data = [
                "EliminarEstudianteError" => "No se pudo eliminar el estudiante",
                "estudiantes" => $this->studentModel->getEstudiantes()
            ];
            echo view('layout/header');
            echo view('layout/aside_admin');
            echo view('estudiantes/listaestudiantes', $data);
            echo view('layout/footer');
        }
    }
    
}
