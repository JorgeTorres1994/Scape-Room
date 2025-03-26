<?php

namespace App\Controllers;

use App\Models\ClienteModel;

class ClienteController extends BaseController
{
    public function clientes()
    {
        $clienteModel = new ClienteModel();
        $data['clientes'] = $clienteModel->findAll();

        return view('admin/clientes_list', $data);
    }
}
