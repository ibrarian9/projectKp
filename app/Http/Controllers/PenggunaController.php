<?php

namespace App\Http\Controllers;

use App\Models\Juri;
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
        return Tim::query()
            ->join('nomor_perlombaan', 'tim.id_nomor_perlombaan', '=', 'nomor_perlombaan.id_nomor_perlombaan')
            ->rightJoin('lomba', 'nomor_perlombaan.id_lomba', '=', 'lomba.id_lomba')
            ->select('lomba.id_lomba', 'lomba.nama_lomba', DB::raw('COUNT(tim.id_peserta) AS tim_count'))
            ->groupBy('lomba.id_lomba', 'lomba.nama_lomba')
            ->get();
    }

    public function dataPeserta(): Collection
    {
        return NomorPerlombaan::query()->withCount('tim')->get();
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
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
        ];

        User::query()->find($id)->update($pengguna);
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
        $namaLomba = $dataPeserta[0];
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        return view('DataPeserta.DataPeserta', compact('dataPeserta', 'dataLomba', 'dataNomorLomba', 'namaLomba'));
    }

    public function tampilPenilaian($id): View
    {
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();

        // Menampilkan Data Juri
        $juri = PengaturanJuri::query()
            ->join('nomor_perlombaan AS np', 'pengaturan_juri.id_nomor_perlombaan', '=', 'np.id_nomor_perlombaan')
            ->join('juri', 'pengaturan_juri.id_juri', '=', 'juri.id_juri')
            ->where('pengaturan_juri.id_nomor_perlombaan', $id)
            ->select('juri.*', 'np.nomor_lomba')
            ->get()->toArray();

        $namaJuri = array_filter(array_map(function ($item) {
            return $item['nama_juri'] ?? null;
        }, $juri));
        $namaSemuaJuri = implode(", ", $namaJuri);


        // Menampilkan Data Peserta
        $query =
            " SELECT tim.id_nomor_perlombaan as id, nomor_perlombaan.nomor_lomba ,tim.id_tim, universitas.nama_universitas, JSON_ARRAYAGG(peserta.nama_peserta) AS list_peserta
                FROM tim
                INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
                INNER JOIN nomor_perlombaan ON tim.id_nomor_perlombaan = nomor_perlombaan.id_nomor_perlombaan
              WHERE tim.id_nomor_perlombaan = $id
              GROUP BY universitas.nama_universitas, tim.id_tim, tim.id_nomor_perlombaan,  nomor_perlombaan.nomor_lomba
            ";
        $dataPeserta = DB::select($query);
        $namaLomba = $dataNomorLomba->where('id_nomor_perlombaan', $id)->first();

        //  Membuat loop sum sesuai jumlah data juri
        $tambah = [];
        foreach ($juri as $num => $j){
            $tambah[] = "SUM(CASE WHEN juri.id_juri = {$j['id_juri']} THEN nl.poin_nilai_lomba ELSE 0 END) AS total_juri$num";
        }
        $sumQuery = implode(", ", $tambah);
        $sum = !empty($sumQuery) ? ",$sumQuery" : '';

        //  Menampilkan Data peserta dan Total Nilai
        $queryNilai =
            " SELECT tim.id_tim, np.id_nomor_perlombaan $sum
                FROM tim
                INNER JOIN nomor_perlombaan AS np ON tim.id_nomor_perlombaan = np.id_nomor_perlombaan
                INNER JOIN nilai_lomba AS nl ON tim.id_tim = nl.id_tim
                INNER JOIN kategori_penilaian AS kp ON nl.id_kategori_penilaian = kp.id_kategori
                INNER JOIN pengaturan_juri AS pj ON nl.id_pengaturan_juri = pj.id_pengaturan_juri
                INNER JOIN juri ON pj.id_juri = juri.id_juri
              WHERE tim.id_nomor_perlombaan = $id
              GROUP BY tim.id_tim, np.id_nomor_perlombaan;
            ";
        $nilai = DB::select($queryNilai);

        // Convert data to object
        $data1 = collect($nilai);
        $data2 = collect($dataPeserta);

        // Merge Data using Map
        $combineCollect = $data1->map(function ($i) use ($data2){
           $dataCombine = $data2->firstWhere('id_tim', $i->id_tim);
           if ($dataCombine) {
               foreach ($dataCombine as $key => $value){
                   $i->$key = $value;
               }
           }
           return $i;
        });
        $dataNilaidanPeserta = $combineCollect->toArray();

        return view('Penilaian.Penilaian', compact('dataLomba', 'dataPeserta', 'dataNomorLomba', 'namaSemuaJuri', 'juri', 'dataNilaidanPeserta', 'namaLomba'));
    }

    public function inputNilai($id, $timId, $juriId): View
    {
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();

        // Menampilkan Data Juri
        $juri = Juri::query()->where('id_juri', $juriId)->get();
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

        // Memasukkan data nilai kedalam database nilai lomba
        try {
            foreach ($req->all() AS $numbers => $value) {
                if (is_numeric($numbers) && in_array($numbers, range($min->id_kategori, $max->id_kategori))) {
                    NilaiLomba::updateOrCreate(
                        [
                            'id_kategori_penilaian' => $numbers,
                            'id_tim' => $timId,
                            'id_pengaturan_juri' => $pengaturanId,
                        ],
                        ['poin_nilai_lomba' => $value]
                    );
                }
            }
            return redirect()->route('penilaian', $npId);
        } catch (Exception) {
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
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
        ]);

        return redirect()->route('dataUsers');
    }

    public function edit($id): View
    {
        $query = User::query()->find($id);
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        return view('Pengguna.EditPengguna', compact('query', 'dataNomorLomba', 'dataLomba'));
    }

    public function hapus($id): RedirectResponse
    {
        $query = User::query()->find($id);
        $query->delete();
        return redirect()->route('dataUsers');
    }

}
