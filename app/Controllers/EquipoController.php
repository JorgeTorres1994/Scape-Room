<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use App\Models\IntegranteModel;

class EquipoController extends BaseController
{
    // Vista de lista de equipos
    public function equipos()
    {
        $equipoModel = new EquipoModel();
        $data['equipos'] = $equipoModel->orderBy('creado_en', 'ASC')->findAll();

        return view('admin/equipos_list', $data);
    }

    // Vista del formulario
    public function crear()
    {
        return view('admin/equipos_crear');
    }

    public function guardar()
    {
        $nombre = trim($this->request->getPost('nombre'));

        // Validación
        if (empty($nombre)) {
            return redirect()->back()->with('error', 'El nombre del equipo es obligatorio.')->withInput();
        }

        if (strlen($nombre) < 3) {
            return redirect()->back()->with('error', 'El nombre debe tener al menos 3 caracteres.')->withInput();
        }

        // Generar código único
        helper('text');
        $codigo = strtoupper(random_string('alnum', rand(8, 10)));

        // Guardar
        $equipoModel = new \App\Models\EquipoModel();
        $equipoModel->insert([
            'nombre' => $nombre,
            'codigo' => $codigo
        ]);

        return redirect()->to(base_url('admin/equipos'))->with('success', 'Equipo creado correctamente con código: ' . $codigo);
    }


    // Ruta para obtener JSON dinámico de los equipos
    public function obtenerEquipos()
    {
        $equipoModel = new \App\Models\EquipoModel();
        $integranteModel = new \App\Models\IntegranteModel();

        $equipos = $equipoModel->orderBy('creado_en', 'ASC')->findAll();

        foreach ($equipos as &$equipo) {
            $equipo['integrantes'] = $integranteModel
                ->where('equipo_id', $equipo['id'])
                ->select('nombre')
                ->findAll();
        }

        return $this->response->setJSON($equipos);
    }

    public function crearEquipos()
    {
        $json = $this->request->getJSON(true);

        // Validaciones
        if (!isset($json['nombre_equipo']) || trim($json['nombre_equipo']) === '') {
            return $this->response->setJSON(['error' => 'El nombre del equipo es obligatorio.'])->setStatusCode(400);
        }

        if (!isset($json['cantidad_integrantes']) || !is_numeric($json['cantidad_integrantes']) || $json['cantidad_integrantes'] <= 0) {
            return $this->response->setJSON(['error' => 'La cantidad de integrantes debe ser un número mayor que cero.'])->setStatusCode(400);
        }

        if (!isset($json['integrantes']) || !is_array($json['integrantes']) || count($json['integrantes']) !== (int)$json['cantidad_integrantes']) {
            return $this->response->setJSON(['error' => 'La cantidad de integrantes no coincide con el valor proporcionado.'])->setStatusCode(400);
        }

        foreach ($json['integrantes'] as $i => $integrante) {
            if (!isset($integrante['nombre']) || trim($integrante['nombre']) === '') {
                return $this->response->setJSON(['error' => "El nombre del integrante #" . ($i + 1) . " es obligatorio."])->setStatusCode(400);
            }
        }

        // Generar código único
        helper('text');
        $codigo = strtoupper(random_string('alnum', rand(8, 10)));

        $equipoModel = new EquipoModel();
        $equipoId = $equipoModel->insert([
            'nombre' => $json['nombre_equipo'],
            'codigo' => $codigo,
            'cantidad_integrantes' => $json['cantidad_integrantes'] // 👈 agregado aquí
        ]);

        // Guardar integrantes
        $integranteModel = new IntegranteModel();
        foreach ($json['integrantes'] as $integrante) {
            $integranteModel->insert([
                'equipo_id' => $equipoId,
                'nombre' => $integrante['nombre']
            ]);
        }

        return $this->response->setJSON([
            'message' => 'Equipo creado exitosamente.',
            'codigo_equipo' => $codigo,
            'equipo_id' => $equipoId
        ])->setStatusCode(201);
    }
}
