<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use DataTables;

use Illuminate\Support\Facades\Auth;
class LaporanPenjualanController extends Controller
{
    public function index()
    {
         if(request()->ajax()){
            $product = Transaction::where('user_id',Auth::user()->id)->with('user','product')->latest()->get();
            
            return Datatables::of($product)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('tanggal', function ($data) {

                    return dateID($data->tanggal);
                })
                
                ->addIndexColumn()
                ->rawColumns(['total','tanggal'])
                ->make(true);
        }

        return view('pages.user.transaction.index');



    }

    public function create()
    {
        $product = Product::where('user_id',Auth::user()->id)->get();
        return view('pages.user.transaction.create',compact('product'));

    }

    public function show($id)
    {
        //
        $transaksi = Transaction::whereBetween('created_at', [request()->start, request()->end])->get();
        return $transaksi;
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        if($product->stok - $request->quantity < 0){
            return redirect()->back()->with('info','Stok sisa '.$product->stok.' Tidak cukup');
        }
        $product->decrement('stok', $request->quantity);
       $transaksi = Transaction::create([
        'user_id' => Auth::user()->id,
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'total' => $request->total,
        'tanggal' => $request->tanggal,
       ]);

       return redirect()->route('laporan-penjualan-product.index')->with('success','data berhasil disimpan!!');
    }

    public function TransactionLaporan(Request $request)
    {
        
        if(request()->ajax()){
            $start = $request->input('start');
            $end = $request->input('end');
            $data = [$start,$end];
          
            $transaksi = Transaction::whereBetween('tanggal', $data)->with('user','product')->latest()->get();
            // dd($transaksi);
            return Datatables::of($transaksi)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('tanggal', function ($data) {

                    return dateID($data->created_at);
                })
                
                ->addIndexColumn()
                ->rawColumns(['total','tanggal'])
                ->make(true);
        }

        return view('pages.user.transaction.laporan');
    }
}
