<?php

namespace App\Controllers;

use App\Models\ReservaModel;
use App\Models\ClienteModel;
use App\Models\HorarioModel;
use App\Models\NotificacionModel;

class ReservaController extends BaseController
{
    public function reservas()
    {
        return view('admin/reservas_list');
    }

    public function obtenerReservas()
    {
        $reservaModel = new ReservaModel();

        $reservas = $reservaModel
            ->select('reserva.*, cliente.nombre_completo, sala.nombre AS sala_nombre, horario.hora')
            ->join('cliente', 'cliente.id = reserva.cliente_id')
            ->join('sala', 'sala.id = reserva.sala_id')
            ->join('horario', 'horario.id = reserva.horario_id')
            ->orderBy('reserva.fecha', 'DESC')
            ->findAll();

        return $this->response->setJSON(['data' => $reservas]);
    }

    public function crear()
    {
        $data = $this->request->getJSON(true); // array

        if (!$data || !isset($data['reserva'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Datos de reserva no proporcionados.'
            ]);
        }

        $reservaData = $data['reserva'];

        // Validación mínima
        $camposObligatorios = ['cliente_id', 'sala_id', 'horario_id', 'fecha', 'cantidad_jugadores'];
        foreach ($camposObligatorios as $campo) {
            if (empty($reservaData[$campo])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => "Falta el campo obligatorio: $campo"
                ]);
            }
        }

        $reservaModel = new \App\Models\ReservaModel();

        $reserva = [
            'cliente_id'          => $reservaData['cliente_id'],
            'sala_id'             => $reservaData['sala_id'],
            'horario_id'          => $reservaData['horario_id'],
            'fecha'               => $reservaData['fecha'],
            'cantidad_jugadores' => $reservaData['cantidad_jugadores'],
            'estado'              => 'pendiente'
        ];

        $reservaModel->insert($reserva);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Reserva registrada exitosamente'
        ]);

        // Después de insertar la reserva...
        $notificacionModel = new NotificacionModel();
        $notificacionModel->insert([
            'mensaje' => "Nueva reserva de cliente ID {$reserva['cliente_id']} para {$reserva['fecha']}",
            'reserva_id' => $reservaModel->getInsertID(),
            'leida' => 0
        ]);
    }


    public function editar($id)
    {
        $reservaModel = new ReservaModel();
        $clienteModel = new ClienteModel();
        $horarioModel = new HorarioModel();

        $reserva = $reservaModel
            ->select('reserva.id, reserva.cliente_id, reserva.horario_id, reserva.fecha, reserva.cantidad_jugadores, reserva.estado, cliente.nombre_completo, cliente.telefono, cliente.correo')

            ->join('cliente', 'cliente.id = reserva.cliente_id')
            ->find($id);

        if (!$reserva) {
            return redirect()->to(base_url('admin/reservas'))->with('error', 'Reserva no encontrada.');
        }

        $data['reserva']  = $reserva;
        $data['clientes'] = $clienteModel->findAll();
        $data['horarios'] = $horarioModel
            ->select('horario.*, sala.nombre as sala_nombre')
            ->join('sala', 'sala.id = horario.sala_id')
            ->where('activo', 1)
            ->findAll();

        return view('admin/reservas_editar', $data);
    }

    public function actualizar($id)
    {
        $reservaModel = new ReservaModel();

        // Detectar si la solicitud es JSON
        $isJson = $this->request->is('json');
        $data = $isJson
            ? $this->request->getJSON(true)['reserva'] ?? null
            : $this->request->getPost();

        if (!$data) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Datos no proporcionados.'
            ]);
        }

        // Validación mínima
        $campos = ['cliente_id', 'horario_id', 'fecha', 'cantidad_jugadores', 'estado'];

        if ($this->request->is('json')) {
            $campos[] = 'sala_id';
        }

        foreach ($campos as $campo) {
            if (!isset($data[$campo])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => "Falta el campo obligatorio: $campo"
                ]);
            }
        }

        $reservaModel->update($id, $data);

        // Si es JSON, responder JSON
        if ($isJson) {
            return $this->response->setJSON([
                'success' => true,
                'mensaje' => 'Reserva actualizada correctamente.'
            ]);
        }

        // Si es formulario web, redirigir
        return redirect()->to(base_url('admin/reservas'))
            ->with('success', 'Reserva actualizada correctamente.');
    }
}
