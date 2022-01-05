@extends('layouts.dashboard')

@section('content')
      <main >
                    <div class="container-fluid">
                       
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Tambah Transaksi
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('laporan-penjualan-product.store')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                          
                                           <div class="form-group">
                                               <label for="">Product</label>
                                               <select class="form-control" required name="product_id" id="product_id" >
                                                    <option value="">Pilih Produk</option>
                                                   
                                                @foreach ($product as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    
                                                    @endforeach
                                                  
                                                </select>
                                           </div>
                                           <div class="form-group">
                                                <label for="name">Harga</label>
                                                <input type="text"  id="hargaView" readonly class="form-control " >
                                                <input type="hidden" name="harga"  id="harga"  class="form-control " >
                                                     
                                            </div>
                                             <div class="form-group">
                                                <label for="name">Quantity</label>
                                                <input type="text" name="quantity" required id="quantity" placeholder="Masukan Quantity..." class="form-control @error('quantity') is-invalid @enderror" >
                                                     @error('quantity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Total</label>
                                                <input type="text"  id="totalView" readonly class="form-control " >
                                                <input type="hidden" name="total"  id="total"  class="form-control " >
                                                     
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Tanggal</label>
                                                <input type="date" value="{{ date('Y-m-d') }}" name="tanggal" required  class="form-control @error('tanggal') is-invalid @enderror" >
                                                     @error('tanggal')
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
        $(document).ready(function() {
            $('#bahan').select2({
                placeholder: 'Pilih Bahan'
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#quantity').on('keyup',function(){
               const product = $('#product_id').val();

                let quantity = $(this).val();
                var timeout;
                
                if(timeout) {
                    clearTimeout(timeout);
                }
                 timeout = setTimeout(function(){
            $.ajax({
            type : 'get',
            url : `/api/product/${product}`,
           
            success:function(data){
                const hasil = new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 5 }).format(data.harga * quantity);

                $('#totalView').val(hasil)
                $('#total').val(data.harga * quantity)
              }
            });
      },500)
            });
        });
    </script>

     <script>
        $(document).ready(function() {
            $('#product_id').on('change',function(){

                let product = $(this).val();
                var timeout;
                
                if(timeout) {
                    clearTimeout(timeout);
                }
                 timeout = setTimeout(function(){
            $.ajax({
            type : 'get',
            url : `/api/product/${product}`,
           
            success:function(data){
                const hasil = new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 5 }).format(data.harga);
                $('#hargaView').val(hasil)
                $('#harga').val(data.harga)
              }
            });
      },500)
            });
        });
    </script>

@endpush