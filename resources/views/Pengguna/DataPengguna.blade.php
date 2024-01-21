@extends('layouts.app')
@section('contents')
    <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Pengguna</h1>
            <div
              class="d-sm-flex align-items-center justify-content-between mb-4"
            >
              <!-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> -->
              <a href="{{ route('dataUsers.tambah') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i></i> Tambah Pengguna
</a>

            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
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
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                    @php($no=1)
                    @foreach ($user as $row)
                      <tr>
                        <td>{{$no++}}</td>
                        <td>{{$row->username}}</td>
                        <td>{{$row->name}}</td>
                        <td>
                          <a
                            href="{{route('dataUsers.edit',$row->id)}}"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                            ><i></i> Edit</a
                          >
                          <a
                            href="{{route('dataUsers.hapus',$row->id)}}"
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
