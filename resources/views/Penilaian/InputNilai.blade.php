@extends('layouts.app')
@section('contents')
  <form action="{{route('dataUsers.simpan')}}" method="post">
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

              <div class="card-body">
                  <h1 class="h3 mb-2 text-gray-800"></h1>
                  <h4 class="h5 mb-2 text-gray-800">
                      Nama Juri :
                  </h4>
                  <h4 class="h5 mb-2 text-gray-800">
                      Asal Universitas :
                  </h4>
                  <h4 class="h5 mb-2 text-gray-800">
                      Tanggal Pemeriksaan :
                  </h4>
              </div>
          </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                  Input Nilai Peserta
                </h6>
              </div>
              <div class="row">
    <div class="col-12">
         <div class="card-body">
             <div class="form-group">
                 <label for="name">Nama Peserta</label>
                 <input type="text" class="form-control" id="name" name="name" value="{{implode(', ',json_decode($namaPeserta->peserta_names))}}">
             </div>
             @foreach($detailPeserta AS $item)
                 <div class="form-group">
                     <label for="name">{{$item->nama_kategori}}</label>
                     <input type="number" class="form-control" id="name" name="nilai1" value="">
                 </div>
             @endforeach
            <div class="form-group">
                <label for="penilaian">Penilaian Kualitatif Juri</label>
                <textarea type="penilaian" rows="5" class="form-control" id="penilaian" name="penilaian" value=""></textarea>
            </div>
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
