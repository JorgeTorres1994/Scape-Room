<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;
use App\Models\SalaModel;
use App\Models\RankingModel;
use App\Models\EquipoModel;
use App\Models\ReservaModel;

class AdminController extends Controller
{
    public function dashboard()
    {
        $salaModel     = new SalaModel();
        $reservaModel  = new ReservaModel();
        $rankingModel  = new RankingModel();
        $equipoModel   = new EquipoModel();

        // 1. Conteos generales
        $totalSalas     = $salaModel->countAll();
        $totalReservas  = $reservaModel->countAll();
        $totalRankings  = $rankingModel->countAll();
        $totalEquipos   = $equipoModel->countAll();

        // 2. Conteo de clientes únicos (por correo)
        $totalClientes = $reservaModel->distinct()->select('correo')->countAllResults();

        // 3. Agrupar reservas por mes
        $datos = $reservaModel
            ->select("MONTH(fecha) as mes, COUNT(*) as cantidad")
            ->groupBy('mes')
            ->orderBy('mes', 'ASC')
            ->findAll();

        $labels  = [];
        $valores = [];

        // Mapeo de número de mes a nombre
        $nombresMes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        foreach ($datos as $fila) {
            $labels[]  = $nombresMes[$fila['mes'] - 1];
            $valores[] = (int) $fila['cantidad'];
        }

        return view('admin/dashboard', [
            'totalSalas'     => $totalSalas,
            'totalReservas'  => $totalReservas,
            'totalClientes'  => $totalClientes,
            'totalEquipos'   => $totalEquipos,
            'totalRankings'  => $totalRankings,
            'labels'         => $labels,
            'valores'        => $valores
        ]);
    }
}
