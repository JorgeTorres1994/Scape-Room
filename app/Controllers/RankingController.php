<?php

namespace App\Controllers;

use App\Models\RankingModel;
use App\Models\EquipoModel;
use App\Models\SalaModel;

class RankingController extends BaseController
{
    // Muestra la vista con todos los rankings (cargados desde PHP)
    public function ranking()
    {
        $rankingModel = new RankingModel();

        $rankings = $rankingModel
            ->select('ranking.*, equipo.nombre as equipo_nombre, sala.nombre as sala_nombre')
            ->join('equipo', 'equipo.id = ranking.equipo_id')
            ->join('sala', 'sala.id = ranking.sala_id')
            ->orderBy('registrado_en DESC')
            ->findAll();

        return view('admin/ranking_list', ['rankings' => $rankings]);
    }

    // Devuelve los rankings como JSON para AJAX o API
    public function obtener()
    {
        $rankingModel = new RankingModel();

        $rankings = $rankingModel
            ->select('ranking.*, equipo.nombre as equipo_nombre, sala.nombre as sala_nombre')
            ->join('equipo', 'equipo.id = ranking.equipo_id')
            ->join('sala', 'sala.id = ranking.sala_id')
            ->orderBy('ranking.registrado_en', 'DESC')
            ->findAll();

        return $this->response->setJSON(['data' => $rankings]);
    }

    // Muestra el formulario para editar un ranking
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

    // Guarda los cambios del ranking editado
    public function actualizar($id)
    {
        $rankingModel = new RankingModel();

        $data = [
            'equipo_id' => $this->request->getPost('equipo_id'),
            'sala_id'   => $this->request->getPost('sala_id'),
            'tiempo' => sprintf(
                '%02d:%02d:%02d',
                (int) $this->request->getPost('hora'),
                (int) $this->request->getPost('minuto'),
                (int) $this->request->getPost('segundo')
            ),
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

        // Obtener datos desde JSON
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Datos JSON no proporcionados.'
            ]);
        }

        // Validación básica
        $required = ['equipo_id', 'sala_id', 'tiempo', 'puntaje'];
        foreach ($required as $campo) {
            if (!isset($data[$campo])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => "Falta el campo obligatorio: $campo"
                ]);
            }
        }

        $rankingModel->update($id, [
            'equipo_id' => $data['equipo_id'],
            'sala_id'   => $data['sala_id'],
            'tiempo'    => $data['tiempo'],
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

        if (!$data || !isset($data['nombre_equipo'], $data['sala_id'], $data['tiempo'], $data['fecha'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Faltan campos requeridos: nombre_equipo, sala_id, tiempo, fecha.'
            ]);
        }

        $equipoModel = new \App\Models\EquipoModel();
        $rankingModel = new \App\Models\RankingModel();

        // Crear equipo
        $equipoId = $equipoModel->insert([
            'nombre' => $data['nombre_equipo'],
            'estado' => 'activo'
        ], true); // true => get insertID

        // Generar código aleatorio
        $codigo = 'EQP-' . strtoupper(substr(md5(uniqid()), 0, 5));

        // Registrar ranking
        $rankingModel->insert([
            'equipo_id' => $equipoId,
            'sala_id' => $data['sala_id'],
            'tiempo' => $data['tiempo'],
            'fecha' => $data['fecha'],
            'codigo' => $codigo
        ]);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Ranking y equipo registrados correctamente.',
            'codigo_generado' => $codigo
        ]);
    }
}
