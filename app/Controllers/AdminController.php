<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class AdminController extends Controller
{
    public function dashboard()
    {
        $db = Database::connect();

        $data['title'] = "Dashboard";

        $data['totalSalas'] = $db->table('sala')->countAll();
        /*$data['totalReservas'] = $db->table('reserva')->countAll();
        $data['totalUsuarios'] = $db->table('usuarios')->countAll();
        $data['totalCalificaciones'] = $db->table('calificacion')->countAll();

        $promedio = $db->table('calificacion')
            ->selectAvg('puntaje', 'promedio')
            ->get()
            ->getRow();

        $data['promedioCalificaciones'] = round($promedio->promedio ?? 0, 1); */

        return view('admin/dashboard', $data);
    }
}
