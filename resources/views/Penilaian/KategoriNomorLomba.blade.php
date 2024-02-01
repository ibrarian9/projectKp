@extends('layouts.app')
@section('contents')
<div class="container-fluid">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    KATEGORI NOMOR LOMBA
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
                                                <th>Kategori Nomor Lomba</th>
                                                <th>Jumlah Peserta</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        @foreach($dataPeserta AS $item)
                                        <tbody>
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->nomor_lomba}}</td>
                                                <td>{{$item->tim_count}}</td>
                                                <td>
                                                    <a
                                                        href="{{route('detailKategoriNomorLomba', $item->id_nomor_perlombaan)}}"
                                                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                                        Detail Peserta
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
