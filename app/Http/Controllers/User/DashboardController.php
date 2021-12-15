<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.user.dashboard');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages.user.profile',compact('user'));
    }

    public function updateProfile(Request $request,$id)
    {
        $user = User::findOrFail($id);
       if ($request->password) {
            $this->validate(
                $request,
                [
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required',
                    'name'    => 'required',
                    'email'   => [
                        'required',
                        Rule::unique('users')->ignore($user->id, 'id'),


                    ],
                    'phone'   => [
                        'required',
                        Rule::unique('users')->ignore($user->id, 'id'),


                    ],

                ],
                [
                    'password.confirmed' => 'Password Tidak sama!',
                ]
            );
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->phone         = $request->phone;
            $user->password      = Hash::make($request['password']);
            $user->pemilik = $request->pemilik;
            $user->alamat        = $request->alamat;
        } else {
            $this->validate(
                $request,
                [

                    'name'    => 'required',
                    'email'   => [
                        'required',
                        Rule::unique('users')->ignore($user->id, 'id'),


                    ],
                    'phone'   => [
                        'required',
                        Rule::unique('users')->ignore($user->id, 'id'),


                    ],

                ]
            );
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->phone         = $request->phone;
            $user->pemilik = $request->pemilik;
            $user->alamat        = $request->alamat;
        }
        $user->update();
        return redirect()->route('user.profile')->with('success', 'Berhasil Update Data !!');
    }

    public function status()
    {
        $user = Auth::user();
        return view('pages.user.status',compact('user'));
    }

    public function sertifikasi()
    {
        $sertifikat = Certification::where('user_id',Auth::user()->id)->first();
        return view('pages.user.sertifikasi',compact('sertifikat'));

    }
}
