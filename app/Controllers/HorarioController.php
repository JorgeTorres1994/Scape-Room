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

    public function vistaHorariosDisponibles()
    {
        $salaModel = new \App\Models\SalaModel();
        $data['salas'] = $salaModel->findAll();

        return view('admin/horarios_disponibles', $data);
    }


    public function horariosDisponibles()
    {
        $salaId = $this->request->getGet('sala_id');
        $fecha  = $this->request->getGet('fecha');

        if (!$salaId || !$fecha) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Faltan parámetros']);
        }

        $horarioModel = new \App\Models\HorarioModel();
        $reservaModel = new \App\Models\ReservaModel();

        // Obtener todos los horarios activos de la sala
        $horarios = $horarioModel
            ->select('horario.id, horario.hora')
            ->where('sala_id', $salaId)
            ->findAll();

        // Obtener IDs de horarios ya reservados ese día para esa sala
        $ocupados = $reservaModel
            ->select('horario_id')
            ->where('fecha', $fecha)
            ->where('sala_id', $salaId)
            ->where('activo', 1)
            ->findColumn('horario_id');

        return $this->response->setJSON([
            'horarios' => $horarios,
            'ocupados' => $ocupados ?? []
        ]);
    }

    public function fechasOcupadas()
    {
        $salaId = $this->request->getGet('sala_id');

        if (!$salaId) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Falta el parámetro sala_id'
            ]);
        }

        $horarioModel = new \App\Models\HorarioModel();

        // Buscar todos los horarios activos de esa sala
        $horarios = $horarioModel
            ->where('sala_id', $salaId)
            ->findAll();

        if (empty($horarios)) {
            return $this->response->setJSON(['fechas_ocupadas' => []]);
        }

        $horarioIds = array_column($horarios, 'id');

        $reservaModel = new \App\Models\ReservaModel();

        // Buscar todas las fechas únicas que tengan reserva para esos horarios
        $fechas = $reservaModel
            ->select('fecha')
            ->whereIn('horario_id', $horarioIds)
            ->groupBy('fecha')
            ->orderBy('fecha', 'ASC')
            ->findAll();

        $soloFechas = array_column($fechas, 'fecha');

        return $this->response->setJSON([
            'fechas_ocupadas' => $soloFechas
        ]);
    }
}
