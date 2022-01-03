<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\StatusUmkm;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
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
		$month_1 = $month ; 
        $month_2 = $month_1 + 1; 
        $month_3 = $month_2 + 1; 
        $month_4 = $month_3 + 1; 
        $month_5 = $month_4 + 1; 
        $month_6 = $month_5 + 1; 
        $month_7 = $month_6 + 1; 
        $month_8 = $month_7+ 1; 
        $month_9 = $month_8+ 1; 
        $month_10 = $month_9 + 1; 
        $month_11 = $month_10 + 1; 
        $month_12 = $month_11 + 1; 
        //statistic revenue
        $revenueDay     = Transaction::where('user_id', Auth::user()->id)->whereDay('tanggal', '=', $day)->whereMonth('created_at', '=', $month)->whereYear('created_at','=', $year)->sum('total');
        $revenueMonth   = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal', '=', $month)->whereYear('created_at','=', $year)->sum('total');
        
        $revenueYear    = Transaction::where('user_id', Auth::user()->id)->whereYear('created_at','=', $year)->sum('total');
        $revenueAll     = Transaction::where('user_id', Auth::user()->id)->sum('total');

        $january        = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_1)->whereYear('tanggal', $year)->sum('total');

        $feb            = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_2)->whereYear('tanggal', $year)->sum('total');
        

        $march          = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_3)->whereYear('tanggal', $year)->sum('total');
        $april          = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_4)->whereYear('tanggal', $year)->sum('total');
        $mei            = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_5)->whereYear('tanggal', $year)->sum('total');
        $june           = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_6)->whereYear('tanggal', $year)->sum('total');
        $july           = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_7)->whereYear('tanggal', $year)->sum('total');
        $august         = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_8)->whereYear('tanggal', $year)->sum('total');
        $sept           = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_9)->whereYear('tanggal', $year)->sum('total');
        $oct            = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_10)->whereYear('tanggal', $year)->sum('total');
        $nov            = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_11)->whereYear('tanggal', $year)->sum('total');
        $des            = Transaction::where('user_id', Auth::user()->id)->whereMonth('tanggal','=',$month_12)->whereYear('tanggal', $year)->sum('total');
        // return $january;
        $transactions = (new LarapexChart)->areaChart()
                        ->setTitle('Laporan Transaction '.date('Y'))
                        ->addData('Transactions', [$january, $feb, $march, $april, $mei, $june,$july, $august, $sept, $oct, $nov, $des])
                        ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'Juli', 'August', 'Sept', 'Octo', 'Nov', 'Des']);
        return view('pages.user.dashboard',compact('revenueDay','revenueMonth','revenueYear','revenueAll','transactions'));
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
