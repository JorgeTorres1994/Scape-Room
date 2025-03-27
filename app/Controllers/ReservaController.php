<?php

namespace App\Controllers;

use App\Models\ReservaModel;

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
            ->select('reserva.*, cliente.nombre_completo, cliente.correo, cliente.telefono, sala.nombre AS sala_nombre, horario.hora')
            ->join('cliente', 'cliente.id = reserva.cliente_id')
            ->join('sala', 'sala.id = reserva.sala_id')
            ->join('horario', 'horario.id = reserva.horario_id')
            ->orderBy('reserva.fecha', 'DESC')
            ->findAll();

        return $this->response->setJSON(['data' => $reservas]);
    }

    public function crear()
    {
        $data = $this->request->getJSON(true); // true → as array

        if (!$data || !isset($data['cliente']) || !isset($data['reserva'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Datos incompletos o mal formateados.'
            ]);
        }

        $clienteModel = new \App\Models\ClienteModel();
        $reservaModel = new \App\Models\ReservaModel();

        // Verificar si el cliente ya existe por correo
        $cliente = $clienteModel->where('correo', $data['cliente']['correo'])->first();

        if (!$cliente) {
            // Crear nuevo cliente
            $clienteId = $clienteModel->insert($data['cliente']);
        } else {
            $clienteId = $cliente['id'];
        }

        // Crear reserva asociada
        $reserva = [
            'cliente_id' => $clienteId,
            'sala_id' => $data['reserva']['sala_id'],
            'horario_id' => $data['reserva']['horario_id'],
            'fecha' => $data['reserva']['fecha'],
            'cantidad_jugadores' => $data['reserva']['cantidad_jugadores'],
            'estado' => 'pendiente'
        ];

        $reservaModel->insert($reserva);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Reserva registrada exitosamente'
        ]);
    }
}
