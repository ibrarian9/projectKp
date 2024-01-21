<?php

namespace App\Http\Controllers;


use App\Models\Lomba;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PenggunaController extends Controller
{
    public function namaLomba(): Collection
    {
        return Lomba::all();
    }
    public function index()
    {
        $namaLomba = $this->namaLomba();
        return view('Dashboard', compact('namaLomba'));
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
    public function semuaUsers()
    {
        $namaLomba = $this->namaLomba();
        $user = User::all();
        return view('Pengguna.DataPengguna', compact(['user','namaLomba']));
    }

    public function tampilPeserta(): View
    {
        $join = Peserta::select(
            "id_peserta","nama_peserta", "universitas.nama_universitas"
        )->join("universitas", "universitas.id_universitas", "=", "peserta.id_universitas")->get();
        return view('DataPeserta.DataPeserta', compact('join'));
    }

    public function tambah(): View
    {
        $namaLomba = $this->namaLomba();
        return view('Pengguna.TambahPengguna', compact('namaLomba'));
    }
    public function simpan(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            // 'role' => 'required'
        ]);

        $simpan = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            // 'role' => $request->role
        ]);

        return redirect()->route('indexPengguna');
        // return redirect()->route('PenilaianProposal');
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
