@extends('layouts.dashboard')

@section('content')
       <main>
        <div class="container-fluid">
            
            <div class="card mb-4">
                <div class="card-header d-flex">
                    <a href="{{ route('pemasaran.create') }}" class="btn btn-success" name="tambah" id="tambah">Tambah Kegiatan Pemasaran</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="pemasaran-table" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Keterangan Kegiatan</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                {{-- @foreach ($city as $key => $cities)
                                    <tr class="text-center">
                                        <td><?= $i?></td>
                                        <td>{{$cities->name}}</td>
                                        <td class="text-center">
                                        <button class="btn btn-success btn-sm" id="ubahData" onclick="ubahData('{{route('city.update',$cities->city_id)}}','{{$cities->name}}','{{$cities->city_id}}')"  role="button" ><i class="fas fa-pencil-alt"></i></button>
                                            
                                            <form action="{{ route('city.destroy', $cities->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('delete')

                                                <button type="submit" class="btn btn-danger btn-sm"  onclick="return confirm('Yakin Data Mau Dihapus??');"> <i class="fa  fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $i++?>
                                @endforeach --}}
                                
                            </tbody>
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
        $('#pemasaran-table').DataTable({
            processing: true,
            serverSide: true,
             retrieve: true,
            ajax: '{!! route('pemasaran.index') !!}',
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