@extends('layouts.admin')

@section('content')
       <main>
        <div class="container-fluid">
            
            <div class="card mb-4">
                <div class="card-header d-flex">
                     <a href="{{ route('rumah-bumn.show',$data->rb_id) }}" class="btn btn-primary" style="margin-top: -5px"><i class="fas fa-arrow-circle-left"></i></a> Data Transaksi Mitra {{ $data->name }}
                    <input type="hidden"  id="rb_id" value="{{ $data->id }}">
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
                                    <th>Aksi</th>
                                    
                                </tr>
                            </thead>
                        
                        </table>
                        <div class="ml-auto">
                            Total Transaksi {{ moneyFormat($totalTransaksi) }} <br>
                            <form action="{{ route('transaksi-admin-download-pdf') }}" method="POST">
                                @csrf
                    <input type="hidden" value="{{ $data->id }}" name="user_id" id="user_id">
                                      

                                        <button type="submit" class="btn btn-primary">Download PDF</button>
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
       
    $(function () {
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        const rb_id = document.getElementById("rb_id").value;
        $('#status-table').DataTable({
            processing: true,
            serverSide: true,
             retrieve: true,
            ajax: {
                 url: "{{ url("admin/rumah-bumn/transaksi") }}/"+rb_id ,

            },
            columns: [
             { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'product.name', name: 'product.name' },
                { data: 'totalQuantity', name: 'quantity' },
                { data: 'total', name: 'total' },
                { data: 'laba', name: 'laba' },
                { data: 'aksi', name: 'aksi' },
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