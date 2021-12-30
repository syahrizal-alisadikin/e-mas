@extends('layouts.dashboard')

@section('content')
       <main>
        <div class="container-fluid">
             <form class=" mb-4" method="GET" action="{{ route('transaction-laporan') }}">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Tanggal Awal</label>
                                        <input type="date" name="start" value="{{ request()->start }}" required class="form-control" placeholder="First name">
                                        </div>
                                        <div class="col">
                                            <label for="">Tanggal Akhir</label>

                                        <input type="date" name="end" value="{{ request()->end }}" required class="form-control" placeholder="Last name">
                                        </div>
                                        <div class="col">
                                            <br>
                                            
                                <button type="submit" class="btn btn-primary mt-2">Cari</button>

                                        </div>
                                    </div>
                                    </form>
            <div class="card mb-4">
                <div class="card-header d-flex">
                    <a href="{{ route('laporan-penjualan-product.create') }}" class="btn btn-success" name="tambah" id="tambah">Tambah Transaksi</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="bahan-table" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Harga</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                   
                                    
                                </tr>
                            </thead>
                            
                        </table>
                        <div class="ml-auto">
                            Total Transaksi {{ moneyFormat($totalTransaksi) }} <br>
                            <a href="{{ route('transaksi-download-pdf') }}" target="_blank" class="btn btn-primary">Download PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@push('addon-script')


<script>
    $(function () {
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $('#bahan-table').DataTable({
            processing: true,
            serverSide: true,
             retrieve: true,
            ajax: '{!! route('laporan-penjualan-product.index') !!}',
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'product.name', name: 'product.name' },
                { data: 'product.harga', name: 'product.name' },
                { data: 'quantity', name: 'quantity' },
                { data: 'total', name: 'quantity' },
                { data: 'tanggal', name: 'quantity' },
                


                
                
            ],    
            columnDefs: [
            {
                "targets": 0, // your case first column
                "className": "text-center",
            }, 
             {
                "targets": 1, // your case first column
                "className": "text-center",
            }, 
            {
                "targets": 2, // your case first column
                "className": "text-center",
            }, 
             {
                "targets": 3, // your case first column
                "className": "text-center",
            }, 
             {
                "targets": 4, // your case first column
                "className": "text-center",
            }, 
          
        ]
           
        });
     
    })
  </script>
@endpush