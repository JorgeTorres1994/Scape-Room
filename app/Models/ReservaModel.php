<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservaModel extends Model
{
    protected $table         = 'reserva';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';

    protected $allowedFields = [
        'cliente',
        'correo',
        'telefono',
        'sala_id',
        'horario_id',
        'fecha',
        'cantidad_jugadores',
        'estado',
        'metodo_pago',
        'precio_total',
        'created_at'
    ];

    protected $useTimestamps = false; // Tu tabla ya maneja created_at por default
    protected $createdField  = 'created_at';
}
