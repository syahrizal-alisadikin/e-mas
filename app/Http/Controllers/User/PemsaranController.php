<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemasaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
class PemsaranController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $pemasaran = Pemasaran::where('user_id',Auth::user()->id)->with('user')->latest()->get();

            return Datatables::of($pemasaran)
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.user.pemasaran.index');
    }

    public function create()
    {
        return view('pages.user.pemasaran.create');
    }

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
            'user_id' => Auth::user()->id,
            'name' =>  $request->name,
            'tanggal' =>  $request->tanggal,
            'jenis' =>  $request->jenis,
            'keterangan' =>  $request->keterangan,
        ]);

        return redirect()->route('pemasaran.index')->with('success','Data Berhasil ditambah!!');
    }
}
