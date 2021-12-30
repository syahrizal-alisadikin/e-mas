@extends('layouts.dashboard')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Update  User
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                             <div class="form-group">
                                                <label for="name">Status</label>
                                                <a href="javascript:void(0)" class="btn btn-success btn-sm ml-2">{{ $user->status->name ?? "-" }}</a>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{$user->name}}">
                                                     @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="no_telp">Phone</label>
                                                <input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{$user->phone}}">
                                                 @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="no_telp">Pemilik</label>
                                                <input type="text" name="pemilik"  class="form-control @error('pemilik') is-invalid @enderror" value="{{$user->pemilik}}">
                                                 @error('pemilik')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="rumah">Rumah BUMN</label>
                                    <select name="rb_id" id="" class="form-control ">
                                        <option value="">Pilih Rumah BUMN</option>
                                        @foreach ($rb as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $user->rb_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            
                                        @endforeach
                                    </select>
                                          @error('rb')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                            <div class="form-group mt-2">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{$user->alamat}}">
                                                 @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                            <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="alamat">Password</label>

                                        <input type="password" name="password" class="form-control form-control-user  @error('password') is-invalid @enderror"
                                            id="exampleInputPassword" placeholder="Emter Password...">
                                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                    <div class="col-sm-6">
                                                <label for="alamat">Confirm Password</label>

                                        <input  id="password-confirm" type="password" name="password_confirmation" class="form-control form-control-user" placeholder="Confirm Password..." name="password_confirmation"  autocomplete="new-password">
                                    </div>
                                </div>
                                            
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Simpan Data</button>
                                                <a href="{{ url('user/dashboard') }}" class="btn btn-success">Batal</a>
                                            </div>
                                        </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </main>

                





@endsection