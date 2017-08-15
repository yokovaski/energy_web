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
use Illuminate\Support\Facades\DB;

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

        // Get data of today
        $dataToday = TenSecondMetric::whereDate('created_at', '=', Carbon::today()->toDateString())
            ->select(DB::raw(
                    'avg(usage_now) avg_usage_now_today, 
                    avg(solar_now) avg_solar_now_today, 
                    avg(redelivery_now) avg_redelivery_now_today, 
                    avg(usage_gas_now) avg_usage_gas_now_today, 
                    sum(usage_now) sum_usage_now_today,
                    sum(solar_now) sum_solar_now_today,
                    sum(redelivery_now) sum_redelivery_now_today,
                    sum(usage_gas_now) sum_usage_gas_now_today'))
            ->first();

        // Set avg today
        $metric['avg_usage_now_today'] = round($dataToday->avg_usage_now_today, 1);
        $metric['avg_solar_now_today'] = round($dataToday->avg_solar_now_today, 1);
        $metric['avg_redelivery_now_today'] = round($dataToday->avg_redelivery_now_today, 1);
        $metric['avg_usage_gas_now_today'] = round($dataToday->avg_usage_gas_now_today, 1);

        // Set sum today
        $metric['sum_usage_now_today'] = $dataToday->sum_usage_now_today;
        $metric['sum_solar_now_today'] = $dataToday->sum_solar_now_today;
        $metric['sum_redelivery_now_today'] = $dataToday->sum_redelivery_now_today;
        $metric['sum_usage_gas_now_today'] = $dataToday->sum_usage_gas_now_today;

        // Get data of past week
        $dataPastWeek = TenSecondMetric::whereDate('created_at', '>', Carbon::now()->subDays(7)->toDateString())
            ->select(DB::raw(
                'avg(usage_now) avg_usage_now_week, 
                    avg(solar_now) avg_solar_now_week, 
                    avg(redelivery_now) avg_redelivery_now_week, 
                    avg(usage_gas_now) avg_usage_gas_now_week, 
                    sum(usage_now) sum_usage_now_week,
                    sum(solar_now) sum_solar_now_week,
                    sum(redelivery_now) sum_redelivery_now_week,
                    sum(usage_gas_now) sum_usage_gas_now_week'))
            ->first();

        // Set avg past week
        $metric['avg_usage_now_week'] = round($dataPastWeek->avg_usage_now_week, 1);
        $metric['avg_solar_now_week'] = round($dataPastWeek->avg_solar_now_week, 1);
        $metric['avg_redelivery_now_week'] = round($dataPastWeek->avg_redelivery_now_week, 1);
        $metric['avg_usage_gas_now_week'] = round($dataPastWeek->avg_usage_gas_now_week, 1);

        // Set sum past week
        $metric['sum_usage_now_week'] = $dataPastWeek->sum_usage_now_week;
        $metric['sum_solar_now_week'] = $dataPastWeek->sum_solar_now_week;
        $metric['sum_redelivery_now_week'] = $dataPastWeek->sum_redelivery_now_week;
        $metric['sum_usage_gas_now_week'] = $dataPastWeek->sum_usage_gas_now_week;

        return view('home', ['lastMetric' => $metric]);
    }
}
