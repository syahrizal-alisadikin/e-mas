@extends('layouts.dashboard')

@section('content')
       <main>
        <div class="container-fluid">
             <form class=" mb-4" method="GET" action="{{ route('transaction-laporan-month') }}">
                                    <div class="row">
                                       
                                        <div class="col">
                                            <label for="">Bulan</label>

                                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" required class="form-control" >
                                            <input type="hidden" name="bulan_id" id="bulan" value="{{ request()->bulan }}" required class="form-control" >
                                            <input type="hidden" name="tahun" id="tahun" value="{{ request()->tahun }}" required class="form-control" >
                                            <select name="bulan" class="form-control" required>
                                                <option value="01" {{ request()->bulan == "01" ? "selected" : ""}}>Januari</option>
                                                <option value="02" {{ request()->bulan == "02" ? "selected" : ""}}>Februari</option>
                                                <option value="03" {{ request()->bulan == "03" ? "selected" : ""}}>Maret</option>
                                                <option value="04" {{ request()->bulan == "04" ? "selected" : ""}}>April</option>
                                                <option value="05" {{ request()->bulan == "05" ? "selected" : ""}}>Mei</option>
                                                <option value="06" {{ request()->bulan == "06" ? "selected" : ""}}>Juni</option>
                                                <option value="07" {{ request()->bulan == "07" ? "selected" : ""}}>Juli</option>
                                                <option value="08" {{ request()->bulan == "08" ? "selected" : ""}}>Agustus</option>
                                                <option value="09" {{ request()->bulan == "09" ? "selected" : ""}}>September</option>
                                                <option value="10" {{ request()->bulan == "10" ? "selected" : ""}}>Oktober</option>
                                                <option value="11" {{ request()->bulan == "11" ? "selected" : ""}}>November</option>
                                                <option value="12" {{ request()->bulan == "12" ? "selected" : ""}}>Desember</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for=""></label>
                                            <br>
                                <button type="submit" class="btn btn-primary mt-2">Cari</button>

                                        </div>
                                    </div>
                                    </form>
            <div class="card mb-4">
              
                <div class="card-header d-flex">
                    <a href="{{ route('transactions.create') }}" class="btn btn-success " name="tambah" id="tambah">Tambah Transaksi</a>
                   
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="bahan-table" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>UMKM</th>
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
        
        const user_id = document.getElementById("user_id").value;
        const bulan = document.getElementById("bulan").value;
        const tahun = document.getElementById("tahun").value;
       
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $('#bahan-table').DataTable({
            processing: true,
            // serverSide: true,
             retrieve: true,
            ajax: { "url" : "laporan-penjualan-product-month",
                       "data":{
                "bulan":bulan,
                "tahun":tahun,
                'user_id':user_id
            }
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'user.name', name: 'user.name' },
                { data: 'product.name', name: 'product.name' },
                { data: 'harga', name: 'harga' },
                { data: 'quantity', name: 'quantity' },
                { data: 'total', name: 'total' },
                { data: 'tanggal', name: 'tanggal' },
                


                
                
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
            {
                "targets": 5, // your case first column
                "className": "text-center",
            }, 
            {
                "targets": 6, // your case first column
                "className": "text-center",
            }, 
          
        ]
           
        });
     
    })
  </script>
@endpush