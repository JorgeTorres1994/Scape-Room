<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function index()
    {
        return view('admin/login');
    }

    public function login()
    {
        $session = session();
        $model = new \App\Models\UsuarioModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $model->where('email', $email)->first();

        if ($usuario && $usuario['estado'] === 'activo') {
            // Comparación sin encriptar
            if ($usuario['password'] === $password) {
                // Guardar sesión
                $session->set([
                    'usuario_id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'email' => $usuario['email'],
                    'rol' => $usuario['rol'],
                    'logueado' => true
                ]);
                return redirect()->to('/admin/dashboard'); // Redirige al dashboard
            }
        }

        return redirect()->back()->withInput()->with('error', 'Correo o contraseña incorrectos.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
