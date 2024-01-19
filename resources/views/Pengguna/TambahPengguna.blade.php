@extends('layouts.app')
@section('contents')
  <form action="{{route('Pengguna.simpan')}}" method="post">
    @csrf
      <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Tambah data pengguna</h1>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">

            </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                  Tambah Data Pengguna
                </h6>
              </div>
              <div class="row">
    <div class="col-12">
     <!-- <div class="card shadow mb-4"> -->
         <div class="card-body">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="">
            </div>

         </div>
         <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="submit" class="btn btn-danger">Batal</button>
         </div>
     <!-- </div> -->
    </div>
   </div>
            </div>
          </div>
  </form>
@endsection
