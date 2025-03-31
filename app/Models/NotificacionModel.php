<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionModel extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['mensaje', 'reserva_id', 'leida'];
    protected $useTimestamps = true;
    protected $createdField = 'creada_en';
}
