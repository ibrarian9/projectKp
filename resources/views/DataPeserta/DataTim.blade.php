@extends('layouts.app')
@section('contents')
    <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Peserta</h1>
            <div
              class="d-sm-flex align-items-center justify-content-between mb-4"
            >
              <!-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> -->
              <a href="{{ route('Pengguna.tambah') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i></i> Tambah Peserta
</a>

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
                    id="dataTable"
                    width="100%"
                    cellspacing="0"
                  >
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Tim</th>
                        <th>Asal Universitas</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    @php($no=1)
                    @foreach ($query as $row)
                      <tr>
                        <td>{{$no++}}</td>
                        <td>{{$row->nama_tim}}</td>
                        <td>{{$row->nama_universitas}}</td>
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
                  </table>
                </div>
              </div>
            </div>
          </div>
@endsection
  