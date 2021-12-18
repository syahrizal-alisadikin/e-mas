@extends('layouts.admin')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Edit Rumah Bumn
                                    </div>
                                    <div class="card-body">
                                         <form method="POST" action="{{ route('rumah-bumn.update',$user->id) }}">
                                        @csrf
                                        @method("PUT")
                                 <div class="form-group">
                                     <label for="">Nama UMKM</label>
                                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name',$user->name) }}" id="exampleInputEmail"
                                        placeholder="Nama UMKM ...">
                                          @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                     <label for="">Nama Pemilik</label>

                                    <input type="text" name="pemilik" class="form-control   @error('pemilik') is-invalid @enderror" value="{{ old('pemilik',$user->pemilik) }}" id="exampleInputEmail"
                                        placeholder="Pemilik ...">
                                          @error('pemilik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                               
                                <div class="form-group">
                                     <label for="">Email</label>

                                    <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" id="exampleInputEmail"
                                        placeholder="Email Address ...">
                                          @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                               <div class="form-group">
                                     <label for="">No Handphone</label>

                                    <input type="number" name="phone" class="form-control  @error('phone') is-invalid @enderror" value="{{ old('phone',$user->phone) }}" id="exampleInputEmail"
                                        placeholder="No Hanphone ...">
                                          @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                     <label for="">Alamat</label>

                                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat',$user->alamat) }}" id="exampleInputEmail"
                                        placeholder="Alamat ...">
                                          @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                 
                                <button type="submit" class="btn btn-primary   btn-block">
                                    Edit Mitra
                                </button>
                                
                                
                            </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </main>

                





@endsection