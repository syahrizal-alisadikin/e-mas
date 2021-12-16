@extends('layouts.mitra')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Tambah Product
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('products-mitra.store')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                             <div class="form-group">
                                                <label for="name">Foto</label>
                                                <input type="file" name="foto"  class="form-control @error('name') is-invalid @enderror" >
                                                     @error('foto')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                             <div class="form-group">
                                                <label for="name">Nama UMKM</label>
                                              <select name="user_id" required  class="form-control">
                                                  <option value="">Pilih UMKM</option>
                                                  @foreach ($user as $item)
                                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                      
                                                  @endforeach
                                              </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" placeholder="Masukan Nama Product..." class="form-control @error('name') is-invalid @enderror" >
                                                     @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                             <div class="form-group">
                                                <label for="name">Modal</label>
                                              <select name="modal" required id="modal" class="form-control">
                                                  <option value="">Pilih Modal</option>
                                                  @foreach ($modal as $item)
                                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                      
                                                  @endforeach
                                              </select>
                                            </div>
                                             <div class="form-group" style="display: none" id="showModal">
                                                <label for="name">Modal</label>
                                                <input type="number" class="form-control" id="modalProduct" readonly name="modalProduct">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Harga Jual</label>
                                                <input type="number" name="harga" id="name" placeholder="Masukan Harga..." class="form-control @error('harga') is-invalid @enderror" >
                                                     @error('harga')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Stok</label>
                                                <input type="number" name="stok" id="stok" placeholder="Masukan Stok..." class="form-control @error('stok') is-invalid @enderror" >
                                                     @error('stok')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
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
@push('addon-script')
    <script>
    $(document).ready(function(){
     $('#modal').on("change",function(){
        let modal = $(this).val();
        
        if(modal){
            jQuery.ajax({
            url: '/api/modal/'+modal,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $('#showModal').show()
                $('#modalProduct').val(response)
             },
            });
        }else{
            $('#showModal').hide()
                $('#modalProduct').val(0)
        }
     })
    });
   
</script>
@endpush