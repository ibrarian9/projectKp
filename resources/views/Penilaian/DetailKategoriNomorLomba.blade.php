@extends('layouts.app')
@section('contents')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Psy-Tahfizd 30 Juz Putra
                </h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table
                        class="table table-bordered"
                        id="dataTable"
                    >
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Universitas</th>
                            <th class="text-center">Nama Peserta</th>
                        </tr>
                        </thead>
                        @empty(!$listPeserta)
                            @foreach($listPeserta AS $item)
                                <tbody>
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$item->nama_universitas}}</td>
                                    <td>{{implode(', ',json_decode($item->peserta_names))}}</td>
                                </tr>
                                </tbody>
                            @endforeach
                            <tfoot>
                            @else
                                <tr>
                                    <th colspan="3" class="text-center">Data Peserta Tidak Ada</th>
                                </tr>
                            @endempty
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
