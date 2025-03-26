<?php

namespace App\Models;

use CodeIgniter\Model;

class HorarioModel extends Model
{
    protected $table            = 'horario';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['sala_id', 'hora', 'activo'];
    protected $returnType       = 'array';
    public    $useTimestamps    = false;
}
