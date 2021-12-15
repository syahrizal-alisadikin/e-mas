<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
class BahanController extends Controller
{
     public function index()
    {
        if(request()->ajax()){
            $bahan = Bahan::where('user_id',Auth::user()->id)->with('user')->latest()->get();

            return Datatables::of($bahan)
                ->addColumn('harga', function ($data) {

                    return moneyFormat($data->harga);
                })
                 ->addColumn('aksi',function($data){
                    $edit = '<a href="bahan-product/' . $data->id . '/edit" data-toggle="tooltip" data-placement="top"   title="Edit Produk" class="btn btn-success btn-sm"> <i class="fa  fa-pencil-alt"></i> </a>';
                    $button = $edit . ' <a href="javascript:void(0)" data-toggle="tooltip" onClick="Delete(this.id)"  id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm" >   <i class="fa  fa-trash"></i> </a>';
                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['harga','aksi'])
                ->make(true);
        }
        return view('pages.user.bahan.index');
    }

    public function create()
    {
        return view('pages.user.bahan.create');
    }

    public function store(Request $request)
    {
        $this->validate(
                $request,
                [
                    'name'    => 'required',
                    'harga'    => 'required',
                ]
            );

        Bahan::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'harga' => $request->harga,
        ]);

        return redirect()->route('bahan-product.index')->with('success','Data Berhasil disimpan!!');
    }

    public function edit($id)
    {
        $bahan = Bahan::findOrFail($id);

        return view('pages.user.bahan.edit',compact('bahan'));

    }

    public function update(Request $request,$id)
    {
        $bahan = Bahan::findOrFail($id);
         $this->validate(
                $request,
                [
                    'name'    => 'required',
                    'harga'    => 'required',
                ]
            );

        $bahan->update([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'harga' => $request->harga,
        ]);
        return redirect()->route('bahan-product.index')->with('success','Data Berhasil disimpan!!');

    }

    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        if($bahan){
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
