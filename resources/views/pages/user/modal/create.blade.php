@extends('layouts.dashboard')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Tambah Modal
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('modal.store')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" placeholder="Masukan Nama Modal..." class="form-control @error('name') is-invalid @enderror" >
                                                     @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                           <div class="form-group">
                                               <label for="">Bahan</label>
                                               <select class="form-control" required name="bahan[]" id="bahan" multiple="multiple">
                                                   @foreach ($bahan as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    
                                                    @endforeach
                                                  
                                                </select>
                                           </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Tambah Modal</button>
                                            </div>
                                        </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </main>

                





@endsection

@push('addon-script')
    <script>
        $(document).ready(function() {
            $('#bahan').select2({
                placeholder: 'Pilih Bahan'
            });
        });
    </script>
@endpush