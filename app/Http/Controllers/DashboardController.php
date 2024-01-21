<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Peserta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function tampilPeserta()
    {
        $join = Peserta::select(
            "id_peserta","nama_peserta", "universitas.nama_universitas"
        )->join("universitas", "universitas.id_universitas", "=", "peserta.id_universitas")->get();
        return view('DataPeserta.DataPeserta', compact('join'));
    }
}
