<?php

namespace App\Models;

use CodeIgniter\Model;

class SalaModel extends Model
{
    protected $table      = 'sala';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre', 'descripcion', 'min_jugadores', 'max_jugadores',
        'duracion', 'dificultad', 'rating', 'tags',
        'imagen', 'destacado', 'reservas_hoy'
    ];

    protected $returnType     = 'array';
    protected $useTimestamps  = true;
}
