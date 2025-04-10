<?php

namespace App\Controllers;

use App\Models\IntegranteModel;
use App\Models\EquipoModel;

class IntegranteController extends BaseController
{
    public function integrantes()
    {
        $integranteModel = new IntegranteModel();
        $equipoModel = new EquipoModel();

        $integrantes = $integranteModel->orderBy('id', 'ASC')->findAll();

        foreach ($integrantes as &$integrante) {
            $equipo = $equipoModel->find($integrante['equipo_id']);
            $integrante['equipo_nombre'] = $equipo['nombre'] ?? 'Equipo no encontrado';
        }

        return view('admin/integrantes_list', ['integrantes' => $integrantes]);
    }
}
