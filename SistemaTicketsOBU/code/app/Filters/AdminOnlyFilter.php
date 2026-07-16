<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminOnlyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('perfil') !== 'Administrador') {
            session()->setFlashdata('mensaje', 'No tienes permisos para acceder a esa sección.');
            return redirect()->to(base_url('ticket/hoy'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere lógica post-petición
    }
}
