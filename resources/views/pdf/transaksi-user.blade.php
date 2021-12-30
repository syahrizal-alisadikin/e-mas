<html>
<head>
    @php
            $user = Auth::user();
        @endphp
    <title>Laporan Transaksi </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <style type="text/css">
        table tr td,
        table tr th{
            font-size: 9pt;
        }
    </style>
    <center>
        <h4>Laporan Transaksi</h4>
        {{ request()->start }} - {{ request()->end }} <br>
           
       
        
    </center>
 
    <table class='table table-bordered'>
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Name</th>
                <th>Harga</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Tanggal</th>
                                   
            </tr>
        </thead>
        <tbody>
              @forelse ($transaksi as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>

                                    <td scope="col">{{ $item->product->name }}</td>
                                    <td>Rp{{ number_format($item->product->harga,0,",",".") }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp{{ number_format($item->total,0,",",".") }}</td>

                                   <td>{{ dateID($item->tanggal) }}</td>
                                    
                                    
                                </tr>
                               
                                @empty
                                    <tr class="text-center">
                                        <td colspan="5">Belum ada data</td>
                                    </tr>
                                    @endforelse
        </tbody>
    </table>
  Total Transaksi {{ moneyFormat($totalTransaksi) }} <br>
</body>
</html>