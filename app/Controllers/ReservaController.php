<?php

namespace App\Controllers;

use App\Models\ReservaModel;
use App\Models\HorarioModel;

class ReservaController extends BaseController
{
    public function reservas()
    {
        $salaModel = new \App\Models\SalaModel();
        $salas = $salaModel->findAll();
        return view('admin/reservas_list', ['salas' => $salas]);
    }

    public function obtenerReservas()
    {
        $reservaModel = new ReservaModel();

        $salaId = $this->request->getGet('sala_id');
        $fecha  = $this->request->getGet('fecha');

        $reservaModel
            ->select('reserva.*, horario.hora, sala.nombre AS sala_nombre')
            ->join('horario', 'horario.id = reserva.horario_id')
            ->join('sala', 'sala.id = horario.sala_id')
            ->orderBy('reserva.fecha', 'ASC');

        if ($salaId) {
            $reservaModel->where('sala.id', $salaId);
        }

        if ($fecha) {
            $reservaModel->where('reserva.fecha', $fecha);
        }

        $reservas = $reservaModel->findAll();

        return $this->response->setJSON(['data' => $reservas]);
    }


    public function crear()
    {
        $data = $this->request->getJSON(true);

        if (!$data || !isset($data['reserva'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Datos de reserva no proporcionados.'
            ]);
        }

        $reservaData = $data['reserva'];

        $camposObligatorios = [
            'cliente',
            'correo',
            'telefono',
            'horario_id',
            'fecha',
            'cantidad_jugadores',
            'metodo_pago',
            'precio_total'
        ];

        foreach ($camposObligatorios as $campo) {
            if (!isset($reservaData[$campo]) || $reservaData[$campo] === '') {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => "Falta el campo obligatorio: $campo"
                ]);
            }
        }

        // Obtener sala_id desde el horario
        $horarioModel = new HorarioModel();
        $horario = $horarioModel->select('sala_id')->find($reservaData['horario_id']);

        if (!$horario) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Horario inválido o no encontrado.'
            ]);
        }

        $reservaModel = new ReservaModel();

        $reserva = [
            'cliente'             => $reservaData['cliente'],
            'correo'              => $reservaData['correo'],
            'telefono'            => $reservaData['telefono'],
            'sala_id'             => $horario['sala_id'],
            'horario_id'          => $reservaData['horario_id'],
            'fecha'               => $reservaData['fecha'],
            'cantidad_jugadores' => $reservaData['cantidad_jugadores'],
            'metodo_pago'         => $reservaData['metodo_pago'],
            'precio_total'        => $reservaData['precio_total'],
            'estado'              => 'pendiente'
        ];

        $reservaModel->insert($reserva);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Reserva registrada exitosamente'
        ]);
    }

    public function actualizar($id)
    {
        $reservaModel = new ReservaModel();

        $data = [
            'cliente'             => $this->request->getPost('cliente'),
            'correo'              => $this->request->getPost('correo'),
            'telefono'            => $this->request->getPost('telefono'),
            'horario_id'          => $this->request->getPost('horario_id'),
            'fecha'               => $this->request->getPost('fecha'),
            'cantidad_jugadores' => $this->request->getPost('cantidad_jugadores'),
            'metodo_pago'         => $this->request->getPost('metodo_pago'),
            'precio_total'        => $this->request->getPost('precio_total'),
            'estado'              => $this->request->getPost('estado'),
        ];

        // Obtener sala_id según el horario
        $horarioModel = new HorarioModel();
        $horario = $horarioModel->select('sala_id')->find($data['horario_id']);

        if (!$horario) {
            return redirect()->back()->with('error', 'Horario inválido.');
        }

        $data['sala_id'] = $horario['sala_id'];

        $reservaModel->update($id, $data);

        return redirect()->to(base_url('admin/reservas'))
            ->with('success', 'Reserva actualizada correctamente.');
    }

    public function editar($id)
    {
        $reservaModel = new ReservaModel();
        $horarioModel = new HorarioModel();

        $reserva = $reservaModel->find($id);

        if (!$reserva) {
            return redirect()->to(base_url('admin/reservas'))->with('error', 'Reserva no encontrada.');
        }

        $data['reserva'] = $reserva;
        $data['horarios'] = $horarioModel
            ->select('horario.*, sala.nombre as sala_nombre')
            ->join('sala', 'sala.id = horario.sala_id')
            ->findAll();

        return view('admin/reservas_editar', $data);
    }

    public function actualizarReservaAPI($id)
    {
        $reservaModel = new ReservaModel();
        $data = $this->request->getJSON(true)['reserva'] ?? null;

        if (!$data) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Datos JSON no proporcionados.'
            ]);
        }

        $required = [
            'cliente',
            'correo',
            'telefono',
            'horario_id',
            'fecha',
            'cantidad_jugadores',
            'metodo_pago',
            'precio_total',
            'estado'
        ];

        foreach ($required as $campo) {
            if (!isset($data[$campo])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => "Falta el campo obligatorio: $campo"
                ]);
            }
        }

        // Obtener sala desde horario
        $horarioModel = new HorarioModel();
        $horario = $horarioModel->select('sala_id')->find($data['horario_id']);

        if (!$horario) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Horario inválido.'
            ]);
        }

        $data['sala_id'] = $horario['sala_id'];

        $reservaModel->update($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Reserva actualizada vía API'
        ]);
    }
    /*public function toggleEstado($id)
    {
        $reservaModel = new \App\Models\ReservaModel();
        $data = $this->request->getJSON(true)['reserva'] ?? null;

        if (!$data || !isset($data['activo'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Estado no enviado']);
        }

        $reservaModel->update($id, ['activo' => (int)$data['activo']]);

        return $this->response->setJSON(['success' => true]);
    }*/

    public function toggleActivo($id)
    {
        $json = $this->request->getJSON(true);
        $estado = $json['reserva']['activo'] ?? null;

        if (!isset($estado)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Campo "activo" no proporcionado.'
            ]);
        }

        $reservaModel = new \App\Models\ReservaModel();
        $reservaModel->update($id, ['activo' => (int) $estado]);

        return $this->response->setJSON(['success' => true]);
    }
}
