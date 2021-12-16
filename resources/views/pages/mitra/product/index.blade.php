@extends('layouts.mitra')

@section('content')
       <main>
        <div class="container-fluid">
            
            <div class="card mb-4">
                <div class="card-header d-flex">
                    <a href="{{ route('products-mitra.create') }}" class="btn btn-success" name="tambah" id="tambah">Tambah Product</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="product-table" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>UMKM</th>
                                    <th>Name</th>
                                    <th>Modal</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
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
        $('#product-table').DataTable({
            processing: true,
            serverSide: true,
             retrieve: true,
            ajax: '{!! route('products-mitra.index') !!}',
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'foto', name: 'foto' },
                { data: 'user.name', name: 'user.name' },
                { data: 'name', name: 'name' },
                { data: 'modal', name: 'modal' },
                { data: 'harga', name: 'harga' },
                { data: 'stok', name: 'stok' },
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
    // Delete Order 
     function Delete(id)
        {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    //ajax delete
                    jQuery.ajax({
                        url: "{{ route("products-mitra.index") }}/"+id,
                        data:   {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }else{
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });
                } else {
                    return true;
                }
            })
        }
</script>
@endpush