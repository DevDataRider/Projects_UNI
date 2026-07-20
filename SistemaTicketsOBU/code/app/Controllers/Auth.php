<?php

namespace App\Controllers;

use App\Models\LoginModels; // estudiantes
use App\Models\AdminModel;  // admin (usuarios)

class Auth extends BaseController
{
    protected $LoginModels;
    protected $AdminModel;

    public function __construct()
    {
        $this->LoginModels = new LoginModels(); // Tabla students
        $this->AdminModel = new AdminModel();   // Tabla usuarios
    }

    public function index()
    {
        // El filtro CSRF redirige aquí con flashdata cuando el token expiró o no coincidía
        // (p. ej. al borrar cookies del navegador); se muestra como el resto de errores de login.
        $csrfError = session()->getFlashdata('error');

        return view('admin/login', [
            'error' => $csrfError ? 'Tu sesión había expirado. Por favor, vuelve a intentarlo.' : null,
        ]);
    }

    public function SesionLogin()
    {
        $codigo = $this->request->getPost("usuario");   // university_code
        $dni    = $this->request->getPost("password");  // dni

        // 🧑‍🎓 Buscar estudiante
        $student = $this->LoginModels
            ->where('university_code', $codigo)
            ->where('dni', $dni)
            ->first();

        if ($student) {
           session()->regenerate(true);
           session()->set([
    'id'               => $student['id'], // si lo usas para admin, lo puedes mantener
    'id_estudiante'    => $student['id'], // ✅ clave para que Ticket funcione
    'perfil'           => 'Estudiante',
    'university_code'  => $student['university_code'],
    'full_name'        => $student['full_name'] ?? ($student['nombre'] ?? ''),
    'is_scholarship'   => $student['is_scholarship'] ?? null,
    'isLoggedIn'       => true
]);

            return redirect()->to(base_url('cajas'));
        }

        // 🧑‍💼 Buscar administrador (tabla usuarios)
        $admin = $this->AdminModel
            ->where('university_code', $codigo)
            ->where('dni', $dni)
            ->first();

        if ($admin) {
            session()->regenerate(true);
            session()->set([
                'id'               => $admin['id'],
                'perfil'          => $admin['perfil'],
                'university_code' => $admin['university_code'],
                'full_name'       => $admin['nombre'],
                'isLoggedIn'      => true
            ]);
            return redirect()->to(base_url('caja_admin'));
        }

        // ❌ Si no se encuentra el usuario
        return view('admin/login', [
            'error' => 'Código universitario o DNI incorrecto'
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
