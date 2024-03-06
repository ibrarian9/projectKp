@extends('layouts.app')
@section('contents')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold" style="color: #BF1CC7">
                    Form Penilaian Dewan Juri Lomba {{ str($namaLomba->nomor_lomba)}}
                </h6>
            </div>

            <div class="card-body">
                <h1 class="h3 mb-2 text-gray-800"></h1>
                <h4 class="h5 mb-2 text-gray-800">
                    @if(Auth::user()->id_role === 1)
                        Nama Juri : {{ $namaSemuaJuri }}
                    @elseif(Auth::user()->id_role === 2)
                        Nama Juri : {{ $juriByIdLogin->users->name }}
                    @endif
                </h4>
                <h4 class="h5 mb-2 text-gray-800">
                    @if(Auth::user()->id_role === 1)
                        Asal Universitas : {{ $namaSemuaUniv }}
                    @elseif(Auth::user()->id_role === 2)
                        Asal Universitas : {{ $juriByIdLogin->users->univ->nama_universitas }}
                    @endif
                </h4>
                <h4 class="h5 mb-2 text-gray-800">
                    @if(Auth::user()->id_role === 1)
                        Tanggal Pemeriksaan : {{ $tanggalPemeriksaanSemua }}
                    @elseif(Auth::user()->id_role === 2)
                        Tanggal Pemeriksaan : {{ $juriByIdLogin->tanggal_pemeriksaan ?? "Belum Ada Tanggal" }}
                    @endif
                </h4>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold" style="color: #BF1CC7">
                    Form Penilaian Peserta Lomba {{ str($namaLomba->nomor_lomba)}}
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="form-group w-25">
                        <label for="id_univ">Universitas</label>
                        <select name="id_univ" id="id_univ" class="form-control" required>
                            <option value="">Select Universitas</option>
                            @foreach($dataUniv as $i)
                                <option value="{{ $i->id_universitas }}">{{$i->nama_universitas}}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table table-bordered" id="tabPeserta">
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Peserta</th>
                            <th class="text-center">Asal Universitas</th>
                            @if(Auth::user()->id_role === 1)
                                @foreach($juri as $j)
                                    <th class="text-center">Total Juri <br> {{$j['name']}}</th>
                                @endforeach
                                @foreach($juri as $j)
                                    <th class="text-center">Aksi Juri <br> {{$j['name']}}</th>
                                @endforeach
                            @elseif(Auth::user()->id_role === 2)
                                <th class="text-center">Total Nilai</th>
                                <th class="text-center">{{Auth::user()->name}}</th>
                            @endif
                        </tr>
                        </thead>
                        @empty(!$dataPeserta)
                            @if(Auth::user()->id_role === 1)
                                @foreach($dataNilaidanPeserta AS $item)
                                    <tbody>
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{implode(', ',json_decode($item->list_peserta))}}</td>
                                        <td>{{$item->nama_universitas}}</td>
                                        @foreach($juri as $j)
                                            <td class="text-center">{{ $item->{'total_juri'.$loop->index} }}</td>
                                        @endforeach
                                        @foreach($juri as $j)
                                            <td class="text-center">
                                                <a
                                                    href="{{route('inputNilai', ['id' => $item->id, 'timId' => $item->id_tim, 'juriId' =>  $j['id']])}}"
                                                    class="d-sm-inline-block btn btn-sm shadow-sm" style="background-color: #BF1CC7; color: #FFFFFF">Input
                                                    Nilai
                                                </a>
                                            </td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                @endforeach
                            @elseif(Auth::user()->id_role === 2)
                                @foreach($dataNilaidanPesertaPerJuri AS $item)
                                    <tbody>
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{implode(', ',json_decode($item->list_peserta))}}</td>
                                        <td>{{$item->nama_universitas}}</td>
                                        <td class="text-center">{{ $item->total_nilai }}</td>
                                        <td class="text-center">
                                            <a
                                                href="{{route('inputNilai', ['id' => $item->id, 'timId' => $item->id_tim, 'juriId' =>  $juriByIdLogin->id_user])}}"
                                                class="d-sm-inline-block btn btn-sm shadow-sm" style="background-color: #BF1CC7; color: #FFFFFF">Input
                                                Nilai
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            @endif
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
