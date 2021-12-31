<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $year   = date('Y');
        $month  = date('m');
        $day    = date('d');
        //statistic revenue
        $revenueDay = Transaction::whereHas('user',function($q){
                $q->where('rb_id',Auth::user()->id);
            })->whereDay('created_at', '=', $day)->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->sum('total');
        $revenueMonth = Transaction::whereHas('user',function($q){
                $q->where('rb_id',Auth::user()->id);
            })->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->sum('total');
        $revenueYear  = Transaction::whereHas('user',function($q){
                $q->where('rb_id',Auth::user()->id);
            })->whereYear('created_at', $year)->sum('total');
        $revenueAll   = Transaction::whereHas('user',function($q){
                $q->where('rb_id',Auth::user()->id);
            })->sum('total');
        return view('pages.mitra.dashboard',compact('revenueDay','revenueMonth','revenueYear','revenueAll'));
    }
}
