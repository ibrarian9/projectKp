<?php

namespace App\Http\Controllers;


use App\Models\Lomba;
use App\Models\Peserta;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpParser\Builder;


class PenggunaController extends Controller
{
    public function namaLomba(): Collection
    {
        return Lomba::all();
    }
    public function index()
    {
        $namaLomba = Lomba::all();
        $dataPeserta = Lomba::withCount('tim')->get();
        return view('Dashboard', compact('namaLomba','dataPeserta'));
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
    public function semuaUsers()
    {
        $namaLomba = $this->namaLomba();
        $user = User::all();
        return view('Pengguna.DataPengguna', compact(['user','namaLomba']));
    }

    public function tampilPeserta($id): View
    {
        $dataPeserta = Tim::with('peserta')->where('tim.id_lomba', $id)
            ->get();
        $namaLomba = $this->namaLomba();
        return view('DataPeserta.DataPeserta', compact('dataPeserta', 'namaLomba'));
    }

    public function tampilPenilaian($id): View
    {
        $namaLomba = $this->namaLomba();
        $dataPeserta = Tim::with('peserta')->where('tim.id_lomba', $id)
            ->get();
        return view('Penilaian.Penilaian', compact('namaLomba', 'dataPeserta'));
    }

    public function tambah(): View
    {
        $namaLomba = $this->namaLomba();
        return view('Pengguna.TambahPengguna', compact('namaLomba'));
    }

    public function simpan(Request $request)
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

    public function edit(int $id)
    {
        $query = User::find($id);
        return view('Pengguna.EditPengguna', compact('query'));
    }

    public function hapus(string $id)
    {
        $query = User::find($id);
        $query->delete();

        return redirect()->route('indexPengguna');
    }

}
