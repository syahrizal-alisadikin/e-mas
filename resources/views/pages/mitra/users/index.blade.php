@extends('layouts.mitra')

@section('content')
       <main>
        <div class="container-fluid">
            
            <div class="card mb-4">
                <div class="card-header d-flex">
                    <a href="{{ route('users.create') }}" class="btn btn-success" ><i class="fa fa-plus"></i> Mitra Binaan</a>

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
                                    <th>Pemilik</th>
                                    <th>Status</th>
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
        $('#status-table').DataTable({
            processing: true,
            serverSide: true,
             retrieve: true,
            ajax: '{!! route('users.index') !!}',
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'pemilik', name: 'pemilik' },
                { data: 'status', name: 'status' },
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
             {
                "targets": 6, // your case first column
                "className": "text-center",
            }, 
          
        ]
           
        });
     
    })
            function Edit(id) {
            jQuery.ajax({
                     url: '/mitra/status-umkm/'+id+'/edit',
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                      $('#EditModalStatus').modal('show')
                      $('#name').val(response.name)
                       document.getElementById('statusUpdate').action = `../mitra/status-umkm/${response.id}`;
                    },
                });
             }

        $(document).ready(function() {
            $("#statusUpdate").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL UPDATE!',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                }
                });
            });
        });
    </script>
@endpush