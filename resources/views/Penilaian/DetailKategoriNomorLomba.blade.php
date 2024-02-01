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
                                                <th>No</th>
                                                <th>Universitas</th>
                                                <th>Nama Peserta</th>
                                            </tr>
                                        </thead>
                                        @if($listPeserta->count() != 0)
                                        @foreach($listPeserta AS $item)
                                            <tbody>
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->peserta->universitas->nama_universitas}}</td>
                                                <td>{{$item->peserta->nama_peserta}}</td>
                                            </tr>
                                            </tbody>
                                        @endforeach
                                            <tfoot>
                                            @else
                                                <tr>
                                                    <th colspan="3" class="text-center">Data Peserta Tidak Ada</th>
                                                </tr>
                                            @endif
                                            </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
