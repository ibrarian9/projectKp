@extends('layouts.app')
@section('contents')
    <form action="{{route('postNilai')}}" method="post">
        @csrf
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Input Nilai Peserta</h1>
            <div
                class="d-sm-flex align-items-center justify-content-between mb-4"
            >
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        FORM PENILAIAN DEWAN JURI LOMBA
                    </h6>
                </div>
                {{--input data id--}}
                <input type="hidden" id="juriId" name="juriId" value="{{$juri->id}}">
                <input type="hidden" id="timId" name="timId" value="{{$dataPesertaTunggal->id_tim}}">
                <input type="hidden" id="npId" name="npId" value="{{$dataPesertaTunggal->id_nomor_perlombaan}}">

                <div class="card-body">
                    <h4 class="h5 mb-2 text-gray-800">
                        Nama Juri : {{$juri->name}}
                    </h4>
                    <h4 class="h5 mb-2 text-gray-800">
                        Asal Universitas : {{$dataPesertaTunggal->nama_universitas}}
                    </h4>
                    <h4 class="h5 mb-2 text-gray-800">
                        Tanggal Pemeriksaan : {{$tanggalPemeriksaan}}
                    </h4>
                </div>
            </div>
            <!-- DataTables -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Input Nilai Peserta
                    </h6>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="name">Nama Peserta</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{implode(', ',json_decode($dataPesertaTunggal->peserta_names))}}" readonly>
                            </div>
                            @foreach($dataPesertaAll AS $item)
                                <div class="form-group">
                                    <label for="{{$item->id_kategori}}">{{$item->nama_kategori}}</label>
                                    <input type="number" class="form-control" id="{{$item->id_kategori}}" name="{{$item->id_kategori}}" value="{{$item->poin_nilai_lomba ?? ""}}" required>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a type="submit" class="btn btn-danger" href="{{url()->previous()}}">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
