<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pemasaran;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
class PemasaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(request()->ajax()){
            $pemasaran = Pemasaran::whereHas('user',function($q){
                $q->where('rb_id',Auth::user()->id);
            })->with('user')->latest()->get();
            
            return Datatables::of($pemasaran)
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.mitra.pemasaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('rb_id',Auth::user()->id)->get();
        return view('pages.mitra.pemasaran.create',compact('user'));

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
                    'tanggal'    => 'required',
                    'jenis'    => 'required',
                ]
            );
        Pemasaran::create([
            'user_id' => $request->user_id,
            'name' =>  $request->name,
            'tanggal' =>  $request->tanggal,
            'jenis' =>  $request->jenis,
            'keterangan' =>  $request->keterangan,
        ]);

        return redirect()->route('pemasaran-mitra.index')->with('success','Data Berhasil ditambah!!');
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
}
