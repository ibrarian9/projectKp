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
                                                <th class="text-center">No</th>
                                                <th class="text-center">Kategori Nomor Lomba</th>
                                                <th class="text-center">Jumlah Peserta</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        @foreach($dataPeserta AS $item)
                                        <tbody>
                                            <tr>
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td>{{$item->nomor_lomba}}</td>
                                                <td class="text-center">{{$item->tim_count}}</td>
                                                <td class="text-center">
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
