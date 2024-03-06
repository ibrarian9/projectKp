@extends('layouts.app')
@section('contents')
    <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Pengguna</h1>
            @if(Auth::user()->id_role == 1)
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <a href="{{ route('dataUsers.tambah') }}" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm" style="background-color: #BF1CC7">
                    Tambah Pengguna
                </a>
            </div>
            @elseif(Auth::user()->id_role == 2)
            @endif
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Universitas</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if(Auth::user()->id_role == 1)
                        @foreach ($user as $row)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>{{$row->username}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->univ->nama_universitas ?? ''}}</td>
                                <td class="text-center">{{$row->roles->nama_role ?? ''}}</td>
                                <td class="text-center">
                                    <a
                                        href="{{route('dataUsers.edit',$row->id)}}"
                                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                                    >Edit</a>
                                    <a
                                        href="{{route('dataUsers.hapus',$row->id)}}"
                                        class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
                                    >Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    @elseif(Auth::user()->id_role == 2)

                    @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
@endsection
