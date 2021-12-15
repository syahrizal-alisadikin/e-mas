<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $product = Product::where('user_id',Auth::user()->id)->with('user')->latest()->get();
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
                    $edit = '<a href="products/' . $data->id . '/edit" data-toggle="tooltip" data-placement="top"   title="Edit Produk" class="btn btn-success btn-sm"> <i class="fa  fa-pencil-alt"></i> </a>';
                    $button = $edit . ' <a href="javascript:void(0)" data-toggle="tooltip" onClick="Delete(this.id)"  id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm" >   <i class="fa  fa-trash"></i> </a>';
                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['harga','modal','aksi','foto'])
                ->make(true);
        }
        return view('pages.user.product.index');
    }

    public function create()
    {
        $modal = Modal::where('user_id',Auth::user()->id)->get();
        return view('pages.user.product.create',compact('modal'));

    }

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
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'modal_id' => $request->modal,
            'modal' => $request->modalProduct,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $file->hashName()
        ]);

        return redirect()->route('products.index')->with('success','Data berhasil disimpan!!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $modal = Modal::where('user_id',Auth::user()->id)->get();

        return view('pages.user.product.edit',compact('modal','product'));

    }

    public function update(Request $request,$id)
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
                    'user_id' => Auth::user()->id,
                    'name' => $request->name,
                    'modal_id' => $request->modal,
                    'modal' => $request->modalProduct,
                    'harga' => $request->harga,
                    'stok' => $request->stok,
                    'foto' => $file->hashName(),
                ]);
            }else{

                $product->update([
                    'user_id' => Auth::user()->id,
                    'name' => $request->name,
                    'modal_id' => $request->modal,
                    'modal' => $request->modalProduct,
                    'harga' => $request->harga,
                    'stok' => $request->stok,
                ]);
            }
        return redirect()->route('products.index')->with('success','Data berhasil disimpan!!');

    }

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
    
    public function ApiProduct($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }
}
