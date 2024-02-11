@extends('layouts.app')
@section('contents')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    FORM PENILAIAN DEWAN JURI LOMBA {{ str($namaLomba->nomor_lomba)->upper() }}
                </h6>
            </div>

            <div class="card-body">
                <h1 class="h3 mb-2 text-gray-800"></h1>
                <h4 class="h5 mb-2 text-gray-800">
                    Nama Juri : {{ $namaSemuaJuri }}
                </h4>
                <h4 class="h5 mb-2 text-gray-800">
                    Asal Universitas :
                </h4>
                <h4 class="h5 mb-2 text-gray-800">
                    Tanggal Pemeriksaan :
                </h4>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    FORM PENILAIAN PESERTA LOMBA {{ str($namaLomba->nomor_lomba)->upper() }}
                </h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Peserta</th>
                            <th class="text-center">Asal Universitas</th>
                            @foreach($juri as $j)
                                <th class="text-center">Total Juri {{$j['id_juri']}}</th>
                            @endforeach
                            <th class="text-center">Komentar</th>
                            @foreach($juri as $j)
                                <th class="text-center">Juri {{$loop->iteration}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        @empty(!$dataPeserta)
                            @foreach($dataNilaidanPeserta AS $item)
                                <tbody>
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{implode(', ',json_decode($item->list_peserta))}}</td>
                                    <td>{{$item->nama_universitas}}</td>
                                    @foreach($juri as $j)
                                        <td class="text-center">{{ $item->{'total_juri'.$loop->index} }}</td>
                                    @endforeach
                                    <td></td>
                                    @foreach($juri as $j)
                                        <td class="text-center">
                                            <a
                                                href="{{route('inputNilai', ['id' => $item->id, 'timId' => $item->id_tim, 'juriId' =>  $j['id_juri']])}}"
                                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Input
                                                Nilai</a
                                            >
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            @endforeach
                            <tfoot>
                            @else
                                <tr>
                                    <th colspan="10" class="text-center">Data Peserta Tidak Ada</th>
                                </tr>
                            @endempty
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
