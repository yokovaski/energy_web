<?php

namespace App\Http\Controllers;

use App\Models\DayMetric;
use App\Models\RaspberryPi;
use App\Models\TenSecondMetric;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        $currentUser = User::find($id);


        if (empty($currentUser->raspberryPi)) {
            // No raspberryPi connected to User
            $raspberryPis = RaspberryPi::all();
            $availableRaspberryPi = null;

            foreach ($raspberryPis as $raspberryPi) {
                if ($raspberryPi->ip_address == $request->getClientIp() && empty($raspberryPi->user)) {
                    $availableRaspberryPi = $raspberryPi;
                }
            }

            if ($availableRaspberryPi instanceof RaspberryPi) {
                $currentUser->raspberryPi()->save($availableRaspberryPi);
            } else {
                App::abort(404);
            }
        }


        $lastMetric = TenSecondMetric::orderBy('created_at', 'desc')->first();

        // Calculate energy use from solar panel.
        $differenceSolarAndRedelivery = ($lastMetric->solar_now - $lastMetric->redeliver_now);
        $lastMetric['intake_now'] = $lastMetric->usage_now;
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
