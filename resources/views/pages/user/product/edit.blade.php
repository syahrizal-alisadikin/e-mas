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
                                        <form action="{{route('products.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method("PUT")
                                             <div class="form-group">
                                                 <img src="{{ Storage::url('product/'.$product->foto) }}" class="img-thumbnail mb-2" style="width: 200px" alt="">
                                                <label for="name">Nama</label>
                                                <input type="file" name="foto" id="name"  placeholder="Masukan Nama Product..." class="form-control @error('name') is-invalid @enderror" >
                                                     @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" value="{{ $product->name }}" placeholder="Masukan Nama Product..." class="form-control @error('name') is-invalid @enderror" >
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
                                                  @if ($item->id == $product->modal_id)
                                                  <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                                    @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                  @endif
                                                      
                                                  @endforeach
                                              </select>
                                            </div>
                                             <div class="form-group" style="{{ $product->modal_id != null ? '':'display: none' }}" id="showModal" >
                                                <label for="name">Modal</label>
                                                <input type="text" class="form-control" value="{{  number_format($product->modal,0,",",".") }}" id="modalProductShow" readonly >
                                                <input type="hidden" class="form-control" value="{{  $product->modal }}" id="modalProduct" readonly name="modalProduct">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Harga Jual</label>
                                                <input type="number" name="harga" id="name" value="{{ $product->harga }}" placeholder="Masukan Harga..." class="form-control @error('harga') is-invalid @enderror" >
                                                     @error('harga')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Stok</label>
                                                <input type="number" name="stok" id="stok" value="{{ $product->stok }}" placeholder="Masukan Stok..." class="form-control @error('stok') is-invalid @enderror" >
                                                     @error('stok')
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
                const hasil = new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 5 }).format(response);

                $('#modalProductShow').val(hasil)
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