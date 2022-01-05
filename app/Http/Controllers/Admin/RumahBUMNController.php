<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemasaran;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class RumahBUMNController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(request()->ajax()){
            $rb = User::where('roles','RB')->latest()->get();
            
            return Datatables::of($rb)
              
                 ->addColumn('aksi',function($data){
                    $edit = '<a href="rumah-bumn/'.$data->id.'/edit" id="tooltip"  data-toggle="tooltip" data-placement="top" title="edit data" class="btn btn-primary btn-sm"> <i class="fa  fa-pencil-alt"></i> </a>';
                    $button = $edit .'<a href="rumah-bumn/'.$data->id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Show Mitra" class="btn btn-success ml-1 btn-sm"> <i class="fa  fa-eye"></i> </a>';
                   
                    return $button;
                })
                 ->addColumn('status',function($data){
                    return $data->status_id != null ? $data->status->name :'-';
                })
                ->addIndexColumn()
                ->rawColumns(['aksi','status'])
                ->make(true);
        }
        return view('pages.admin.rumah-bumn.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.rumah-bumn.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate(
                $request,
                [
                    'name'    => 'required|unique:users',
                    'phone'    => 'required|unique:users',
                    'email'    => 'required|unique:users',
                    'pemilik'    => 'required|unique:users',
                    'alamat'    => 'required',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required',
                ]
            );

            User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'pemilik' => $request->pemilik,
                'alamat' => $request->alamat,
                'roles' => "RB",
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('rumah-bumn.index')->with('success','data berhasil disimpan!!');
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
            $user =  User::where('rb_id',$id)->latest()->get();
            
            return Datatables::of($user)
              
                 ->addColumn('aksi',function($data){
                    $transaksi = '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                            Transkasi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        
                        <a href="transaksi/'.$data->id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Transaksi Mitra" class="dropdown-item"> Per Produk </a>
                        <a href="' . route('rumah-bumn.transaksi.all', $data->id) . '" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Transaksi Mitra" class="dropdown-item"> Semua Produk </a>
                           
                        </div>
                    </div>
                    ';
                    $produk ='<a href="pemasaran/'.$data->id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Pemasaran Produk" class="btn btn-primary ml-1 btn-sm">Pemasaran </a>';
                    $button =  '<div class="d-flex text-center">
                    '.$transaksi.''.$produk.'.<a href="produk/'.$data->id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Stok Produk" class="btn btn-secondary ml-1 btn-sm">Produk </a>
                                </div>';
                   
                    return $button;
                })
                 ->addColumn('status',function($data){
                    return $data->status_id != null ? $data->status->name :'-';
                })
                ->addIndexColumn()
                ->rawColumns(['aksi','status'])
                ->make(true);
        }

        $data = User::find($id);
        return view('pages.admin.rumah-bumn.show',compact('data'));

       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $user = User::findOrFail($id);
        return view('pages.admin.rumah-bumn.edit',compact('user'));
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
        $user = User::findOrFail($id);

          $this->validate(
                $request,
                [
                    'name'    => [
                        'required',
                        Rule::unique('users')->ignore($user->id, 'id'),


                    ],
                    'phone'    => [
                        'required',
                        Rule::unique('users')->ignore($user->id, 'id'),


                    ],
                    'email'    => [
                        'required',
                        Rule::unique('users')->ignore($user->id, 'id'),


                    ],
                    
                ]
            );
        
        $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'pemilik' => $request->pemilik,
                'alamat' => $request->alamat,
        ]);
        return redirect()->route('rumah-bumn.index')->with('success','data berhasil disimpan!!');
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

    public function ShowProduk($id)
    {
            
        if(request()->ajax()){
            $produk =  Product::where('user_id',$id)->with('user')->latest()->get();
            
            return Datatables::of($produk)
                 ->addColumn('harga', function ($data) {

                    return moneyFormat($data->harga);
                })
                ->addColumn('modal', function ($data) {

                    return moneyFormat($data->modal);
                })
                ->addColumn('foto', function ($data) {

                     return $data->foto ? '<img src="' . Storage::url('product/' . $data->foto) . '" style="max-width:100px;" />' : '';
                })
                
                
                ->addIndexColumn()
                ->rawColumns(['harga','modal','foto'])

                ->make(true);
        }

        $data = User::find($id);

        return view('pages.admin.rumah-bumn.show-produk',compact('data'));

    }

    public function ShowPemasaran($id)
    {
        if(request()->ajax()){
            $pemasaran =  Pemasaran::where('user_id',$id)->with('user')->latest()->get();
            
                return Datatables::of($pemasaran)
                ->addIndexColumn()
                ->make(true);
        }

        $data = User::find($id);

        return view('pages.admin.rumah-bumn.show-pemasaran',compact('data'));
    }

    public function ShowTransaksi($id)
    {
         if(request()->ajax()){
            $product = Transaction::where('user_id',$id)
                                    ->with('user','product')
                                    ->groupBy('product_id')
                                    ->addSelect(['balance' => Product::selectRaw('sum(modal) as totalModal')
                                    ->whereColumn('id', 'transactions.product_id')
                                    ])
                                    ->selectRaw('sum(quantity) as totalQuantity,sum(total) as total,user_id,product_id')
                                    ->orderBy('total','desc')
                                    ->get();
            
            return Datatables::of($product)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('laba', function ($data) {
                    $modal = $data->balance * $data->totalQuantity;
                    return moneyFormat($data->total- $modal);
                })
                  ->addColumn('aksi',function($data){
                    $transaksi = '<a href="detail/'.$data->product_id.'/'.$data->user_id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Detaill Transaksi" class="btn btn-primary btn-sm"> <i class="fas  fa-eye"></i> </a>';
                   
                    return $transaksi;
                })
                
                ->addIndexColumn()
                ->rawColumns(['total','aksi','laba'])
                ->make(true);
        }
        $totalTransaksi = Transaction::where('user_id',$id)->with('user','product')->sum('total');

         $data = User::find($id);
        return view('pages.admin.rumah-bumn.show-transaksi',compact('data','totalTransaksi'));
    }
    public function ShowTransaksiAll($id)
    {
         if(request()->ajax()){
            $product = Transaction::where('user_id',$id)
                                    ->with('user','product')
                                    ->addSelect(['balance' => Product::selectRaw('sum(modal) as totalModal')
                                    ->whereColumn('id', 'transactions.product_id')
                                    ])
                                    // ->selectRaw('sum(quantity) as totalQuantity,sum(total) as total,user_id,product_id')
                                    ->orderBy('tanggal','desc')
                                    ->get();
            
            return Datatables::of($product)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('laba', function ($data) {
                    $modal = $data->balance * $data->quantity;
                    return moneyFormat($data->total- $modal);
                })
                  ->addColumn('aksi',function($data){
                    $transaksi = '<a href="detail/'.$data->product_id.'/'.$data->user_id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Detaill Transaksi" class="btn btn-primary btn-sm"> <i class="fas  fa-eye"></i> </a>';
                   
                    return $transaksi;
                })
                ->addColumn('tanggal', function ($data) {
    
                    return dateID($data->tanggal);
                })
                
                ->addIndexColumn()
                ->rawColumns(['total','tanggal','aksi','laba'])
                ->make(true);
        }
        $totalTransaksi = Transaction::where('user_id',$id)->with('user','product')->sum('total');

         $data = User::find($id);
        
        return view('pages.admin.rumah-bumn.show-transaksi-all',compact('data','totalTransaksi'));
    }

     public function DetailTransaksi(Request $request,$id,$user)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $year   = date('Y');
        $month  = date('m');
        $day    = date('d');
        $data = [$start,$end];

        if($start && $end){
            $explodeStart = Explode("-",$start);
            $explodeEnd = Explode("-",$end);
            for($explodeStart[2]; $explodeStart[2] <= $explodeEnd[2]; $explodeStart[2]++){
                $transaction[] = Transaction::where('user_id',$user)->where('product_id',$id)->whereDay('tanggal',"=",$explodeStart[2])->whereMonth('tanggal', '=',$explodeStart[1])->whereYear('tanggal', $explodeStart[0])->sum('total');
                $tanggal[] = $explodeStart[2];
            }
            
            $transactions = (new LarapexChart)->areaChart()
            ->setTitle('Laporan Transaction')
            ->addData('Transactions', $transaction)
            ->setXAxis($tanggal);
            if(request()->ajax()){
                $product = Transaction::when(request()->start, function($q){
                    $q->whereBetween('tanggal',[ request()->input('start'), request()->input('end')]);
                })->where('product_id',$id)
                ->addSelect(['balance' => Product::selectRaw('sum(modal) as totalModal')
                ->whereColumn('id', 'transactions.product_id')
                ])
                                        ->where('user_id',$user)
                                        ->with('user','product')
                                        ->latest()
                                        ->get();
                
                return Datatables::of($product)
                    ->addColumn('total', function ($data) {
    
                        return moneyFormat($data->total);
                    })
                    ->addColumn('laba', function ($data) {
                        $modal = $data->balance * $data->quantity;
                        return moneyFormat($data->total- $modal);
                    })
                   ->addColumn('tanggal', function ($data) {
    
                        return dateID($data->tanggal);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['total','tanggal','laba'])
                    ->make(true);
            }
            $totalTransaksi = Transaction::where('user_id',$id)->with('user','product')->sum('total');
    
             $data = Product::find($id);
            return view('pages.admin.rumah-bumn.show-detail-transaksi',compact('data','totalTransaksi','transactions'));
        }
           
         if(request()->ajax()){
            $product = Transaction::when(request()->start, function($q){
                $q->whereBetween('tanggal',[ request()->input('start'), request()->input('end')]);
            })->where('product_id',$id)
            ->addSelect(['balance' => Product::selectRaw('sum(modal) as totalModal')
            ->whereColumn('id', 'transactions.product_id')
            ])
                                    ->where('user_id',$user)
                                    ->with('user','product')
                                    ->latest()
                                    ->get();
            
            return Datatables::of($product)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('laba', function ($data) {
                    $modal = $data->balance * $data->quantity;
                    return moneyFormat($data->total- $modal);
                })
               ->addColumn('tanggal', function ($data) {

                    return dateID($data->tanggal);
                })
                ->addIndexColumn()
                ->rawColumns(['total','tanggal','laba'])
                ->make(true);
        }
        $totalTransaksi = Transaction::where('user_id',$id)->with('user','product')->sum('total');

         $data = Product::find($id);
        return view('pages.admin.rumah-bumn.show-detail-transaksi',compact('data','totalTransaksi'));
    }
    public function DetailTransaksiAll(Request $request,$id)
    {

        $start = $request->input('start');
        $end = $request->input('end');
        $year   = date('Y');
        $month  = date('m');
        $day    = date('d');
        $data = [$start,$end];

        if($start && $end){
            $explodeStart = Explode("-",$start);
            $explodeEnd = Explode("-",$end);
            for($explodeStart[2]; $explodeStart[2] <= $explodeEnd[2]; $explodeStart[2]++){
                $transaction[] = Transaction::where('user_id',$id)->whereDay('tanggal',"=",$explodeStart[2])->whereMonth('tanggal', '=',$explodeStart[1])->whereYear('tanggal', $explodeStart[0])->sum('total');
                $tanggal[] = $explodeStart[2];
            }
            
            $transactions = (new LarapexChart)->areaChart()
            ->setTitle('Laporan Transaction')
            ->addData('Transactions', $transaction)
            ->setXAxis($tanggal);
            if(request()->ajax()){
                $product = Transaction::when(request()->start, function($q){
                    $q->whereBetween('tanggal',[ request()->input('start'), request()->input('end')]);
                })->where('user_id',$id)
                ->addSelect(['balance' => Product::selectRaw('sum(modal) as totalModal')
                ->whereColumn('id', 'transactions.product_id')
                ])->with('user','product')
                    ->orderBy('tanggal','desc')
                    ->get();
                
                return Datatables::of($product)
                    ->addColumn('total', function ($data) {
    
                        return moneyFormat($data->total);
                    })
                    ->addColumn('laba', function ($data) {
                        $modal = $data->balance * $data->quantity;
                        return moneyFormat($data->total- $modal);
                    })
                   ->addColumn('tanggal', function ($data) {
    
                        return dateID($data->tanggal);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['total','tanggal','laba'])
                    ->make(true);
            }
            $totalTransaksi = Transaction::whereBetween('tanggal',[ request()->input('start'), request()->input('end')])->where('user_id',$id)->with('user','product')->sum('total');
    
             $data = User::find($id);
            return view('pages.admin.rumah-bumn.show-detail-transaksi-all',compact('data','totalTransaksi','transactions'));
        }
           
         if(request()->ajax()){
            $product = Transaction::when(request()->start, function($q){
                $q->whereBetween('tanggal',[ request()->input('start'), request()->input('end')]);
            })->where('product_id',$id)
            ->addSelect(['balance' => Product::selectRaw('sum(modal) as totalModal')
            ->whereColumn('id', 'transactions.product_id')
            ])
                                    ->where('user_id',$id)
                                    ->with('user','product')
                                    ->latest()
                                    ->get();
            
            return Datatables::of($product)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('laba', function ($data) {
                    $modal = $data->balance * $data->quantity;
                    return moneyFormat($data->total- $modal);
                })
               ->addColumn('tanggal', function ($data) {

                    return dateID($data->tanggal);
                })
                ->addIndexColumn()
                ->rawColumns(['total','tanggal','laba'])
                ->make(true);
        }
        $totalTransaksi = Transaction::where('user_id',$id)->with('user','product')->sum('total');

         $data = Product::find($id);
        return view('pages.admin.rumah-bumn.show-detail-transaksi',compact('data','totalTransaksi'));
    }

    public function MitraAdmin()
    {
        if(request()->ajax()){
        $transaction = Transaction::with('user','product')
                                ->groupBy('user_id')
                                ->addSelect(['balance' => Product::selectRaw('sum(modal) as totalModal')
                                ->whereColumn('id', 'transactions.product_id')
                                ])
                                ->selectRaw('sum(total) as total,sum(quantity) as totalQuantity,user_id,product_id')
                                ->orderBy('total','desc')
                                ->get();
                return Datatables::of($transaction)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                ->addColumn('laba', function ($data) {
                    $laba = $data->balance * $data->totalQuantity;
                    return moneyFormat($data->total-$laba);
                })
               ->addColumn('tanggal', function ($data) {

                    return dateID($data->user->created_at);
                })
                ->addIndexColumn()
                ->rawColumns(['total','tanggal','laba'])
                ->make(true);
        }

        return view('pages.admin.mitra.index');

    }
}
