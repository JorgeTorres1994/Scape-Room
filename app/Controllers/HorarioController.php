<?php

namespace App\Controllers;

use App\Models\HorarioModel;
use App\Models\SalaModel;

class HorarioController extends BaseController
{
    public function horarios()
    {
        $horarioModel = new HorarioModel();
        $salaModel    = new SalaModel();

        $horarios = $horarioModel
            ->select('horario.*, sala.nombre as sala_nombre')
            ->join('sala', 'sala.id = horario.sala_id')
            ->orderBy('sala_id ASC, hora ASC')
            ->findAll();

        return view('admin/horarios_list', ['horarios' => $horarios]);
    }
}
