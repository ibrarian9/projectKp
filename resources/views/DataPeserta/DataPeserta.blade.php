@extends('layouts.app')
@section('contents')
    <div class="container-fluid">
        @yield('contentPeserta')
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800">Data Peserta {{$namaLomba->nama_lomba}}</h1>
        <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text" style="color: #BF1CC7">Data Peserta</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table
                        class="table table-bordered"
                        id="dataTable">
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Peserta</th>
                            <th class="text-center">Asal Universitas</th>
                        </tr>
                        </thead>
                        @foreach ($dataPeserta as $row)
                            @if($row->id_peserta != null)
                                <tbody>
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{implode(", ", json_decode($row->peserta_names))}}</td>
                                    <td>{{$row->nama_universitas}}</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                @else
                                    <tr>
                                        <th colspan="3" class="text-center">Data Peserta Tidak Ada</th>
                                    </tr>
                                @endif
                                </tfoot>
                                @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
