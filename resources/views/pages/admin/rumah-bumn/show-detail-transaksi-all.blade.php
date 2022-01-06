@extends('layouts.admin')

@section('content')
       <main>
          
        <div class="container-fluid">
             <form class=" mb-4" method="GET" action="{{ url('admin/rumah-bumn/transaksi/detail-all/'.$data->id) }}">
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
                     <a href="{{ route('rumah-bumn.transaksi',$data->id) }}" class="btn btn-primary" style="margin-top: -5px"><i class="fas fa-arrow-circle-left"></i></a> Data Transaksi Mitra {{ $data->name }}
                    <input type="hidden"  id="rb_id" value="{{ $data->id }}">
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

    const rb_id = document.getElementById("rb_id").value;
    const user = document.getElementById("user_id").value;
    let start = document.getElementsByName("start")[0].value;
    let end = document.getElementsByName("end")[0].value;
    let startTo = start.toString();
    let endTo = end.toString();

        $('#status-table').DataTable({
            processing: true,
            // serverSide: true,
             retrieve: true,
            ajax: {
                 url: "{{ url("admin/rumah-bumn/transaksi/detail-all") }}/"+user ,
                 "data":{
                "start":start,
                "end":end
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