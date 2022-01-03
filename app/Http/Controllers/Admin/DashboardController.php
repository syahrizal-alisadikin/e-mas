<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use ArielMejiaDev\LarapexCharts\LarapexChart;

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
        $revenueDay     = Transaction::whereDay('tanggal', '=', $day)->whereMonth('created_at', '=', $month)->whereYear('created_at','=', $year)->sum('total');
        $revenueMonth   = Transaction::whereMonth('tanggal', '=', $month)->whereYear('created_at','=', $year)->sum('total');
        
        $revenueYear    = Transaction::whereYear('created_at','=', $year)->sum('total');
        $revenueAll     = Transaction::sum('total');

        $january        = Transaction::whereMonth('tanggal','=',$month_1)->whereYear('tanggal', $year)->sum('total');

        $feb            = Transaction::whereMonth('tanggal','=',$month_2)->whereYear('tanggal', $year)->sum('total');
        

        $march          = Transaction::whereMonth('tanggal','=',$month_3)->whereYear('tanggal', $year)->sum('total');
        $april          = Transaction::whereMonth('tanggal','=',$month_4)->whereYear('tanggal', $year)->sum('total');
        $mei            = Transaction::whereMonth('tanggal','=',$month_5)->whereYear('tanggal', $year)->sum('total');
        $june           = Transaction::whereMonth('tanggal','=',$month_6)->whereYear('tanggal', $year)->sum('total');
        $july           = Transaction::whereMonth('tanggal','=',$month_7)->whereYear('tanggal', $year)->sum('total');
        $august         = Transaction::whereMonth('tanggal','=',$month_8)->whereYear('tanggal', $year)->sum('total');
        $sept           = Transaction::whereMonth('tanggal','=',$month_9)->whereYear('tanggal', $year)->sum('total');
        $oct            = Transaction::whereMonth('tanggal','=',$month_10)->whereYear('tanggal', $year)->sum('total');
        $nov            = Transaction::whereMonth('tanggal','=',$month_11)->whereYear('tanggal', $year)->sum('total');
        $des            = Transaction::whereMonth('tanggal','=',$month_12)->whereYear('tanggal', $year)->sum('total');
        // return $january;
        $transactions = (new LarapexChart)->areaChart()
                        ->setTitle('Laporan Transaction '.date('Y'))
                        ->addData('Transactions', [$january, $feb, $march, $april, $mei, $june,$july, $august, $sept, $oct, $nov, $des])
                        ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'Juli', 'August', 'Sept', 'Octo', 'Nov', 'Des']);
        return view('pages.admin.dashboard',compact('revenueDay','revenueMonth','revenueYear','revenueAll','transactions'));

    }
}
