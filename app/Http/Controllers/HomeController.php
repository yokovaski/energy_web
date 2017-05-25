<?php

namespace App\Http\Controllers;

use App\Models\DayMetric;
use App\Models\TenSecondMetric;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lastMetric = TenSecondMetric::orderBy('created_at', 'desc')->first();

        // Calculate energy use from solar panel.
        $differenceSolarAndRedelivery = ($lastMetric->solar_now - $lastMetric->redeliver_now);
        $lastMetric->usage_now += $differenceSolarAndRedelivery;

        return view('home', ['lastMetric' => $lastMetric]);
    }

    /**
     * Show the application history dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $metric = DayMetric::orderBy('created_at', 'desc')->first();

        dd($metric);

//        foreach ($metrics as $metric) {
//            dd($metric->usage_now);
//        }

        return view('history');
    }
}
