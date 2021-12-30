<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\StatusUmkm;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        
 
         //year and month
        $year   = date('Y');
        $month  = date('m');
        $day    = date('d');
		
        //statistic revenue
        $revenueDay = Transaction::where('user_id', Auth::user()->id)->whereDay('created_at', '=', $day)->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->sum('total');
        $revenueMonth = Transaction::where('user_id', Auth::user()->id)->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->sum('total');
        $revenueYear  = Transaction::where('user_id', Auth::user()->id)->whereYear('created_at', $year)->sum('total');
        $revenueAll   = Transaction::where('user_id', Auth::user()->id)->sum('total');
 
        return view('pages.user.dashboard',compact('revenueDay','revenueMonth','revenueYear','revenueAll'));
    }

    public function profile()
    {
        $rb = User::where('roles','RB')->get();
        $user = Auth::user();
        
        return view('pages.user.profile',compact('user','rb'));
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
            $user->rb_id = $request->rb_id;

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
            $user->rb_id = $request->rb_id;
            $user->alamat        = $request->alamat;
        }
        $user->update();
        return redirect()->route('user.profile')->with('success', 'Berhasil Update Data !!');
    }

    public function status()
    {
        $status = StatusUmkm::all();
        $user = Auth::user();
        return view('pages.user.status',compact('status','user'));
    }

    public function updateStatus($id)
    {
        $user = Auth::user();
        $user->update([
            'status_id' => request()->status_id
        ]);

        return redirect()->route('user.status')->with('success','Berhasil disimpan!!');
    }

    public function sertifikasi()
    {
        $sertifikat = Certification::where('user_id',Auth::user()->id)->first();
        return view('pages.user.sertifikasi',compact('sertifikat'));

    }
}
