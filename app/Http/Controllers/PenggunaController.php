<?php

namespace App\Http\Controllers;

use App\Models\NilaiLomba;
use App\Models\NomorPerlombaan;
use App\Models\PengaturanJuri;
use App\Models\Tim;
use App\Models\User;
use Exception;
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
        return view('Dashboard', compact('dataLomba', 'dataPeserta', 'dataNomorLomba'));
    }

    public function update($id, Request $request): RedirectResponse
    {
        $pengguna = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ];

        User::find($id)->update($pengguna);
        return redirect()->route('indexPengguna');
    }

    public function semuaUsers(): View
    {
        $dataLomba = $this->namaLomba();
        $user = User::all();
        $dataNomorLomba = $this->dataPeserta();
        return view('Pengguna.DataPengguna', compact('user', 'dataLomba', 'dataNomorLomba'));
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

        // Menampilkan Data Juri
        $queryJuri =
            "SELECT juri.*, nomor_perlombaan.nomor_lomba
                FROM pengaturan_juri
                INNER JOIN nomor_perlombaan ON pengaturan_juri.id_nomor_perlombaan = nomor_perlombaan.id_nomor_perlombaan
                INNER JOIN juri ON pengaturan_juri.id_juri = juri.id_juri
             WHERE pengaturan_juri.id_nomor_perlombaan = $id
            ";
        $juri = DB::select($queryJuri);
        $namaJuri = array_filter(array_map(function ($item) {
            return $item->nama_juri ?? null;
        }, $juri));
        $namaJuriAll = implode(", ", $namaJuri);

        // Menampilkan Data Peserta
        $query =
            " SELECT tim.id_nomor_perlombaan as id, tim.id_tim, universitas.nama_universitas ,JSON_ARRAYAGG(peserta.nama_peserta) AS peserta_names
                FROM tim
                INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
                INNER JOIN nomor_perlombaan ON tim.id_nomor_perlombaan = nomor_perlombaan.id_nomor_perlombaan
              WHERE tim.id_nomor_perlombaan = $id
              GROUP BY universitas.nama_universitas, tim.id_tim, tim.id_nomor_perlombaan
            ";
        $dataPeserta = DB::select($query);
        $dataNomorLomba = $this->dataPeserta();

        return view('Penilaian.Penilaian', compact('dataLomba', 'dataPeserta', 'dataNomorLomba', 'namaJuriAll', 'juri'));
    }

    public function inputNilai($id, $timId, $juriId): View
    {
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();

        // Menampilkan Data Juri
        $queryJuri = "SELECT nama_juri, id_juri FROM juri WHERE id_juri = $juriId";
        $juri = DB::select($queryJuri);
        $namaJuri = $juri[0] ?? NULL;

        // Menampilkan Data Nilai dan Peserta jika Data Nilai Ada pada tabel nilai lomba
        $query1 =
            " SELECT kp.id_kategori, kp.nama_kategori, tim.id_tim, pj.id_nomor_perlombaan, universitas.nama_universitas, JSON_ARRAYAGG(peserta.nama_peserta) AS peserta_names,
                nl.poin_nilai_lomba
                FROM tim
                INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
                INNER JOIN nomor_perlombaan AS np ON tim.id_nomor_perlombaan = np.id_nomor_perlombaan
                INNER JOIN nilai_lomba AS nl ON tim.id_tim = nl.id_tim
                INNER JOIN kategori_penilaian AS kp ON nl.id_kategori_penilaian = kp.id_kategori
                INNER JOIN pengaturan_juri AS pj ON nl.id_pengaturan_juri = pj.id_pengaturan_juri
                WHERE tim.id_tim = $timId AND pj.id_juri = $juriId
              GROUP BY kp.id_kategori, kp.nama_kategori, tim.id_tim, pj.id_nomor_perlombaan, universitas.nama_universitas, nl.poin_nilai_lomba
            ";
        $dataNilai = DB::select($query1);

        // Menampilkan Data Kategori Penilaian dan Peserta Jika nilai tidak ada pada tabel nilai lomba
        $query2 =
            " SELECT kp.id_kategori, kp.nama_kategori, tim.id_tim, np.id_nomor_perlombaan, universitas.nama_universitas, JSON_ARRAYAGG(peserta.nama_peserta) AS peserta_names
                    FROM tim
                    INNER JOIN nomor_perlombaan AS np ON tim.id_nomor_perlombaan = np.id_nomor_perlombaan
                    INNER JOIN lomba ON np.id_lomba = lomba.id_lomba
                    INNER JOIN kategori_penilaian AS kp ON lomba.id_lomba = kp.id_lomba
                    INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                    INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                    INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
              WHERE np.id_nomor_perlombaan = $id AND tim.id_tim = $timId
              GROUP BY kp.id_kategori, kp.nama_kategori, tim.id_tim, np.id_nomor_perlombaan, universitas.nama_universitas
            ";
        $dataKatPenilaian = DB::select($query2);

        //  mengecek value nilai lomba
        $dataPesertaAll = !empty($dataNilai) ? $dataNilai : $dataKatPenilaian;
        $dataPesertaTunggal = $dataPesertaAll[0] ?? null;

        return view('Penilaian.InputNilai', compact('dataLomba', 'dataNomorLomba', 'namaJuri', 'dataPesertaAll', 'dataPesertaTunggal'));
    }

    public function postNilai(Request $req): View|RedirectResponse
    {
        //  Define id data
        $juriId = $req->get('juriId');
        $npId = $req->get('npId');
        $timId = $req->get('timId');
        $queryId = PengaturanJuri::query()
                    ->join('juri', 'pengaturan_juri.id_juri', '=', 'juri.id_juri')
                    ->where('juri.id_juri', $juriId)
                    ->where('pengaturan_juri.id_nomor_perlombaan', $npId)
                    ->select('pengaturan_juri.id_pengaturan_juri')
                    ->get()->first();
        $pengaturanId = $queryId->id_pengaturan_juri;

        $queryIdPenilaian =
            " SELECT kp.id_kategori, kp.nama_kategori, tim.id_tim, np.id_nomor_perlombaan
                FROM tim
                INNER JOIN nomor_perlombaan AS np ON tim.id_nomor_perlombaan = np.id_nomor_perlombaan
                INNER JOIN lomba ON np.id_lomba = lomba.id_lomba
                INNER JOIN kategori_penilaian AS kp ON lomba.id_lomba = kp.id_lomba
              WHERE np.id_nomor_perlombaan = $npId AND tim.id_tim = $timId
              GROUP BY kp.id_kategori, kp.nama_kategori, tim.id_tim, np.id_nomor_perlombaan
            ";
        $idPenilaian = DB::select($queryIdPenilaian);

        $min = min($idPenilaian);
        $max = max($idPenilaian);

        try {
            foreach ($req->all() as $key => $value) {
                if (is_numeric($key) && in_array($key, range($min->id_kategori, $max->id_kategori))) {
                    NilaiLomba::updateOrCreate(
                        [
                            'id_kategori_penilaian' => $key,
                            'id_tim' => $timId,
                            'id_pengaturan_juri' => $pengaturanId,
                        ],
                        ['poin_nilai_lomba' => $value]
                    );
                }
            }
            return redirect()->route('penilaian', $npId);
        } catch (Exception $e) {
            return redirect()->back();
        }
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
            " SELECT nomor_perlombaan.nomor_lomba ,universitas.nama_universitas ,JSON_ARRAYAGG(peserta.nama_peserta) AS peserta_names
                FROM tim
                INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
                INNER JOIN nomor_perlombaan ON tim.id_nomor_perlombaan = nomor_perlombaan.id_nomor_perlombaan
              WHERE tim.id_nomor_perlombaan = $id
              GROUP BY universitas.nama_universitas, nomor_perlombaan.nomor_lomba";
        $listPeserta = DB::select($query);
        $nomorLomba = $listPeserta[0];
        $dataNomorLomba = $this->dataPeserta();
        return view('Penilaian.DetailKategoriNomorLomba', compact('dataLomba', 'listPeserta', 'dataNomorLomba', 'nomorLomba'));
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
