<?php

namespace App\Controllers;

use App\Models\RankingModel;
use App\Models\EquipoModel;
use App\Models\SalaModel;

class RankingController extends BaseController
{
    public function ranking()
    {
        $rankingModel = new RankingModel();

        $rankings = $rankingModel
            ->select('ranking.*, equipo.id as equipo_id, equipo.nombre as equipo_nombre, sala.nombre as sala_nombre')
            ->join('equipo', 'equipo.id = ranking.equipo_id')
            ->join('sala', 'sala.id = ranking.sala_id')
            ->orderBy('registrado_en DESC')
            ->findAll();

        return view('admin/ranking_list', ['rankings' => $rankings]);
    }

    public function obtener()
    {
        $rankingModel = new RankingModel();

        $rankings = $rankingModel
            ->select('ranking.*, equipo.id as equipo_id, equipo.nombre as equipo_nombre, sala.nombre as sala_nombre')
            ->join('equipo', 'equipo.id = ranking.equipo_id')
            ->join('sala', 'sala.id = ranking.sala_id')
            ->orderBy('ranking.registrado_en', 'DESC')
            ->findAll();

        return $this->response->setJSON(['data' => $rankings]);
    }

    public function editar($id)
    {
        $rankingModel = new RankingModel();
        $equipoModel = new EquipoModel();
        $salaModel = new SalaModel();

        $data['ranking'] = $rankingModel->find($id);
        $data['equipos'] = $equipoModel->findAll();
        $data['salas']   = $salaModel->findAll();

        return view('admin/ranking_editar', $data);
    }

    public function actualizar($id)
    {
        $rankingModel = new RankingModel();

        $data = [
            'equipo_id' => $this->request->getPost('equipo_id'),
            'sala_id'   => $this->request->getPost('sala_id'),
            'tiempo'    => (int) $this->request->getPost('tiempo'),
            'fecha'     => $this->request->getPost('fecha'),
            'puntaje'   => $this->request->getPost('puntaje'),
        ];

        $rankingModel->update($id, $data);

        return redirect()->to(base_url('admin/ranking'))
            ->with('success', 'Ranking actualizado correctamente.');
    }

    public function actualizarRanking($id)
    {
        $rankingModel = new \App\Models\RankingModel();
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Datos JSON no proporcionados.'
            ]);
        }

        $tiempoStr = $data['tiempo'];
        $minutos = 0;
        if (strpos($tiempoStr, ':') !== false) {
            $parts = explode(':', $tiempoStr);
            if (count($parts) === 3) {
                $minutos = ((int)$parts[0]) * 60 + (int)$parts[1];
            } elseif (count($parts) === 2) {
                $minutos = (int)$parts[0];
            }
        } elseif (is_numeric($tiempoStr)) {
            $minutos = (int)$tiempoStr;
        }

        $rankingModel->update($id, [
            'equipo_id' => $data['equipo_id'],
            'sala_id'   => $data['sala_id'],
            'tiempo'    => $minutos,
            'puntaje'   => $data['puntaje'],
        ]);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Ranking actualizado vía API JSON.'
        ]);
    }

    public function crearRankingAPI()
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['equipo_id'], $data['sala_id'], $data['tiempo'], $data['fecha'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Faltan campos requeridos: equipo_id, sala_id, tiempo, fecha.'
            ]);
        }

        $rankingModel = new \App\Models\RankingModel();

        $tiempoStr = $data['tiempo'];
        $minutos = 0;
        if (strpos($tiempoStr, ':') !== false) {
            $parts = explode(':', $tiempoStr);
            if (count($parts) === 3) {
                $minutos = ((int)$parts[0]) * 60 + (int)$parts[1];
            } elseif (count($parts) === 2) {
                $minutos = (int)$parts[0];
            }
        } elseif (is_numeric($tiempoStr)) {
            $minutos = (int)$tiempoStr;
        }

        $rankingModel->insert([
            'equipo_id' => $data['equipo_id'],
            'sala_id'   => $data['sala_id'],
            'tiempo'    => $minutos,
            'fecha'     => $data['fecha'],
            'puntaje'   => isset($data['puntaje']) ? $data['puntaje'] : 0
        ]);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Ranking registrado correctamente.',
            'equipo_id' => $data['equipo_id']
        ]);
    }
}
