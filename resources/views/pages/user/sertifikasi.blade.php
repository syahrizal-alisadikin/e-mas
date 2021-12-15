@extends('layouts.dashboard')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Sertifikasi  User
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('certificate.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Nama Sertifikasi</label>
                                                <input type="text" name="name" value="{{ old('name',$sertifikat->name ?? null) }}" placeholder="Nama Sertifikasi..." id="name" class="form-control @error('name') is-invalid @enderror" >
                                                     @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name_pemberi">Nama Pemberi Sertifikasi</label>
                                                <input type="text" name="nama_pemberi"  value="{{ old('name',$sertifikat->nama_pemberi ?? null) }}" placeholder="Nama Pemberi Sertifikasi..." id="name_pemberi" class="form-control @error('name_pemberi') is-invalid @enderror" >
                                                     @error('name_pemberi')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal Sertifikasi</label>
                                                <input type="date" name="tanggal"  value="{{ old('name',$sertifikat->tanggal ?? null) }}" id="name_pemberi" class="form-control @error('tanggal') is-invalid @enderror" >
                                                     @error('tanggal')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal">File Sertifikasi</label>
                                                <input type="file" name="file" placeholder="Nama Pemberi Sertifikasi..." id="file" class="form-control @error('file') is-invalid @enderror" >
                                                     @error('file')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Update Data</button>
                                            </div>
                                        </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </main>

                





@endsection