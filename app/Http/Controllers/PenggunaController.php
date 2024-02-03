<?php

namespace App\Http\Controllers;


use App\Models\NomorPerlombaan;
use App\Models\Tim;
use App\Models\User;
use Dotenv\Validator;
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
        $query = "
            SELECT lomba.id_lomba, lomba.nama_lomba, tim.id_peserta, universitas.nama_universitas ,JSON_ARRAYAGG(peserta.nama_peserta) as peserta_names
            FROM tim
                INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
                INNER JOIN nomor_perlombaan ON tim.id_nomor_perlombaan = nomor_perlombaan.id_nomor_perlombaan
                RIGHT JOIN lomba ON nomor_perlombaan.id_lomba = lomba.id_lomba
            WHERE lomba.id_lomba = $id
            GROUP BY lomba.id_lomba, lomba.nama_lomba, tim.id_peserta, universitas.nama_universitas;
        ";

        $dataPeserta = DB::select($query);
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        return view('DataPeserta.DataPeserta', compact('dataPeserta', 'dataLomba', 'dataNomorLomba'));
    }

    public function tampilPenilaian($id): View
    {
        $dataLomba = $this->namaLomba();
        $query =
            " SELECT  tim.id_tim, universitas.nama_universitas ,JSON_ARRAYAGG(peserta.nama_peserta) AS peserta_names
                FROM tim
                INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
                INNER JOIN nomor_perlombaan ON tim.id_nomor_perlombaan = nomor_perlombaan.id_nomor_perlombaan
              WHERE tim.id_nomor_perlombaan = $id
              GROUP BY universitas.nama_universitas, tim.id_tim
            ";
        $dataPeserta = DB::select($query);
        $dataNomorLomba = $this->dataPeserta();
        return view('Penilaian.Penilaian', compact('dataLomba', 'dataPeserta', 'dataNomorLomba'));
    }

    public function inputNilai($id): View
    {
        $dataLomba = $this->namaLomba();
        $query =
            " SELECT kp.nama_kategori, JSON_ARRAYAGG(peserta.nama_peserta) AS peserta_names
                    FROM tim
                    INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                    INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                    INNER JOIN nomor_perlombaan AS np ON tim.id_nomor_perlombaan = np.id_nomor_perlombaan
                    INNER JOIN kategori_penilaian AS kp ON np.id_lomba = kp.id_lomba
              WHERE tim.id_tim = $id
              GROUP BY kp.nama_kategori
            ";
        $detailPeserta = DB::select($query);
        $namaPeserta = $detailPeserta[0] ?? NULL;
        $dataNomorLomba = $this->dataPeserta();
        return view('Penilaian.InputNilai', compact('dataLomba', 'namaPeserta', 'detailPeserta', 'dataNomorLomba'));
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
        $query =
            " SELECT universitas.nama_universitas ,JSON_ARRAYAGG(peserta.nama_peserta) AS peserta_names
                FROM tim
                INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
                INNER JOIN nomor_perlombaan ON tim.id_nomor_perlombaan = nomor_perlombaan.id_nomor_perlombaan
              WHERE tim.id_nomor_perlombaan = $id
              GROUP BY universitas.nama_universitas";
        $listPeserta = DB::select($query);
        $dataNomorLomba = $this->dataPeserta();
        return view('Penilaian.DetailKategoriNomorLomba', compact('dataLomba', 'listPeserta', 'dataNomorLomba'));
    }

    public function tambah(): View
    {
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        return view('Pengguna.TambahPengguna', compact('dataLomba', 'dataNomorLomba'));
    }

    public function simpan(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'password' => 'required',
        ]);

        $simpan = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('dataUsers');
    }

    public function edit($id): View
    {
        $query = User::find($id);
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        return view('Pengguna.EditPengguna', compact('query', 'dataNomorLomba', 'dataLomba'));
    }

    public function hapus($id): RedirectResponse
    {
        $query = User::find($id);
        $query->delete();
        return redirect()->route('dataUsers');
    }

}
