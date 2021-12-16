@extends('layouts.mitra')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Tambah Kegiatan Pemasaran
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('pemasaran-mitra.store')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                               <div class="form-group">
                                                <label for="name">Nama UMKM</label>
                                              <select name="user_id" required  class="form-control">
                                                  <option value="">Pilih UMKM</option>
                                                  @foreach ($user as $item)
                                                  <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                                      
                                                  @endforeach
                                              </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" placeholder="Masukan Kegiatan Pemasaran..." class="form-control @error('name') is-invalid @enderror" >
                                                     @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Tanggal</label>
                                                <input type="date" name="tanggal" id="name" value="{{ date('Y-m-d') }}" required class="form-control @error('tanggal') is-invalid @enderror" >
                                                     @error('tanggal')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                             <div class="form-group">
                                                <label for="name">Jenis Kegiatan</label>
                                                <input type="text" name="jenis" placeholder="Masukan Jenis kegiatan..."  required class="form-control @error('jenis') is-invalid @enderror" >
                                                     @error('jenis')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Keterangan Kegiatan</label>
                                               <textarea name="keterangan" placeholder="Masukan Keterangan..."  id="" cols="30" rows="5" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Tambah Data</button>
                                            </div>
                                        </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </main>

                





@endsection