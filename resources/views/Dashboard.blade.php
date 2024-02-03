@extends('layouts.app')
@section('contents')
          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>
            <!-- Content Row -->
            <div class="row">
                @foreach($dataLomba as $item)
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2" style="border-left: 5px solid #BF1CC7;">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <a class="" href="{{ route('tampil', $item->id_lomba )}}" style="text-decoration: none">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #BF1CC7;">
                                    {{ $item->nama_lomba }}
                                </div>
                                <div class="text-md mb-0 font-weight-bold text-gray-800">
                                    Jumlah Tim : {{ $item->tim_count }}
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
            </div>
          </div>
          <!-- /.container-fluid -->
        <!-- End of Main Content -->
@endsection
