<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'cliente';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nombre_completo', 'telefono', 'correo'];
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'creado_en';
}
