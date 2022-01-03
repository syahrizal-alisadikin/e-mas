<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    public function index()
    {
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

         $january        = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_1)->whereYear('tanggal', $year)->sum('total');

        $feb            = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_2)->whereYear('tanggal', $year)->sum('total');
        

        $march          = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_3)->whereYear('tanggal', $year)->sum('total');
        $april          = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_4)->whereYear('tanggal', $year)->sum('total');
        $mei            = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_5)->whereYear('tanggal', $year)->sum('total');
        $june           = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_6)->whereYear('tanggal', $year)->sum('total');
        $july           = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_7)->whereYear('tanggal', $year)->sum('total');
        $august         = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_8)->whereYear('tanggal', $year)->sum('total');
        $sept           = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_9)->whereYear('tanggal', $year)->sum('total');
        $oct            = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_10)->whereYear('tanggal', $year)->sum('total');
        $nov            = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_11)->whereYear('tanggal', $year)->sum('total');
        $des            = Transaction::whereHas('user',function($q){
            $q->where('rb_id',Auth::user()->id);
         })->whereMonth('tanggal','=',$month_12)->whereYear('tanggal', $year)->sum('total');

         $transactions = (new LarapexChart)->areaChart()
                        ->setTitle('Laporan Transaction')
                        ->addData('Transactions', [$january, $feb, $march, $april, $mei, $june,$july, $august, $sept, $oct, $nov, $des])
                        ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'Juli', 'August', 'Sept', 'Octo', 'Nov', 'Des']);
                        return view('pages.mitra.dashboard',compact('revenueDay','revenueMonth','revenueYear','revenueAll','transactions'));

    }
}
