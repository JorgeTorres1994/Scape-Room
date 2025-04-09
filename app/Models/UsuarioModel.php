<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios_admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'email', 'password', 'rol', 'estado', 'created_at'];

    public function obtenerUsuarioPorEmail($email)
    {
        return $this->where('email', $email)
            ->where('estado', 'activo')
            ->first();
    }
}
