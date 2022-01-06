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
                                    <form class=" mb-4" method="GET" action="{{ route('rumah-bumn.detailtransaksi.month',$data->id) }}">
                                        <div class="row">
                                            <div class="col">
                                                <label for="">Tahun</label>
                                            <input type="text" name="tahun" readonly value="{{ date('Y') }}" required class="form-control" placeholder="First name">
                                            </div>
                                            <div class="col">
                                                <label for="">Bulan Awal</label>
                                                <select name="bulan" class="form-control" id="">
                                                    <option value="01">Januari</option>
                                                    <option value="02">Februari</option>
                                                    <option value="03">Maret</option>
                                                    <option value="04">April</option>
                                                    <option value="05">Mei</option>
                                                    <option value="06">Juni</option>
                                                    <option value="07">Juli</option>
                                                    <option value="08">Agustus</option>
                                                    <option value="09">September</option>
                                                    <option value="10">Oktober</option>
                                                    <option value="11">November</option>
                                                    <option value="12">Desember</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col">
                                                <br>
                                                
                                    <button type="submit"  class="btn btn-primary mt-2">Cari</button>
    
                                            </div>
                                        </div>
                                        </form>
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
                                    <th>Tanggal</th>
                                    
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
                 url: "{{ url("admin/rumah-bumn/transaksi") }}/"+rb_id +"/all",

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