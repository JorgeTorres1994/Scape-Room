<?php

namespace App\Models;

use CodeIgniter\Model;

class RankingModel extends Model
{
    protected $table            = 'ranking';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['equipo_id', 'sala_id', 'tiempo', 'puntaje'];
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $createdField     = 'registrado_en';
}
