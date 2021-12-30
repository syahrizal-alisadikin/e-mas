@extends('layouts.dashboard')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Edit Product
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('data-aset.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method("PUT")
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" value="{{ $data->name }}" placeholder="Masukan Nama data..." class="form-control @error('name') is-invalid @enderror" >
                                                     @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Harga</label>
                                                <input type="number" name="harga" value="{{ $data->harga }}" id="name" placeholder="Masukan Harga..." class="form-control @error('harga') is-invalid @enderror" >
                                                     @error('harga')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Tanggal</label>
                                                <input type="date" name="tanggal" value="{{ $data->tanggal }}"  class="form-control @error('tanggal') is-invalid @enderror" >
                                                     @error('tanggal')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Edit Data</button>
                                            </div>
                                        </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </main>

                





@endsection