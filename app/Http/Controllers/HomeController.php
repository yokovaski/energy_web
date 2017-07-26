<?php

namespace App\Http\Controllers;

use App\Models\DayMetric;
use App\Models\RaspberryPi;
use App\Models\TenSecondMetric;
use App\Models\User;
use Carbon\Carbon;
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

        $currentUser = User::find($id);

        $metric = TenSecondMetric::where('raspberry_pi_id', '=', $currentUser->raspberryPi->id)
            ->orderBy('created_at', 'DESC')
            ->first();

        // Calculate energy use from solar panel.
        $differenceSolarAndRedelivery = ($metric->solar_now - $metric->redelivery_now);
        $metric['intake_now'] = $metric->usage_now;
        $metric->usage_now += $differenceSolarAndRedelivery;

//        $averageToDay = TenSecondMetric::whereDate('created_at', Carbon::now()->day)
//            ->select(DB::raw('avg(usage_now) avg_day_usage_now, avg(solar_now) avg_daysolar_now,
//                avg(redelivery_now) avg_dayredelivery_now'))
//            ->first();
//
//        $metric['avg_day_usage_now'] = $averageToDay->avg_day_usage_now;
//        $metric['avg_daysolar_now'] = $averageToDay->avg_daysolar_now;
//        $metric['avg_dayredelivery_now'] = $averageToDay->avg_dayredelivery_now;

        return view('home', ['lastMetric' => $metric]);
    }
}
