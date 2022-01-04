
@extends('layouts.login')
@section('content')
    <div class="container" >

        <!-- Outer Row -->
        <div class="row ">

            <div class="col-lg-5 col-md-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login E-MAS!</h1>
                                    </div>
                                   <form method="POST" action="{{ route('login') }}" class="user">
                        @csrf
                                        <div class="form-group">
                                            <input id="email" type="email" placeholder="Enter Email Addres ..." class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                              <input id="password" type="password" placeholder="Enter Password ..." class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                    {{ __('Login') }}
                                </button>

                                <a href="{{ url('register') }}" class="btn btn-secondary btn-user btn-block">Register</a>

                                      
                                    </form>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <div class="bg-primary">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2  text-center col-sm-6" style="padding-top: 80px">
                    <h2 class="text-white" ><b>Informasi <br> Pembinaan</b></h2>
                    
                </div>
                <div class="col-md-4 col-sm-6" style="padding-top: 70px">
                    <div class="d-flex">
                        <img src="{{ asset('asset/img/icon Note.png') }}" style="width: 100px; height:100px" alt="">
                        <div class="ml-2 my-2">
                            <h3 class="text-white text-bold"><b>260</b></h3>
                        <h4 class="text-white">Mitra <b>UMKM</b> Terdaftar</h4>
                        </div>

                    </div>
                </div>
                <div class="col-md-3 col-sm-6" style="padding-top: 30px;padding-bottom:50px">
                    <div class="d-flex">
                        <img src="{{ asset('asset/img/Icon-0.svg') }}" style="width: 80px; height:80px" alt="">
                        <div class="my-3">
                            <h3 class="text-white text-bold"><b>100</b></h3>
                        <h6 class="text-white">Go Global Terdaftar</h6>
                        </div>

                    </div>
                    <div class="d-flex">
                        <img src="{{ asset('asset/img/Icon-1.svg') }}" style="width: 80px; height:80px" alt="">
                        <div class="my-3">
                            <h3 class="text-white text-bold"><b>50</b></h3>
                        <h6 class="text-white">Go Modern Terdaftar</h6>
                        </div>

                    </div>
                </div>
                <div class="col-md-3 col-sm-6" style="padding-top: 30px;padding-bottom:50px">
                    <div class="d-flex">
                        <img src="{{ asset('asset/img/Icon-2.svg') }}" style="width: 80px; height:80px" alt="">
                        <div class="my-3">
                            <h3 class="text-white text-bold"><b>10</b></h3>
                        <h6 class="text-white">Go Modern Terdaftar</h6>
                        </div>

                    </div>
                    <div class="d-flex">
                        <img src="{{ asset('asset/img/Icon-3.svg') }}" style="width: 80px; height:80px" alt="">
                        <div class="my-3">
                            <h3 class="text-white text-bold"><b>100</b></h3>
                        <h6 class="text-white">Go Global Terdaftar</h6>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection