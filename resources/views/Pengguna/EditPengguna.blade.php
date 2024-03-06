@extends('layouts.app')
@section('contents')
    <form action="{{route('dataUsers.edit',$query->id)}}" method="post">
        @csrf
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Edit data pengguna</h1>
            <div
                class="d-sm-flex align-items-center justify-content-between mb-4"
            >
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Edit Data Pengguna
                    </h6>
                </div>
                @if(Auth::user()->id_role == 1)
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                           value="{{$query->username}}">
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$query->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                                </div>
                                <div class="form-group">
                                    <label for="id_role">Role</label>
                                    <select name="id_role" id="id_role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        @foreach($dataRole as $role)
                                            <option value="{{ $role->id_role }}" @if($query->id_role == $role->id_role) selected @endif>{{ $role->nama_role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_universitas">Universitas</label>
                                    <select name="id_universitas" id="id_universitas" class="form-control" required>
                                        <option value="">Select Universitas</option>
                                        @foreach($dataUniv as $univ)
                                            <option value="{{ $univ->id_universitas }}" @if($query->id_universitas == $univ->id_universitas) selected @endif>{{ $univ->nama_universitas}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a type="submit" href="{{ route('dataUsers') }}" class="btn btn-danger">Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->id_role == 2)
                @endif
            </div>
        </div>
    </form>
@endsection
