@extends('layouts.app')
@section('contents')
          <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>
            <div class="row">
                @if(Auth::user()->id_role == 1)
                    @foreach($dataLomba as $i)
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2" style="border-left: 5px solid #BF1CC7;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <a class="" href="{{ route('tampil', $i->id_lomba )}}" style="text-decoration: none">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #BF1CC7;">
                                                    {{ $i->nama_lomba }}
                                                </div>
                                                <div class="text-md mb-0 font-weight-bold text-gray-800">
                                                    Jumlah Tim : {{ $i->tim_count }}
                                                </div>
                                            </div>
                                        </a>
                                        <div class="col-auto">
                                            <i class="fas fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @elseif(Auth::user()->id_role == 2)
                    @foreach($dataLombaByJuri as $i)
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2" style="border-left: 5px solid #BF1CC7;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <a class="" href="{{ route('tampil', $i->id_lomba )}}" style="text-decoration: none">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #BF1CC7;">
                                                    {{ $i->nama_lomba }}
                                                </div>
                                                <div class="text-md mb-0 font-weight-bold text-gray-800">
                                                    Jumlah Tim : {{ $i->tim_count }}
                                                </div>
                                            </div>
                                        </a>
                                        <div class="col-auto">
                                            <i class="fas fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
          </div>
@endsection
