<?php

namespace App\Http\Controllers;

use App\Models\DayMetric;
use App\Models\HourMetric;
use App\Models\MinuteMetric;
use App\Models\TenSecondMetric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTotalsController extends Controller
{
    use ResponseTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function checkIfRequestParamsAreValid(Request $request, $number, $paramName)
    {
        if (empty($request->user()->raspberryPi)) {
            return $this->sendNotFoundResponse();
        }

        if (empty($number) || !intval($number)) {
            return $this->sendCustomErrorResponse(Response::HTTP_BAD_REQUEST,
                $paramName . ' should be of type integer');
        }

        return true;
    }

    /**
     * Get energy data in days
     *
     * @param Request $request
     * @param $days
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getDataInDays(Request $request, $days)
    {
        $response = $this->checkIfRequestParamsAreValid($request, $days, 'days');

        if ($response instanceof Response) {
            return $response;
        }

        $raspberryPi = $request->user()->raspberryPi;
        $metrics = $this->getDataFromDayMetric($raspberryPi->id, $days);

        $data = array();
        $firstRecord = true;
        $previousDay = [];

        foreach ($metrics as $metric) {
            if ($firstRecord) {
                $previousDay = $metric;
                $firstRecord = false;
                continue;
            }

            $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)
                ->format('Y-m-d');
            $data['intake'][] = $this->calculateTotalIntake($previousDay, $metric) / 1000;
            $data['redelivery'][]= $this->calculateTotalRedelivery($previousDay, $metric) / 1000;
            $data['solar'][]= $this->calculateTotalSolar($previousDay, $metric) / 1000;
            $data['usage'][] = $this->calculateTotalUsage($previousDay, $metric) / 1000;

            $previousDay = $metric;
        }

        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    private function getDataFromDayMetric($raspberryPiId, $days)
    {
        $metrics = DayMetric::where(
            [
                ['raspberry_pi_id', '=', $raspberryPiId],
                ['created_at', '>=', \Carbon\Carbon::now(env('TIMEZONE'))->subDays($days + 1)],
            ])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->reverse();

        return $metrics;
    }

    /**
     * Get energy data in months
     *
     * @param Request $request
     * @param $months
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getDataInMonths(Request $request, $months)
    {
        $response = $this->checkIfRequestParamsAreValid($request, $months, 'months');

        if ($response instanceof Response) {
            return $response;
        }

        $raspberryPi = $request->user()->raspberryPi;
        $data = $this->getDataFromMonthMetric($raspberryPi->id, $months);

        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    private function getDataFromMonthMetric($raspberryPiId, $months)
    {
        $metrics = DayMetric::where(
            [
                ['raspberry_pi_id', '=', $raspberryPiId],
                ['created_at', '>=', \Carbon\Carbon::now(env('TIMEZONE'))->subMonth($months + 1)],
            ])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->reverse();

        $firstMonth = true;
        $firstMonthNumber = 0;
        $previousMonth = [];
        $lastMonthNumber = 0;

        $data = [];
        $lastMetric = [];

        foreach ($metrics as $metric) {
            $currentMonth = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)->format('m');

            if ($firstMonth) {
                if (empty($previousMonth)) {
                    $previousMonth = $metric;
                    $firstMonthNumber = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)->format('m');
                    continue;
                }

                if ($currentMonth == $firstMonthNumber) {
                    $previousMonth = $metric;
                    continue;
                }

                $lastMonthNumber = $firstMonthNumber;
                $firstMonth = false;
            }

            if ($currentMonth != $lastMonthNumber) {
                $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $previousMonth->created_at)
                    ->format('Y-M');
                $data['intake'][] = $this->calculateTotalIntake($previousMonth, $metric) / 1000;
                $data['redelivery'][]= $this->calculateTotalRedelivery($previousMonth, $metric) / 1000;
                $data['solar'][]= $this->calculateTotalSolar($previousMonth, $metric) / 1000;
                $data['usage'][] = $this->calculateTotalUsage($previousMonth, $metric) / 1000;

                $lastMonthNumber = $currentMonth;
                $previousMonth = $metric;
            }

            $lastMetric = $metric;
        }

        $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $lastMetric->created_at)
            ->format('Y-M');
        $data['intake'][] = $this->calculateTotalIntake($previousMonth, $lastMetric) / 1000;
        $data['redelivery'][]= $this->calculateTotalRedelivery($previousMonth, $lastMetric) / 1000;
        $data['solar'][]= $this->calculateTotalSolar($previousMonth, $metric) / 1000;
        $data['usage'][] = $this->calculateTotalUsage($previousMonth, $metric) / 1000;

        return $data;
    }

    private function calculateTotalIntake($previous, $current)
    {
        $totalPrevious = ($previous->usage_total_high + $previous->usage_total_low);
        $totalCurrent = ($current->usage_total_high + $current->usage_total_low);

        return ($totalCurrent - $totalPrevious);
    }

    private function calculateTotalRedelivery($previous, $current)
    {
        $totalPrevious = ($previous->redelivery_total_high + $previous->redelivery_total_low);
        $totalCurrent = ($current->redelivery_total_high + $current->redelivery_total_low);

        return ($totalCurrent - $totalPrevious);
    }

    private function calculateTotalSolar($previous, $today)
    {
        $totalSolar = $today->solar_total - $previous->solar_total;

        return $totalSolar;
    }

    private function calculateTotalUsage($previous, $current)
    {
        $redelivery = $this->calculateTotalRedelivery($previous, $current);
        $intake = $this->calculateTotalIntake($previous, $current);
        $solar = $this->calculateTotalSolar($previous, $current);

        $usage = ($solar - $redelivery) + $intake;

        return $usage;
    }
}