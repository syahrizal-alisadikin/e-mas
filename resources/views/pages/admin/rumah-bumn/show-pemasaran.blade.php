@extends('layouts.admin')

@section('content')
       <main>
        <div class="container-fluid">
            
            <div class="card mb-4">
                <div class="card-header d-flex">
                     <a href="{{ route('rumah-bumn.show',$data->rb_id) }}" class="btn btn-primary" style="margin-top: -5px"><i class="fas fa-arrow-circle-left"></i></a> Data Pemasaran Mitra {{ $data->name }}
                    <input type="hidden"  id="rb_id" value="{{ $data->id }}">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="status-table" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                   <th>No</th>
                                    <th>Name</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Keterangan Kegiatan</th>
                                    
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
                 url: "{{ url("admin/rumah-bumn/pemasaran") }}/"+rb_id ,

            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
               { data: 'name', name: 'name' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'jenis', name: 'jenis' },
                { data: 'keterangan', name: 'keterangan' },
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