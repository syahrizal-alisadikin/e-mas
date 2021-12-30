<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DataAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
class DataAsetController extends Controller
{
    public function index()
    {
         if(request()->ajax()){
//             
            $data = DataAset::where('user_id',Auth::user()->id)->latest()->get();
            return Datatables::of($data)
                  ->addColumn('harga', function ($data) {

                    return moneyFormat($data->harga);
                })
                ->addColumn('aksi',function($data){
                    $edit = '<a href="' . route('data-aset.edit', $data->id) . '" data-toggle="tooltip" data-placement="top"   title="Edit Produk" class="btn btn-success btn-sm"> <i class="fa  fa-pencil-alt"></i> </a>';
                    $button = $edit . ' <a href="javascript:void(0)" data-toggle="tooltip" onClick="Delete(this.id)"  id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm" >   <i class="fa  fa-trash"></i> </a>';
                    return $button;
                })
                ->addColumn('tanggal',function($date){
                    return dateID($date->tanggal);
                })
                ->addIndexColumn()
                ->rawColumns(['harga','aksi','tanggal'])
                ->make(true);
        }
        return view('pages.user.data.index');
    }

    public function create()
    {
        return view('pages.user.data.create');
    }

    public function store(Request $request)
    {
        $this->validate(
                $request,
                [
                    'name'    => 'required|unique:data_asets',
                    'harga'    => 'required',
                    'tanggal'    => 'required',
                ]
            );
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        DataAset::create($data);

        return redirect()->route('data-aset.index')->with('success','Berhasil disimpan');
    }

    public function edit($id)
    {
        $data = DataAset::findOrFail($id);
        return view('pages.user.data.edit',compact('data'));
    }

    public function update(Request $request,$id)
    {
        $data = DataAset::findOrFail($id);
        $data->update([
            'name' => $request->name,
            'harga' => $request->harga,
            'tanggal' => $request->tanggal,
        ]);
        return redirect()->route('data-aset.index')->with('success','Berhasil disimpan');

    }

    public function destroy($id)
    {
        $data = DataAset::findOrFail($id);
        $data->delete();
        if($data){
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
