@extends('layouts.mitra')

@section('content')
       <main>
        <div class="container-fluid">
            
            <div class="card mb-4">
                <div class="card-header d-flex">
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#CreateModalStatus" ><i class="fa fa-plus"></i> Status Umkm</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="status-table" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                   <th>Status UMKM</th>
                                   <th>Created</th>
                                    <th>Aksi</th>
                                   
                                    
                                </tr>
                            </thead>
                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
<div class="modal fade" id="CreateModalStatus" tabindex="-1" role="dialog" aria-labelledby="CreateModalStatus" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modelHeading">Tambah Status UMKM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="statusForm" method="POST" action="{{ route('status-umkm.store') }}">
            @csrf
            <div class="form-group">
                <label for="formGroupExampleInput">Nama Status UMKM</label>
                <input type="text" name="name" class="form-control" id="formGroupExampleInput" placeholder="Example input">
                <input type="hidden" name="id" class="form-control" id="status_id">
                 <span id="invalid-feedback" class="alert-message"></span>
            </div>
           <div class="form-group">
               <button type="submit" id="saveBtn" class="btn btn-primary">Save changes</button>
   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           </div>
            </form>
      </div>
   
    </div>
  </div>
</div>
<div class="modal fade" id="EditModalStatus" tabindex="-1" role="dialog" aria-labelledby="EditModalStatus" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modelHeading">Edit Status UMKM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="statusUpdate" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="formGroupExampleInput">Nama Status UMKM</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Example input">
                <input type="hidden" name="id" class="form-control" id="status_id">
                 <span id="invalid-feedback" class="alert-message"></span>
            </div>
           <div class="form-group">
               <button type="submit" id="saveBtn" class="btn btn-primary">Edit</button>
   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           </div>
            </form>
      </div>
   
    </div>
  </div>
</div>
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
            ajax: '{!! route('status-umkm.index') !!}',
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'name', name: 'name' },
                { data: 'user.name', name: 'user.name' },
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