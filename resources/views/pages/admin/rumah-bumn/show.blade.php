@extends('layouts.admin')

@section('content')
       <main>
        <div class="container-fluid">
            
            <div class="card mb-4">
                <div class="card-header d-flex">
                   <a href="{{ route('rumah-bumn.index') }}" class="btn btn-primary" style="margin-top: -5px"><i class="fas fa-arrow-circle-left"></i></a> Data Mitra Rumah BUMN {{ $data->name }}
                    <input type="hidden"  id="rb_id" value="{{ $data->id }}">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="status-table" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    {{-- <th>Pemilik</th> --}}
                                    {{-- <th>Status</th> --}}
                                    <th>Aksi</th>
                                   
                                    
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
        $('#status-table').DataTable({
            processing: true,
            serverSide: true,
             retrieve: true,
            ajax: {
                 url: "{{ url("admin/rumah-bumn") }}/"+rb_id,

            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                // { data: 'pemilik', name: 'pemilik' },
                // { data: 'status', name: 'status' },
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
            
          
        ]
           
        });
     
    })
        
    </script>
@endpush