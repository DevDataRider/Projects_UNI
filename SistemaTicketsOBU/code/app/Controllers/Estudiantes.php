<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;

class Estudiantes extends BaseController
{
    protected $studentModel;

    public const FACULTADES = [
        'FIIS',
        'FIQ',
        'FIEE',
        'FIME',
        'FIPA',
        'FIARN',
        'CIENCIAS ECONOMICAS',
        'CONTABILIDAD',
        'FCS',
        'MATEMATICA',
    ];

    public function __construct()
    {
        $this->studentModel = new EstudiantesModel();
    }

    /**
     * JSON de error para las llamadas AJAX de los modales, incluyendo el token
     * CSRF vigente: como este viaja sin recargar la página, si no se refresca
     * el token en el formulario cada reintento posterior falla por CSRF aunque
     * los datos ya estén correctos (el token rota en cada request por
     * Config\Security::$regenerate).
     */
    private function respuestaError(array $mensajes, int $status = 422)
    {
        return $this->response->setStatusCode($status)->setJSON([
            'error' => true,
            'messages' => $mensajes,
            'csrf' => [
                'name' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }

    private function reglasValidacion(): array
    {
        $facultades = implode(',', self::FACULTADES);

        return [
            'full_name' => ['label' => 'Nombre Completo', 'rules' => 'required'],
            'dni' => [
                'label' => 'DNI',
                'rules' => 'required|regex_match[/^\d{8}$/]',
                'errors' => ['regex_match' => 'El DNI debe tener exactamente 8 dígitos.'],
            ],
            'university_code' => [
                'label' => 'Código Universitario',
                'rules' => 'required|regex_match[/^\d{10}$/]',
                'errors' => ['regex_match' => 'El código universitario debe tener exactamente 10 dígitos.'],
            ],
            'email_institutional' => [
                'label' => 'Correo Institucional',
                'rules' => 'required|valid_email|regex_match[/@unac\.edu\.pe$/]',
                'errors' => ['regex_match' => 'El correo debe ser del dominio @unac.edu.pe.'],
            ],
            'facultad' => [
                'label' => 'Facultad',
                'rules' => "required|in_list[{$facultades}]",
                'errors' => ['in_list' => 'Selecciona una facultad válida.'],
            ],
            'mobile' => [
                'label' => 'Celular',
                'rules' => 'required|regex_match[/^\+51\d{9}$/]',
                'errors' => ['regex_match' => 'El celular debe tener el formato +51 seguido de 9 dígitos.'],
            ],
            'gender' => ['label' => 'Género', 'rules' => 'required'],
            'is_scholarship' => ['label' => '¿Becado?', 'rules' => 'required'],
        ];
    }

    public function index()
    {
        $data = [
            "estudiantes" => $this->studentModel->getEstudiantes(),
            "facultades" => self::FACULTADES,
        ];

        echo view('layout/header');
        echo view('layout/aside_admin');
        echo view('estudiantes/listaestudiantes', $data);
        echo view('layout/footer');
    }

    public function insertar()
    {
        if (! $this->validate($this->reglasValidacion())) {
            return $this->respuestaError($this->validator->getErrors());
        }

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

        try {
            $respuesta = $this->studentModel->crearEstudiante($datos);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return $this->respuestaError(['general' => $this->mensajeErrorDuplicado($e)]);
        }

        if ($respuesta != null) {
            return redirect()->to(base_url('estudiantes'));
        } else {
            return $this->respuestaError(['general' => 'No se pudo registrar el estudiante']);
        }
    }

    private function mensajeErrorDuplicado(\Throwable $e): string
    {
        if (stripos($e->getMessage(), 'university_code') !== false) {
            return 'Ya existe un estudiante registrado con ese código universitario.';
        }
        if (stripos($e->getMessage(), 'Duplicate entry') !== false) {
            return 'Ya existe un estudiante registrado con esos datos.';
        }
        return 'No se pudo guardar el estudiante.';
    }

    public function ajaxEstudiante($id)
    {
        $respuesta = $this->studentModel->getEditarEstudiante($id);
        echo json_encode($respuesta);
    }

    public function editar()
    {
        $id = $this->request->getPost("id");

        if (! $this->validate($this->reglasValidacion())) {
            return $this->respuestaError($this->validator->getErrors());
        }

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

        try {
            $respuesta = $this->studentModel->updateEstudiante($id, $datos);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return $this->respuestaError(['general' => $this->mensajeErrorDuplicado($e)]);
        }

        if ($respuesta != null) {
            return redirect()->to(base_url('estudiantes'));
        } else {
            return $this->respuestaError(['general' => 'No se pudo editar el estudiante']);
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
                "estudiantes" => $this->studentModel->getEstudiantes(),
                "facultades" => self::FACULTADES,
            ];
            echo view('layout/header');
            echo view('layout/aside_admin');
            echo view('estudiantes/listaestudiantes', $data);
            echo view('layout/footer');
        }
    }
    
}
