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
                                        <form action="{{route('bahan-product.update',$bahan->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method("PUT")
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" value="{{ $bahan->name }}" placeholder="Masukan Nama Bahan..." class="form-control @error('name') is-invalid @enderror" >
                                                     @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Harga</label>
                                                <input type="number" name="harga" value="{{ $bahan->harga }}" id="name" placeholder="Masukan Harga..." class="form-control @error('harga') is-invalid @enderror" >
                                                     @error('harga')
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