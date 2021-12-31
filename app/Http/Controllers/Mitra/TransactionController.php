<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use PDF;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(request()->ajax()){
            $product = Transaction::whereHas('user',function($q){
                $q->where('rb_id',Auth::user()->id);
            })->groupBy('user_id')->selectRaw('sum(total) as total, sum(quantity) as quantity,user_id,product_id')->with('user','product')->latest()->get();
            
            return Datatables::of($product)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
              ->addColumn('aksi', function ($data) {

                    $button = ' <a href="' . route('transactions.show',$data->user_id) . '" data-toggle="tooltip"   id="' . $data->id . '" data-original-title="Delete" class="btn btn-primary btn-sm" >   <i class="fa  fa-eye"></i> </a>';
                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['total','aksi'])
                ->make(true);
        }

        return view('pages.mitra.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
        })->get();
        return view('pages.mitra.transaction.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        if($product->stok - $request->quantity < 0){
            return redirect()->back()->with('info','Stok sisa '.$product->stok.' Tidak cukup');
        }
        $product->decrement('stok', $request->quantity);
       $transaksi = Transaction::create([
        'user_id' => $product->user_id,
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'total' => $request->total,
        'tanggal' => $request->tanggal,
       ]);

       return redirect()->route('transactions.index')->with('success','data berhasil disimpan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         if(request()->ajax()){
            $transaksi = Transaction::where('user_id',$id)->with('user','product')->latest()->get();
            return Datatables::of($transaksi)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('harga', function ($data) {

                    return moneyFormat($data->product->harga);
                })
                ->addColumn('tanggal', function ($data) {

                    return dateID($data->tanggal);
                })
                
                ->addIndexColumn()
                ->rawColumns(['total','tanggal','harga'])
                ->make(true);
         }
        $totalTransaksi = Transaction::where('user_id',$id)->with('user','product')->sum('total');

        return view('pages.mitra.transaction.show',compact('id','totalTransaksi'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function TransactionLaporan(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $data = [$start,$end];
        if(request()->ajax()){
          
            $transaksi = Transaction::where('user_id',$request->user_id)->whereBetween('tanggal', $data)->with('user','product')->latest()->get();
            // dd($transaksi);
            return Datatables::of($transaksi)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('tanggal', function ($data) {

                    return dateID($data->created_at);
                })
                 ->addColumn('harga', function ($data) {

                    return moneyFormat($data->product->harga);
                })                
                ->addIndexColumn()
                ->rawColumns(['total','tanggal','harga'])
                ->make(true);
        }
        $totalTransaksi = Transaction::where('user_id',$request->user_id)->whereBetween('tanggal', $data)->sum('total');
        // dd($totalTransaksi);
        return view('pages.mitra.transaction.laporan',compact('totalTransaksi'));
    }

    public function TransaksiDownloadPdf()
    {
        $transaksi = Transaction::where('user_id',request()->user_id)->with('user','product')->latest()->get();
        $totalTransaksi = Transaction::where('user_id',request()->user_id)->sum('total');
        $pdf = PDF::loadView('pdf.transaksi-user', compact('transaksi','totalTransaksi'));
        return $pdf->stream('transaksi.pdf');
        
    }

    public function TransaksiDownloadPdfDate(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $data = [$start,$end] ;
        $transaksi = Transaction::where('user_id',$request->user_id)->whereBetween('tanggal', $data)->with('user','product')->latest()->get();
        $totalTransaksi = Transaction::where('user_id',$request->user_id)->whereBetween('tanggal', $data)->sum('total');
        $pdf = PDF::loadView('pdf.transaksi-user', compact('transaksi','totalTransaksi'));
            return $pdf->stream('transaksi.pdf');
    }
}
