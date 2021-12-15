<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
class ModalController extends Controller
{
    public function index()
    {
         if(request()->ajax()){
//             $bahan = Modal::where('user_id',Auth::user()->id)->with(['bahan' => function($query){
//    $query->select(DB::raw("SUM(harga) as modal"));
// }] )->latest()->get();
        $bahan = Modal::where('user_id',Auth::user()->id)->with('bahan')->latest()->get();
            return Datatables::of($bahan)
                  ->addColumn('jumlah', function ($data) {

                    $jumlah = Bahan::whereIn('id',$data->bahan()->pluck('bahan_id')->toArray())->sum('harga');
                    return moneyFormat($jumlah);
                })
                ->addColumn('aksi',function($data){
                    $edit = '<a href="modal/' . $data->id . '/edit" data-toggle="tooltip" data-placement="top"   title="Edit Produk" class="btn btn-success btn-sm"> <i class="fa  fa-pencil-alt"></i> </a>';
                    $button = $edit . ' <a href="javascript:void(0)" data-toggle="tooltip" onClick="Delete(this.id)"  id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm" >   <i class="fa  fa-trash"></i> </a>';
                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['jumlah','aksi'])
                ->make(true);
        }
        return view('pages.user.modal.index');
    }

    public function create()
    {
        $bahan = Bahan::where('user_id',Auth::user()->id)->get();
        return view('pages.user.modal.create',compact('bahan'));
    }

    public function store(Request $request)
    {
        $this->validate(
                $request,
                [
                    'name'    => 'required',
                ]
            );
       $modal = Modal::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name
       ]);
       $modal->bahan()->attach($request->input('bahan'));
       $modal->save();

       if($modal){
            //redirect dengan pesan sukses
            return redirect()->route('modal.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('modal.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        $bahan = Bahan::where('user_id',Auth::user()->id)->get();
        $modal = Modal::with('bahan')->findOrFail($id);
        // return $modal->bahan()->pluck('bahan_id')->toArray();
        return view('pages.user.modal.edit',compact('bahan','modal'));
    }

    public function update(Request $request,$id)
    {
        $modal = Modal::with('bahan')->findOrFail($id);
        $this->validate(
                $request,
                [
                    'name'    => 'required',
                ]
            );
        $modal->update([
            'user_id' => Auth::user()->id,
            'name' => $request->name
        ]);
       $modal->bahan()->sync($request->input('bahan'));
        if($modal){
            //redirect dengan pesan sukses
            return redirect()->route('modal.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('modal.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function destroy($id)
    {
        $modal = Modal::with('bahan')->findOrFail($id);

        $modal->delete();

        if($modal){
              return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
    public function ApiModal($id)
    {
        $modal = Modal::with('bahan')->findOrFail($id);
        // $data = $modal->bahan()->pluck('bahan_id')->toArray();
        $jumlah = Bahan::whereIn('id',$modal->bahan()->pluck('bahan_id')->toArray())->sum('harga');

        return response()->json($jumlah);
    }
}
