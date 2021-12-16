<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Modal;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $product = Product::whereHas('user',function($q){
                $q->where('rb_id',Auth::user()->id);
            })->with('user')->latest()->get();
            return Datatables::of($product)
                ->addColumn('harga', function ($data) {

                    return moneyFormat($data->harga);
                })
                ->addColumn('modal', function ($data) {

                    return moneyFormat($data->modal);
                })
                ->addColumn('foto', function ($data) {

                     return $data->foto ? '<img src="' . Storage::url('product/' . $data->foto) . '" style="max-width:100px;" />' : '';
                })
                ->addColumn('aksi',function($data){
                    $edit = '<a href="products-mitra/' . $data->id . '/edit" data-toggle="tooltip" data-placement="top"   title="Edit Produk" class="btn btn-success btn-sm"> <i class="fa  fa-pencil-alt"></i> </a>';
                    $button = $edit . ' <a href="javascript:void(0)" data-toggle="tooltip" onClick="Delete(this.id)"  id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm" >   <i class="fa  fa-trash"></i> </a>';
                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['harga','modal','aksi','foto'])
                ->make(true);
        }
        return view('pages.mitra.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modal = Modal::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
        })->get();
        $user = User::where('rb_id',Auth::user()->id)->get();
        return view('pages.mitra.product.create',compact('modal','user'));
        
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
                    'name'    => 'required',
                    'harga'    => 'required',
                    'stok'    => 'required',
                    'foto'    => 'required|image|mimes:jpg,png',
                ]
            );
            $file = $request->file('foto');
            $file->storeAs('public/product', $file->hashName());
        Product::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'modal_id' => $request->modal,
            'modal' => $request->modalProduct,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $file->hashName()
        ]);

        return redirect()->route('products-mitra.index')->with('success','Data berhasil disimpan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $modal = Modal::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
        })->get();
        $user = User::where('rb_id',Auth::user()->id)->get();

        return view('pages.mitra.product.edit',compact('modal','product','user'));
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
        $product = Product::findOrFail($id);
        $this->validate(
                $request,
                [
                    'name'    => 'required',
                    'harga'    => 'required',
                    'stok'    => 'required',
                ]
            );

            if($request->file('foto')){
                $file = $request->file('foto');
                $file->storeAs('public/product', $file->hashName());
                $product->update([
                    'user_id' => $request->user_id,
                    'name' => $request->name,
                    'modal_id' => $request->modal,
                    'modal' => $request->modalProduct,
                    'harga' => $request->harga,
                    'stok' => $request->stok,
                    'foto' => $file->hashName(),
                ]);
            }else{

                $product->update([
                    'user_id' => $request->user_id,
                    'name' => $request->name,
                    'modal_id' => $request->modal,
                    'modal' => $request->modalProduct,
                    'harga' => $request->harga,
                    'stok' => $request->stok,
                ]);
            }
        return redirect()->route('products-mitra.index')->with('success','Data berhasil disimpan!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $product = Product::findOrFail($id);
        $product->delete();

        if($product){
              return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
