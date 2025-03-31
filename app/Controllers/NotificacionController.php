<?php

namespace App\Controllers;

use App\Models\NotificacionModel;
use App\Models\ReservaModel;

class NotificacionController extends BaseController
{
    public function obtener()
    {
        $reservaModel = new \App\Models\ReservaModel();

        $pendientes = $reservaModel
            ->select('reserva.id, cliente.nombre_completo, reserva.fecha, sala.nombre AS sala_nombre')
            ->join('cliente', 'cliente.id = reserva.cliente_id')
            ->join('sala', 'sala.id = reserva.sala_id')
            ->where('reserva.estado', 'pendiente')
            ->orderBy('reserva.created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON(['data' => $pendientes]);
    }


    public function marcarLeida($id)
    {
        $model = new NotificacionModel();
        $model->update($id, ['leida' => 1]);
        return $this->response->setJSON(['success' => true]);
    }
}
