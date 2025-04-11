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

        $tiempo = (int) $this->request->getPost('tiempo');
        $cantidadIntegrantes = (int) $this->request->getPost('cantidad_integrantes');

        $data = [
            'equipo_id' => $this->request->getPost('equipo_id'),
            'sala_id'   => $this->request->getPost('sala_id'),
            'tiempo'    => $tiempo,
            'puntaje'   => $this->request->getPost('puntaje'),
            'fecha'     => $this->request->getPost('fecha') ?? date('Y-m-d'),
            'cantidad_integrantes' => $cantidadIntegrantes
        ];

        $rankingModel->update($id, $data);

        return redirect()->to(base_url('admin/ranking'))
            ->with('success', 'Ranking actualizado correctamente.');
    }

    public function actualizarRanking($id)
    {
        $rankingModel = new RankingModel();
        $data = $this->request->getJSON(true);

        $tiempoStr = $data['tiempo'];
        $minutos = is_numeric($tiempoStr) ? (int)$tiempoStr : 0;

        $rankingModel->update($id, [
            'equipo_id' => $data['equipo_id'],
            'sala_id'   => $data['sala_id'],
            'tiempo'    => $minutos,
            'puntaje'   => $data['puntaje'],
            'cantidad_integrantes' => $data['cantidad_integrantes'] ?? 0,
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

        $minutos = is_numeric($data['tiempo']) ? (int)$data['tiempo'] : 0;

        $rankingModel = new RankingModel();
        $rankingModel->insert([
            'equipo_id' => $data['equipo_id'],
            'sala_id'   => $data['sala_id'],
            'tiempo'    => $minutos,
            'fecha'     => $data['fecha'],
            'puntaje'   => $data['puntaje'] ?? 0,
            'cantidad_integrantes' => $data['cantidad_integrantes'] ?? 0,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Ranking registrado correctamente.',
            'equipo_id' => $data['equipo_id']
        ]);
    }

    public function registrarResultado()
    {
        $json = $this->request->getJSON(true);

        if (
            !isset($json['codigo_equipo']) ||
            !isset($json['codigo_resultado']) ||
            !isset($json['sala_id'])
        ) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Debe proporcionar el código del equipo, el código de resultado y el ID de la sala.'
            ]);
        }

        $codigoEquipo = $json['codigo_equipo'];
        $codigoResultado = $json['codigo_resultado'];
        $salaId = $json['sala_id'];

        $equipoModel = new EquipoModel();
        $equipo = $equipoModel->where('codigo', $codigoEquipo)->first();

        if (!$equipo) {
            return $this->response->setStatusCode(404)->setJSON([
                'error' => 'Equipo no encontrado.'
            ]);
        }

        preg_match_all('/"([^"]+)"/', $codigoResultado, $matches);

        if (!isset($matches[1]) || count($matches[1]) !== 3) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Formato del código de resultado inválido. Se requieren exactamente 3 valores entre comillas dobles.'
            ]);
        }

        $desencriptar = function ($cadena) {
            try {
                return (int) base64_decode(substr($cadena, 2));
            } catch (\Throwable $e) {
                return null;
            }
        };

        $minutos = $desencriptar($matches[1][0]);
        $cantidadIntegrantes = $desencriptar($matches[1][1]);
        $puntaje = $desencriptar($matches[1][2]);

        if ($minutos === null || $cantidadIntegrantes === null || $puntaje === null) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'No se pudo desencriptar correctamente uno o más valores del código.'
            ]);
        }

        $rankingModel = new RankingModel();
        $rankingModel->insert([
            'equipo_id' => $equipo['id'],
            'sala_id'   => $salaId,
            'tiempo'    => $minutos,
            'puntaje'   => $puntaje,
            'cantidad_integrantes' => $cantidadIntegrantes,
            'fecha'     => date('Y-m-d')
        ]);

        return $this->response->setJSON([
            'message' => 'Resultado registrado correctamente.',
            'equipo'  => $codigoEquipo,
            'minutos' => $minutos,
            'cantidad_integrantes' => $cantidadIntegrantes,
            'puntaje' => $puntaje
        ])->setStatusCode(201);
    }
}
