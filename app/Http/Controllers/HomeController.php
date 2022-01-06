<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function cart()
    {
        $global = (new LarapexChart)->pieChart()
        ->setTitle('Top 3 scorers of the team.')
        ->setSubtitle('Season 2021.')
        ->addData([20, 24, 30])
        ->setLabels(['Player 7', 'Player 10', 'Player 9']);
        
        $score = (new LarapexChart)->polarAreaChart()
        ->setTitle('Top 3 scorers of the team.')
        ->setSubtitle('Season 2021.')
        ->addData([20, 24, 30])
        ->setLabels(['Player 7', 'Player 10', 'Player 9']);
        return view('cart',compact('global','score'));

    }
}
