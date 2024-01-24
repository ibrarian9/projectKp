@extends('layouts.app')
@section('contents')
<div class="container-fluid">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    FORM PENILAIAN DEWAN JURI LOMBA
                                </h6>
                            </div>

                            <div class="card-body">
                                <h1 class="h3 mb-2 text-gray-800"></h1>
                                <h4 class="h5 mb-2 text-gray-800">
                                    Nama Juri :
                                </h4>
                                <h4 class="h5 mb-2 text-gray-800">
                                    Asal Universitas :
                                </h4>
                                <h4 class="h5 mb-2 text-gray-800">
                                    Tanggal Pemeriksaan :
                                </h4>
                            </div>
                        </div>
                        <div
                            class="d-sm-flex align-items-center justify-content-between mb-4"
                        >
                            <a
                                href="adduser.html"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                                ><i></i> Tambah Data Peserta
                            </a>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    FORM PENILAIAN PESERTA
                                </h6>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered"
                                        id="dataTable"
                                        width="100%"
                                        cellspacing="0"
                                    >
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peserta</th>
                                                <th>Asal Universitas</th>
                                                <th>Nilai Format Naskah</th>
                                                <th>
                                                    Nilai Kreativitas Gagasan
                                                </th>
                                                <th>
                                                    Nilai Kesesuaian Tema/Topik
                                                    yang disampaikan
                                                </th>
                                                <th>
                                                    Nilai Keterpaduan
                                                    Unsur/Struktur Cerpen Islami
                                                </th>
                                                <th>Total</th>
                                                <th>
                                                    Komentar
                                                </th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        @if($dataPeserta->count() != 0)
                                            @foreach($dataPeserta AS $item)
                                                <tbody>
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->peserta->nama_peserta}}</td>
                                                    <td>{{$item->peserta->universitas->nama_universitas}}</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>

                                                    </td>
                                                    <td>
                                                        <a
                                                            href=""
                                                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                                                        ><i></i> Edit</a
                                                        >
                                                        <a
                                                            href=""
                                                            class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
                                                        ><i></i> Hapus</a
                                                        >   
                                                    </td>
                                                </tr>
                                                </tbody>
                                            @endforeach
                                            <tfoot>
                                            @else
                                                <tr>
                                                    <th colspan="10" class="text-center">Data Peserta Tidak Ada</th>
                                                </tr>
                                            @endif
                                            </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
