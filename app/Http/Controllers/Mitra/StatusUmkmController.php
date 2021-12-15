<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\StatusUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
class StatusUmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(request()->ajax()){
            $status = StatusUmkm::with('user')->latest()->get();

            return Datatables::of($status)
              
                 ->addColumn('aksi',function($data){
                    $edit = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top"  onClick="Edit(this.id)"  id="' . $data->id . '" title="Edit Produk" class="btn btn-success btn-sm"> <i class="fa  fa-pencil-alt"></i> </a>';
                    return $edit;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('pages.mitra.status-umkm.index');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                ]
            );

          $status =  StatusUmkm::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name
            ]);
            if($status){
                    return redirect()->route('status-umkm.index')->with('success','Berhasil disimpan');
                }else{
                    return redirect()->route('status-umkm.index')->with('error','gagal disimpan');

                }
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
        $data = StatusUmkm::findOrFail($id);
        return response()->json($data, 200);
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
        $data = StatusUmkm::findOrFail($id);
        $data->update([
            'name' => $request->name
        ]);
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
}
