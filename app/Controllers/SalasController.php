<?php

namespace App\Controllers;

use App\Models\SalaModel;

class SalasController extends BaseController
{
    public function salas()
    {
        $salaModel = new SalaModel();
        $data['salas'] = $salaModel->findAll();

        return view('admin/salas_list', $data);
    }
}
