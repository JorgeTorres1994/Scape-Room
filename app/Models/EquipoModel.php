<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoModel extends Model
{
    protected $table      = 'equipo';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nombre', 'codigo'];
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'creado_en';
    protected $updatedField  = '';
}
