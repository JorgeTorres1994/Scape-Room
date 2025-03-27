<?php

namespace App\Controllers;

use App\Models\RankingModel;

class RankingController extends BaseController
{
    public function rankings()
    {
        $rankingModel = new RankingModel();

        $rankings = $rankingModel
            ->select('ranking.*, equipo.nombre AS equipo_nombre, sala.nombre AS sala_nombre')
            ->join('equipo', 'equipo.id = ranking.equipo_id')
            ->join('sala', 'sala.id = ranking.sala_id')
            ->orderBy('tiempo ASC')
            ->findAll();

        return view('admin/ranking_list', ['rankings' => $rankings]);
    }
}
