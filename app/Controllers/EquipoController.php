<?php

namespace App\Controllers;

use App\Models\EquipoModel;

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

    // Procesar registro y generar JSON
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

        $equipoModel = new EquipoModel();

        if ($equipoModel->where('nombre', $nombre)->first()) {
            return redirect()->back()->with('error', 'El nombre del equipo ya existe.')->withInput();
        }

        // Guardar
        $equipoModel->insert(['nombre' => $nombre]);

        // Generar JSON actualizado
        $this->generarJSON();

        return redirect()->to(base_url('admin/equipos'))
            ->with('success', 'Equipo registrado correctamente.');
    }

    // Ruta para obtener JSON dinámico de los equipos
    public function obtenerEquipos()
    {
        $equipoModel = new EquipoModel();

        $equipos = $equipoModel
            ->select('id, nombre, creado_en')
            ->orderBy('creado_en', 'ASC')
            ->findAll();

        return $this->response->setJSON($equipos);
    }

    // Método privado que genera un archivo JSON físico
    private function generarJSON()
    {
        $equipoModel = new EquipoModel();

        $equipos = $equipoModel
            ->select('id, nombre, creado_en')
            ->orderBy('creado_en', 'ASC')
            ->findAll();

        $jsonPath = WRITEPATH . 'equipos.json';
        file_put_contents($jsonPath, json_encode($equipos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function crearEquipos()
    {
        log_message('error', '✅ Entró al método crearEquipos');

        $json = $this->request->getJSON(true);
        log_message('error', '📦 Datos recibidos: ' . json_encode($json));

        if (!$json || empty($json['nombre'])) {
            log_message('error', '❌ Nombre no proporcionado');
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Nombre del equipo es requerido'
            ]);
        }

        $equipoModel = new \App\Models\EquipoModel();
        $equipoModel->insert(['nombre' => $json['nombre']]);

        log_message('error', '✅ Equipo insertado exitosamente');

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Equipo creado correctamente'
        ]);
    }


    /*public function crearEquipos()
    {
        log_message('error', '🛠️ Entrando al método crearEquipos');

        // Luego continúa como antes
        $data = $this->request->getJSON(true);

        if (!$data || !isset($data['nombre'])) {
            log_message('error', '❌ Datos inválidos');
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'El campo "nombre" es obligatorio.'
            ]);
        }

        log_message('error', '✅ Datos recibidos: ' . json_encode($data));

        $equipoModel = new \App\Models\EquipoModel();
        $equipoModel->insert(['nombre' => $data['nombre']]);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Equipo creado correctamente.'
        ]);
    }*/
}
