@extends('layouts.admin')

@section('content')
       <main>
          
        <div class="container-fluid">
            <form class=" mb-4" method="GET" action="{{ route('rumah-bumn.detailtransaksi.month',$data->id)  }}">
                <div class="row">
                   
                    <div class="col">
                        <label for="">Bulan</label>

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
                     <a href="{{ route('rumah-bumn.transaksi',$data->id) }}" class="btn btn-primary" style="margin-top: -5px"><i class="fas fa-arrow-circle-left"></i></a> Data Transaksi Mitra {{ $data->name }}
                    <input type="hidden"  id="user_id" value="{{ $data->id }}">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="status-table" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                       <th>No</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Laba</th>
                                    <th>Tanggal</th>
                                    
                                </tr>
                            </thead>
                        
                        </table>
                        <div class="ml-auto">
                            Total Transaksi {{ moneyFormat($totalTransaksi) }} <br>
                            <form action="{{ route('transaksi-admin-download-pdf') }}" method="POST">
                                @csrf
                    <input type="hidden" value="{{ $data->user_id }}" name="user_id" id="user_id">
                                      

                                        <button type="submit" class="btn btn-primary">Download PDF</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        @if (request()->start && request()->end)
        <div class="row">

         <!-- Area Chart -->
          <div class="col-md-12 mb-4">
         {!! $transactions->container() !!}
         </div>

      
     </div>

        @endif
    </main>
    <script src="{{ LarapexChart::cdn() }}"></script>
    {{  request()->start != null ? $transactions->script() : null
        
    }}
@endsection



@push('addon-script')

    <script>
       
    $(function () {
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        const user = document.getElementById("user_id").value;
        const bulan = document.getElementById("bulan").value;
        const tahun = document.getElementById("tahun").value;

        $('#status-table').DataTable({
            processing: true,
            // serverSide: true,
             retrieve: true,
            ajax: {
                 url: "{{ url("admin/rumah-bumn/transaksi/detail-Month") }}/"+user ,
                 "data":{
                "bulan":bulan,
                "tahun":tahun
            }

            },
            columns: [
             { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'product.name', name: 'product.name' },
                { data: 'quantity', name: 'quantity' },
                { data: 'total', name: 'total' },
                { data: 'laba', name: 'laba' },
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
             
            
          
        ]
           
        });
     
    })
        
    </script>
@endpush