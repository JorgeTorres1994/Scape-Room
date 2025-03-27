<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservaModel extends Model
{
    protected $table            = 'reserva';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['cliente_id', 'sala_id', 'horario_id', 'fecha', 'cantidad_jugadores', 'estado'];
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $createdField     = 'created_at';
}
