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
                    $transaksi = '<a href="transaksi/'.$data->id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Transaksi Mitra" class="btn btn-success btn-sm"> <i class="fas  fa-dollar-sign"></i> </a>';
                    $produk = $transaksi .'<a href="pemasaran/'.$data->id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Pemasaran Produk" class="btn btn-primary ml-1 btn-sm"><i class="fab fa-product-hunt"></i> </a>';
                    $button = $produk .'<a href="produk/'.$data->id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Stok Produk" class="btn btn-secondary ml-1 btn-sm"><i class="fas fa-boxes"></i> </a>';
                   
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
                                    ->selectRaw('sum(quantity) as totalQuantity,sum(total) as total,user_id,product_id')
                                    ->orderBy('total','desc')
                                    ->get();
            
            return Datatables::of($product)
                ->addColumn('total', function ($data) {

                    return moneyFormat($data->total);
                })
                  ->addColumn('aksi',function($data){
                    $transaksi = '<a href="detail/'.$data->product_id.'/'.$data->user_id.'" id="tooltip"  data-toggle="tooltip" data-placement="top" title="Detaill Transaksi" class="btn btn-primary btn-sm"> <i class="fas  fa-eye"></i> </a>';
                   
                    return $transaksi;
                })
                
                ->addIndexColumn()
                ->rawColumns(['total','tanggal','aksi'])
                ->make(true);
        }

         $data = User::find($id);
        return view('pages.admin.rumah-bumn.show-transaksi',compact('data'));
    }

     public function DetailTransaksi(Request $request,$id,$user)
    {
        $start = $request->input('start');
            $end = $request->input('end');
            $data = [$start,$end];
        
         if(request()->ajax()){
            $product = Transaction::when(request()->start, function($q){
                $q->whereBetween('tanggal',[ request()->input('start'), request()->input('end')]);
            })->where('product_id',$id)
                                    ->where('user_id',$user)
                                    ->with('user','product')
                                    ->latest()
                                    ->get();
            
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

         $data = Product::find($id);
        return view('pages.admin.rumah-bumn.show-detail-transaksi',compact('data'));
    }

    public function MitraAdmin()
    {
        if(request()->ajax()){
        $transaction = Transaction::with('user','product')
                                ->groupBy('user_id')
                                ->selectRaw('sum(quantity) as totalQuantity,sum(total) as total,user_id,product_id')
                                ->orderBy('total','desc')
                                ->get();
                return Datatables::of($transaction)
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

        return view('pages.admin.mitra.index');

    }
}
