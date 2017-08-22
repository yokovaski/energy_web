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
        $raspberryPiId = $currentUser->raspberryPi->id;

        $metric = TenSecondMetric::where('raspberry_pi_id', '=', $currentUser->raspberryPi->id)
            ->orderBy('created_at', 'DESC')
            ->first();

        // Calculate energy use from solar panel.
        $differenceSolarAndRedelivery = ($metric->solar_now - $metric->redelivery_now);
        $metric['intake_now'] = $metric->usage_now;
        $metric->usage_now += $differenceSolarAndRedelivery;

        $metricArray = [];
        $metricArray['usage_now'] = $metric->usage_now;
        $metricArray['redelivery_now'] = $metric->redelivery_now;
        $metricArray['solar_now'] = $metric->solar_now;
        $metricArray['intake_now'] = $metric->intake_now;
        $metricArray['usage_gas_now'] = $metric->usage_gas_now;
        $metricArray['usage_total_high'] = $metric->usage_total_high;
        $metricArray['redelivery_total_high'] = $metric->redelivery_total_high;
        $metricArray['usage_total_low'] = $metric->usage_total_low;
        $metricArray['redelivery_total_low'] = $metric->redelivery_total_low;
        $metricArray['usage_gas_total'] = $metric->usage_gas_total;
        $metricArray['solar_total'] = $metric->solar_total;
        $metricArray['created_at'] = $metric->created_at;
        $metricArray['updated_at'] = $metric->updated_at;

        $metricArray = array_merge($metricArray, $this->getAverageToday($raspberryPiId));
        $metricArray = array_merge($metricArray, $this->getTotalToday($metric, $raspberryPiId));
        $metricArray = array_merge($metricArray, $this->getAveragePastDays(7, $raspberryPiId));
        $metricArray = array_merge($metricArray, $this->getTotalPastDays(7, $metric, $raspberryPiId));

        return view('home', ['metrics' => $metricArray]);
    }

    public function getAverageToday($raspberryPiId)
    {
        $metric = [];

        // Get data of today
        $dataToday = TenSecondMetric::whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('raspberry_pi_id', '=', $raspberryPiId)
            ->select(DB::raw(
                'avg(usage_now) avg_usage_now_today, 
                    avg(solar_now) avg_solar_now_today, 
                    avg(redelivery_now) avg_redelivery_now_today, 
                    avg(usage_gas_now) avg_usage_gas_now_today'))
            ->first();

        // Set avg today
        $metric['avg_usage_now_today'] = round($dataToday->avg_usage_now_today, 1);
        $metric['avg_solar_now_today'] = round($dataToday->avg_solar_now_today, 1);
        $metric['avg_redelivery_now_today'] = round($dataToday->avg_redelivery_now_today, 1);
        $metric['avg_usage_gas_now_today'] = round($dataToday->avg_usage_gas_now_today, 1);

        return $metric;
    }

    public function getTotalToday(TenSecondMetric $lastRecordToday, $raspberryPiId)
    {
        $metric = [];

        $firstRecordToday = TenSecondMetric::where('raspberry_pi_id', '=', $raspberryPiId)
            ->orderBy('created_at', 'ASC')
            ->first();

        // Set avg today

        $lastRecordTotalUsage = $lastRecordToday->usage_total_high + $lastRecordToday->usage_total_low;
        $firstRecordTotalUsage = $firstRecordToday->usage_total_high + $firstRecordToday->usage_total_low;
        $lastRecordTotalRedelivery = $lastRecordToday->redelivery_total_high + $lastRecordToday->redelivery_total_low;
        $firstRecordTotalRedelivery = $firstRecordToday->redelivery_total_high + $firstRecordToday->redelivery_total_low;

        $totalUsage = $lastRecordTotalUsage - $firstRecordTotalUsage;
        $totalRedelivery = $lastRecordTotalRedelivery - $firstRecordTotalRedelivery;
        $totalSolar = $lastRecordToday->solar_total - $firstRecordToday->solar_total;
        $totalGas = $lastRecordToday->usage_gas_total - $firstRecordToday->usage_gas_total;

        $metric['total_usage_now_today'] = round($totalUsage, 1);
        $metric['total_solar_now_today'] = round($totalSolar, 1);
        $metric['total_redelivery_now_today'] = round($totalRedelivery, 1);
        $metric['total_usage_gas_now_today'] = round($totalGas, 1);

        return $metric;
    }

    public function getAveragePastDays($days, $raspberryPiId)
    {
        // Get data of past week
        $dataPastWeek = TenSecondMetric::whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->where('raspberry_pi_id', '=', $raspberryPiId)
            ->select(DB::raw(
                'avg(usage_now) avg_usage_now, 
                avg(solar_now) avg_solar_now,
                avg(redelivery_now) avg_redelivery_now,
                avg(usage_gas_now) avg_usage_gas_now'))
            ->first();

        // Set avg past week
        $metric['avg_usage_now_days'] = round($dataPastWeek->avg_usage_now, 1);
        $metric['avg_solar_now_days'] = round($dataPastWeek->avg_solar_now, 1);
        $metric['avg_redelivery_now_days'] = round($dataPastWeek->avg_redelivery_now, 1);
        $metric['avg_usage_gas_now_days'] = round($dataPastWeek->avg_usage_gas_now, 1);

        return $metric;
    }

    public function getTotalPastDays($days, TenSecondMetric $lastRecord, $raspberryPiId)
    {
        $metric = [];

        // Get data of past week
        $firstRecord = TenSecondMetric::whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->orderBy('created_at', 'ASC')
            ->where('raspberry_pi_id', '=', $raspberryPiId)
            ->first();

        $lastRecordTotalUsage = $lastRecord->usage_total_high + $lastRecord->usage_total_low;
        $firstRecordTotalUsage = $firstRecord->usage_total_high + $firstRecord->usage_total_low;
        $lastRecordTotalRedelivery = $lastRecord->redelivery_total_high + $lastRecord->redelivery_total_low;
        $firstRecordTotalRedelivery = $firstRecord->redelivery_total_high + $firstRecord->redelivery_total_low;

        $totalUsage = $lastRecordTotalUsage - $firstRecordTotalUsage;
        $totalRedelivery = $lastRecordTotalRedelivery - $firstRecordTotalRedelivery;
        $totalSolar = $lastRecord->solar_total - $firstRecord->solar_total;
        $totalGas = $lastRecord->usage_gas_total - $firstRecord->usage_gas_total;

        $metric['total_usage_now_days'] = round($totalUsage, 1);
        $metric['total_solar_now_days'] = round($totalSolar, 1);
        $metric['total_redelivery_now_days'] = round($totalRedelivery, 1);
        $metric['total_usage_gas_now_days'] = round($totalGas, 1);

        return $metric;
    }
}
