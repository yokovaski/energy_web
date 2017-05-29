<?php

namespace App\Http\Controllers;

use App\Models\DayMetric;
use App\Models\RaspberryPi;
use App\Models\TenSecondMetric;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
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
        $users = User::all();
        $raspberryPis = RaspberryPi::all();

        return view(
            'admin', [
                'users' => $users,
                'raspberryPis' => $raspberryPis
            ]
        );
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
