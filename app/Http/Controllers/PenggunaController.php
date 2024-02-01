<?php

namespace App\Http\Controllers;


use App\Models\NomorPerlombaan;
use App\Models\Peserta;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class PenggunaController extends Controller
{
    public function namaLomba(): Collection
    {
        return Tim::join('nomor_perlombaan', 'tim.id_nomor_perlombaan', '=', 'nomor_perlombaan.id_nomor_perlombaan')
            ->rightJoin('lomba', 'nomor_perlombaan.id_lomba', '=', 'lomba.id_lomba')
            ->select('lomba.id_lomba', 'lomba.nama_lomba', DB::raw('COUNT(tim.id_peserta) AS tim_count'))
            ->groupBy('lomba.id_lomba', 'lomba.nama_lomba')
            ->get();
    }

    public function dataPeserta(): Collection
    {
        return NomorPerlombaan::withCount('tim')->get();
    }

    public function index(): View
    {
        $dataLomba = $this->namaLomba();
        $dataPeserta = $this->dataPeserta();
        $dataNomorLomba = $this->dataPeserta();
        return view('Dashboard', compact('dataLomba','dataPeserta', 'dataNomorLomba'));
    }

    public function update($id, Request $request): RedirectResponse
    {
        $pengguna = [
            'name' => $request->name,
            'password' => bcrypt($request->password ),
        ];

        User::find($id)->update($pengguna);
        return redirect()->route('indexPengguna');
    }
    public function semuaUsers(): View
    {
        $dataLomba = $this->namaLomba();
        $user = User::all();
        $dataNomorLomba = $this->dataPeserta();
        return view('Pengguna.DataPengguna', compact('user','dataLomba','dataNomorLomba'));
    }

    public function tampilPeserta($id): View
    {
        $dataPeserta = Tim::select('lomba.id_lomba', 'lomba.nama_lomba', 'tim.id_peserta', 'peserta.*', 'universitas.*', DB::raw('JSON_ARRAYAGG(peserta.nama_peserta) as peserta_names'))
            ->join(DB::raw("JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) as jt"))
            ->join('peserta', 'jt.id_peserta', '=', 'peserta.id_peserta')
            ->join('universitas', 'peserta.id_universitas', '=', 'universitas.id_universitas')
            ->join('nomor_perlombaan', 'tim.id_nomor_perlombaan', '=', 'nomor_perlombaan.id_nomor_perlombaan')
            ->rightJoin('lomba', 'nomor_perlombaan.id_lomba', '=', 'lomba.id_lomba')
            ->where('lomba.id_lomba', $id)
            ->get();
        dd($dataPeserta);
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        return view('DataPeserta.DataPeserta', compact('dataPeserta', 'dataLomba', 'dataNomorLomba'));
    }

    public function tampilPenilaian($id): View
    {
        $dataLomba = $this->namaLomba();
        $dataPeserta = Tim::with('peserta')->where('id_nomor_perlombaan', $id)->get();
        $dataNomorLomba = $this->dataPeserta();
        return view('Penilaian.Penilaian', compact('dataLomba', 'dataPeserta', 'dataNomorLomba'));
    }

    public function inputNilai($id): View
    {
        $dataLomba = $this->namaLomba();
        $detailPeserta = Peserta::find($id);
        $dataNomorLomba = $this->dataPeserta();
        return view('Penilaian.InputNilai', compact('dataLomba', 'detailPeserta', 'dataNomorLomba'));
    }

    public function kategoriNomorPerlombaan(): View
    {
        $dataLomba = $this->namaLomba();
        $dataPeserta = $this->dataPeserta();
        $dataNomorLomba = $this->dataPeserta();
        return view('Penilaian.KategoriNomorLomba', compact('dataLomba', 'dataPeserta', 'dataNomorLomba'));
    }
    public function detailKategoriNomorPerlombaan($id): View
    {
        $dataLomba = $this->namaLomba();
        $listPeserta = Tim::with('peserta.universitas')->where('tim.id_nomor_perlombaan', $id)->get();
        $dataNomorLomba = $this->dataPeserta();
        return view('Penilaian.DetailKategoriNomorLomba', compact('dataLomba', 'listPeserta', 'dataNomorLomba'));
    }

    public function tambah(): View
    {
        $dataLomba = $this->namaLomba();
        return view('Pengguna.TambahPengguna', compact('dataLomba'));
    }

    public function simpan(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $simpan = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('indexPengguna');
    }

    public function edit(int $id): View
    {
        $query = User::find($id);
        return view('Pengguna.EditPengguna', compact('query'));
    }

    public function hapus(string $id): RedirectResponse
    {
        $query = User::find($id);
        $query->delete();

        return redirect()->route('indexPengguna');
    }

}
