<?php

namespace App\Controllers;

use App\Models\EquipoModel;

class EquipoController extends BaseController
{
    public function equipos()
    {
        $equipoModel = new EquipoModel();
        $data['equipos'] = $equipoModel->findAll();

        return view('admin/equipos_list', $data);
    }
}
