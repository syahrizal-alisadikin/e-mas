@extends('layouts.dashboard')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Status  User
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('user.status-update',$user->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="name">Status Mitra</label>
                                                <select name="status_id" required class="form-control" id="">
                                                    @foreach ($status as $item)
                                                        <option value="{{ $item->id }}" {{ $item->id == $user->status_id ? "selected" : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                     @error('status_id')
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