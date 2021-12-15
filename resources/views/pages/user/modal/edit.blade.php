@extends('layouts.dashboard')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Edit Modal
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('modal.update',$modal->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <@method("PUT")
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" value="{{ $modal->name }}" id="name" placeholder="Masukan Nama Modal..." class="form-control @error('name') is-invalid @enderror" >
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
                                                    <option value="{{ $item->id }}"  {{ in_array($item->id, $modal->bahan()->pluck('bahan_id')->toArray()) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    
                                                    @endforeach
                                                  
                                                </select>
                                           </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Edit Modal</button>
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