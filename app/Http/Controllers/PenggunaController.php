<?php

namespace App\Http\Controllers;

use App\Models\NilaiLomba;
use App\Models\NomorPerlombaan;
use App\Models\PengaturanJuri;
use App\Models\Role;
use App\Models\Tim;
use App\Models\Universitas;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function dataNilaiLombaByJuri(): array
    {
        $id = Auth::user()->id;
        $query = "
            SELECT DISTINCT np.nomor_lomba, np.id_nomor_perlombaan
            FROM nomor_perlombaan AS np
                INNER JOIN pengaturan_juri AS pj ON np.id_nomor_perlombaan = pj.id_nomor_perlombaan
                INNER JOIN users ON pj.id_user = users.id
            WHERE pj.id_user = $id
        ";
        return DB::select($query);
    }

    public function dataPeserta(): Collection
    {
        return NomorPerlombaan::query()->withCount('tim')->get();
    }

    public function dataRole(): Collection
    {
        return Role::all();
    }

    public function dataUniv(): Collection
    {
        return Universitas::all();
    }

    public function index(): View
    {
        $dataLomba = $this->namaLomba();
        $dataPeserta = $this->dataPeserta();
        $dataNomorLomba = $this->dataPeserta();
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();
        return view('Dashboard', compact('dataLomba', 'dataPeserta', 'dataNomorLomba', 'dataNomorLombaByJuri'));
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
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();
        return view('DataPeserta.DataPeserta', compact('dataPeserta', 'dataLomba', 'dataNomorLomba', 'namaLomba','dataNomorLombaByJuri'));
    }

    public function tampilPenilaian($id): View
    {
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();

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

        // Juri
        // Menampilkan Data Juri By Id Juri Login
        $idJuriLogin = Auth::user()->id;

        $juriByIdLogin = PengaturanJuri::with(['users.univ','nomorLomba'])
            ->where([['pengaturan_juri.id_nomor_perlombaan', $id], ['pengaturan_juri.id_user', $idJuriLogin]])
            ->get()->first();

        //  Menampilkan Data peserta dan Total Nilai
        $queryNilai =
            " SELECT tim.id_tim ,SUM(CASE WHEN users.id = $idJuriLogin THEN nl.poin_nilai_lomba ELSE 0 END) AS total_nilai
                FROM tim
                INNER JOIN nomor_perlombaan AS np ON tim.id_nomor_perlombaan = np.id_nomor_perlombaan
                INNER JOIN nilai_lomba AS nl ON tim.id_tim = nl.id_tim
                INNER JOIN kategori_penilaian AS kp ON nl.id_kategori_penilaian = kp.id_kategori
                INNER JOIN pengaturan_juri AS pj ON nl.id_pengaturan_juri = pj.id_pengaturan_juri
                INNER JOIN users ON pj.id_user = users.id
              WHERE tim.id_nomor_perlombaan = $id
              GROUP BY tim.id_tim;
            ";
        $nilaiPerJuri = DB::select($queryNilai);

        // Convert data to object
        $data1 = collect($nilaiPerJuri);
        $data2 = collect($dataPeserta);

        $combineCollect = $data2->map(function ($item) use ($data1) {
            $matchingItem = $data1->firstWhere('id_tim', $item->id_tim);
            if ($matchingItem) {
                foreach ($matchingItem as $key => $value) {
                    $item->$key = $value;
                }
            } else {
                $item->total_nilai = "0";
            }
            return $item;
        });
        $dataNilaidanPesertaPerJuri = $combineCollect->toArray();

        // ADMIN
        // Menampilkan Data Juri Admin

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
        $dataPesertaAdmin = DB::select($query);

        $juri = PengaturanJuri::query()
            ->join('nomor_perlombaan AS np', 'pengaturan_juri.id_nomor_perlombaan', '=', 'np.id_nomor_perlombaan')
            ->join('users', 'pengaturan_juri.id_user', '=', 'users.id')
            ->join('universitas', 'users.id_universitas', '=', 'universitas.id_universitas')
            ->where('pengaturan_juri.id_nomor_perlombaan', $id)
            ->select('users.id', 'users.name', 'np.nomor_lomba', 'pengaturan_juri.tanggal_pemeriksaan', 'universitas.nama_universitas')
            ->get()->toArray();

        $namaJuri = array_filter(array_map(function ($item) {
            return $item['name'] ?? null;
        }, $juri));

        $tanggalPemeriksaan = array_filter(array_map(function ($item) {
            return $item['tanggal_pemeriksaan'] ?? 'belum diisi';
        }, $juri));

        $namaUniv = array_filter(array_map(function ($item) {
            return $item['nama_universitas'] ?? null;
        }, $juri));

        $tanggalPemeriksaanSemua = implode(", ", $tanggalPemeriksaan);
        $namaSemuaJuri = implode(", ", $namaJuri);
        $namaSemuaUniv = implode(", ", $namaUniv);

        $namaLomba = $dataNomorLomba->where('id_nomor_perlombaan', $id)->first();

        //  Membuat loop sum sesuai jumlah data juri
        $tambah = [];
        foreach ($juri as $num => $j){
            $tambah[] = "SUM(CASE WHEN users.id = {$j['id']} THEN nl.poin_nilai_lomba ELSE 0 END) AS total_juri$num";
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
                INNER JOIN users ON pj.id_user = users.id
              WHERE tim.id_nomor_perlombaan = $id
              GROUP BY tim.id_tim, np.id_nomor_perlombaan;
            ";
        $nilai = DB::select($queryNilai);

        // Convert data to object
        $data_1 = collect($nilai);
        $data_2 = collect($dataPesertaAdmin);

        // Merge Data using Map
        $combineCollect = $data_2->map(function ($item) use ($data_1) {
            $matchingItem = $data_1->firstWhere('id_tim', $item->id_tim);
            if ($matchingItem) {
                foreach ($matchingItem as $key => $value) {
                    if (property_exists($matchingItem, $key)) {
                        $item->$key = $value;
                    }
                }
            } else {
                $item->total_juri0 = "0";
                $item->total_juri1 = "0";
                $item->total_juri2 = "0";
            }

            return $item;
        });
        $dataNilaidanPeserta = $combineCollect->toArray();

        return view('Penilaian.Penilaian', compact('dataLomba', 'dataPeserta', 'dataNomorLomba',
            'namaSemuaJuri', 'juri', 'dataNilaidanPeserta', 'namaLomba', 'tanggalPemeriksaanSemua',
            'juriByIdLogin', 'nilaiPerJuri', 'dataNilaidanPesertaPerJuri', 'namaSemuaUniv', 'dataNomorLombaByJuri'));
    }

    public function inputNilai($id, $timId, $juriId): View
    {
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();

        // Menampilkan Data Juri
        $juri = User::query()->where('id', $juriId)->get()->first();

        // Menampilkan Data Nilai dan Peserta jika Data Nilai Ada pada tabel nilai lomba
        $query1 =
            " SELECT kp.id_kategori, kp.nama_kategori, tim.id_tim, pj.id_nomor_perlombaan, universitas.nama_universitas, JSON_ARRAYAGG(peserta.nama_peserta) AS peserta_names,
                nl.poin_nilai_lomba, pj.tanggal_pemeriksaan
                FROM tim
                INNER JOIN JSON_TABLE(tim.id_peserta, '$[*]' COLUMNS (id_peserta INT PATH '$')) AS jt
                INNER JOIN peserta ON jt.id_peserta = peserta.id_peserta
                INNER JOIN universitas ON peserta.id_universitas = universitas.id_universitas
                INNER JOIN nomor_perlombaan AS np ON tim.id_nomor_perlombaan = np.id_nomor_perlombaan
                INNER JOIN nilai_lomba AS nl ON tim.id_tim = nl.id_tim
                INNER JOIN kategori_penilaian AS kp ON nl.id_kategori_penilaian = kp.id_kategori
                INNER JOIN pengaturan_juri AS pj ON nl.id_pengaturan_juri = pj.id_pengaturan_juri
                WHERE tim.id_tim = $timId AND pj.id_user = $juriId
              GROUP BY kp.id_kategori, kp.nama_kategori, tim.id_tim, pj.id_nomor_perlombaan, universitas.nama_universitas, nl.poin_nilai_lomba, pj.tanggal_pemeriksaan
            ";
        $dataNilai = DB::select($query1);
        $tanggalPemeriksaan = $dataNilai[0]->tanggal_pemeriksaan ?? 'belum diisi';

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

        return view('Penilaian.InputNilai', compact('dataLomba', 'dataNomorLomba',
            'dataPesertaAll', 'dataPesertaTunggal', 'tanggalPemeriksaan', 'juri', 'dataNomorLombaByJuri'));
    }

    public function postNilai(Request $req): View|RedirectResponse
    {
        //  Define id data
        $juriId = $req->get('juriId');
        $npId = $req->get('npId');
        $timId = $req->get('timId');
        $queryId = PengaturanJuri::query()
                    ->join('users', 'pengaturan_juri.id_user', '=', 'users.id')
                    ->where([['users.id', $juriId],['pengaturan_juri.id_nomor_perlombaan', $npId]])
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
        $waktuSekarang = Carbon::now()->toDateTimeString();

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
                    PengaturanJuri::where([
                        ['pengaturan_juri.id_user', $juriId],
                        ['pengaturan_juri.id_nomor_perlombaan', $npId]
                    ])->update(['tanggal_pemeriksaan' => $waktuSekarang]);
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
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();
        return view('Penilaian.KategoriNomorLomba', compact('dataLomba', 'dataPeserta', 'dataNomorLomba', 'dataNomorLombaByJuri'));
    }

    public function detailKategoriNomorPerlombaan($id): View
    {
        $dataLomba = $this->namaLomba();
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();
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
        return view('Penilaian.DetailKategoriNomorLomba', compact('dataLomba', 'listPeserta', 'dataNomorLomba', 'nomorLomba', 'dataNomorLombaByJuri'));
    }

    public function semuaUsers(): View
    {
        $dataLomba = $this->namaLomba();
        $user = User::with(['univ','roles'])->get();
        $dataNomorLomba = $this->dataPeserta();
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();
        return view('Pengguna.DataPengguna', compact('user', 'dataLomba', 'dataNomorLomba','dataNomorLombaByJuri'));
    }

    public function tambah(): View
    {
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();
        $dataRole = $this->dataRole();
        $dataUniv = $this->dataUniv();
        return view('Pengguna.TambahPengguna', compact('dataLomba', 'dataNomorLomba', 'dataRole', 'dataUniv', 'dataNomorLombaByJuri'));
    }

    public function simpan(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'password' => 'required',
            'id_role' => 'required',
            'id_universitas' => 'required'
        ]);

        User::create([
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
            'id_role' => $request->get('id_role'),
            'id_universitas' => $request->get('id_universitas')
        ]);

        return redirect()->route('dataUsers');
    }

    public function edit($id): View
    {
        $query = User::query()->find($id);
        $dataLomba = $this->namaLomba();
        $dataNomorLomba = $this->dataPeserta();
        $dataNomorLombaByJuri = $this->dataNilaiLombaByJuri();
        $dataRole = $this->dataRole();
        $dataUniv = $this->dataUniv();
        return view('Pengguna.EditPengguna', compact('query', 'dataNomorLomba', 'dataLomba', 'dataRole', 'dataUniv', 'dataNomorLombaByJuri'));
    }

    public function update($id, Request $request): RedirectResponse
    {
        $pengguna = [
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password') ?? ''),
            'id_role' => $request->get('id_role'),
            'id_universitas' => $request->get('id_universitas')
        ];

        User::query()->find($id)->update($pengguna);
        return redirect()->route('dataUsers');
    }

    public function hapus($id): RedirectResponse
    {
        $query = User::query()->find($id);
        $query->delete();
        return redirect()->route('dataUsers');
    }

}
