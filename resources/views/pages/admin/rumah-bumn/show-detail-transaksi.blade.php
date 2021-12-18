@extends('layouts.admin')

@section('content')
       <main>
        <div class="container-fluid">
             <form class=" mb-4" method="GET" action="{{ url('admin/rumah-bumn/transaksi/detail/'.$data->id.'/'.$data->user_id) }}">
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
                     <a href="{{ route('rumah-bumn.transaksi',$data->user->id) }}" class="btn btn-primary" style="margin-top: -5px"><i class="fas fa-arrow-circle-left"></i></a> Data Transaksi Mitra {{ $data->name }}
                    <input type="hidden"  id="rb_id" value="{{ $data->id }}">
                    <input type="hidden"  id="user_id" value="{{ $data->user_id }}">
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
                                    <th>Tanggal</th>
                                    
                                </tr>
                            </thead>
                        
                        </table>
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
                 url: "{{ url("admin/rumah-bumn/transaksi/detail") }}/"+rb_id+"/"+user ,
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
             
            
          
        ]
           
        });
     
    })
        
    </script>
@endpush