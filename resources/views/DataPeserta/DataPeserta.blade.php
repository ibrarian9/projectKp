@extends('layouts.app')
@section('contents')
    <div class="container-fluid">
      @yield('contentPeserta')
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Peserta</h1>
            <div
              class="d-sm-flex align-items-center justify-content-between mb-4"
            >
              <!-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> -->
              <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Peserta </a>

            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Peserta</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    class="table table-bordered"
                    id="dataTable" >
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Asal Universitas</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if($dataPeserta->count() != 0)
                        @foreach ($dataPeserta as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->peserta->nama_peserta}}</td>
                                <td>{{$row->peserta->universitas->nama_universitas}}</td>
                                <td>
                                    <a
                                        href=""
                                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                                    ><i></i> Edit</a
                                    >
                                    <a
                                        href=""
                                        class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
                                    ><i></i> Hapus</a
                                    >
                                </td>
                            </tr>
                      @endforeach
                    </tbody>
                      <tfoot>
                      @else
                          <tr>
                              <th colspan="4" class="text-center">Data Peserta Tidak Ada</th>
                          </tr>
                      @endif
                      </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
@endsection
