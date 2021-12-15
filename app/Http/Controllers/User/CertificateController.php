<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CertificateController extends Controller
{
    public function store(Request $request)
    {
         $this->validate(
                $request,
                [
                    'name'    => 'required',
                    'nama_pemberi' => 'required',
                    'tanggal'    => 'required',
                    
                ]
            );

        $file = $request->file('file');
        if($file){
             $file->storeAs('public/sertifikasi', $file->hashName());
            // simpan file
            Certification::updateOrCreate([
                'user_id'   => Auth::user()->id,
            ],[
                'name' => $request->name,
                'nama_pemberi' => $request->nama_pemberi,
                'tanggal' => $request->tanggal,
                'file' => $file->hashName(),
            ]);

        }else{
            Certification::updateOrCreate([
                'user_id'   => Auth::user()->id,
            ],[
                'name' => $request->name,
                'nama_pemberi' => $request->nama_pemberi,
                'tanggal' => $request->tanggal,
            ]);
        }
       
        return redirect()->route('user.sertifikasi')->with('success','Data berhasil disimpan!!');
        // simpan ke databse
    }
}
