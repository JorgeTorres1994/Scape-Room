<?php

namespace App\Controllers;

use App\Models\HorarioModel;

class HorarioController extends BaseController
{
    public function horarios()
    {
        $horarioModel = new HorarioModel();

        $horarios = $horarioModel
            ->select('horario.*, sala.nombre as sala_nombre')
            ->join('sala', 'sala.id = horario.sala_id')
            ->orderBy('sala_id ASC, hora ASC')
            ->findAll();

        return view('admin/horarios_list', ['horarios' => $horarios]);
    }

    public function obtener()
    {
        $horarioModel = new \App\Models\HorarioModel();

        $horarios = $horarioModel
            ->select('horario.*, sala.nombre AS sala_nombre')
            ->join('sala', 'sala.id = horario.sala_id')
            ->orderBy('sala_id ASC, hora ASC')
            ->findAll();

        return $this->response->setJSON(['data' => $horarios]);
    }
}
