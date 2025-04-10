<?php

namespace App\Models;

use CodeIgniter\Model;

class IntegranteModel extends Model
{
    protected $table = 'integrante';
    protected $primaryKey = 'id';
    protected $allowedFields = ['equipo_id', 'nombre'];
    protected $returnType = 'array';
}
