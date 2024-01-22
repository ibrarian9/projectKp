<?php

namespace App\Http\Controllers;


use App\Models\Lomba;
use App\Models\Peserta;
use App\Models\Tim;
use App\Models\TimLomba;
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

    public function tampilPeserta($id)
    {
        $join = Tim::join('tim_lomba', 'tim.id_tim', '=', 'tim_lomba.id_tim')
            ->join('peserta', 'tim.id_peserta', '=' , 'peserta.id_peserta')
            ->join('universitas', 'peserta.id_universitas', '=', 'universitas.id_universitas')
            ->select('tim.*', 'tim_lomba.*', 'peserta.*', 'universitas.*')
            ->where('tim_lomba.id_lomba', $id)
            ->get();
        $namaLomba = $this->namaLomba();
        return view('DataPeserta.DataPeserta', compact('join', 'namaLomba'));
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
