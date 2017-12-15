<?php

namespace App\Http\Controllers;

use App\Models\DayMetric;
use App\Models\HourMetric;
use App\Models\MinuteMetric;
use App\Models\TenSecondMetric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAveragesController extends Controller
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
     * Get energy data of last days
     *
     * @param Request $request
     * @param $days
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getDataOfLastDays(Request $request, $days)
    {
        $response = $this->checkIfRequestParamsAreValid($request, $days, 'days');

        if ($response instanceof Response) {
            return $response;
        }

        $raspberryPi = $request->user()->raspberryPi;

        if ($days > 1) {
            $metrics = $this->getDataFromDayMetric($raspberryPi->id, $days);
        } else {
            $metrics = $this->getDataFromHourMetric($raspberryPi->id, 24);
        }

        $data = array();

        foreach ($metrics as $metric) {
            $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)
                ->format('Y-m-d');

            $differenceSolarAndRedelivery = ($metric->solar_now - $metric->redelivery_now);
            $data['intake'][] = $metric->usage_now / 1000;
            $data['usage'][] = ($metric->usage_now + $differenceSolarAndRedelivery) / 1000;
            $data['redelivery'][]= $metric->redelivery_now / 1000;
            $data['solar'][]= $metric->solar_now / 1000;
        }

        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    private function getDataFromHourMetric($raspberryPiId, $hours)
    {
        $metrics = HourMetric::where(
            [
                ['raspberry_pi_id', '=', $raspberryPiId],
                ['created_at', '>=', \Carbon\Carbon::now(env('TIMEZONE'))->subHours(intval($hours))],
            ])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->reverse();

        return $metrics;
    }

    private function getDataFromDayMetric($raspberryPiId, $days)
    {
        $metrics = DayMetric::where(
            [
                ['raspberry_pi_id', '=', $raspberryPiId],
                ['created_at', '>=', \Carbon\Carbon::now(env('TIMEZONE'))->subDays($days)],
            ])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->reverse();

        return $metrics;
    }

    /**
     * Get energy data of last hours
     *
     * @param Request $request
     * @param $hours
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getDataOfLastHours(Request $request, $hours)
    {
        $response = $this->checkIfRequestParamsAreValid($request, $hours, 'hours');

        if ($response instanceof Response) {
            return $response;
        }

        $raspberryPi = $request->user()->raspberryPi;

        if ($hours >= 24) {
            $metrics = $this->getDataFromHourMetric($raspberryPi->id, $hours);
        } else {
            $metrics = $this->getDataFromMinuteMetric($raspberryPi->id, $hours);
        }

        $data = array();

        if ($hours > 12) {
            $format = 'd-m H:m';
        } else {
            $format = 'H:i:s';
        }

        foreach ($metrics as $metric) {
            $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)
                ->format($format);

            $differenceSolarAndRedelivery = ($metric->solar_now - $metric->redelivery_now);
            $data['intake'][] = $metric->usage_now / 1000;
            $data['usage'][] = ($metric->usage_now + $differenceSolarAndRedelivery) / 1000;
            $data['redelivery'][]= $metric->redelivery_now / 1000;
            $data['solar'][]= $metric->solar_now / 1000;
        }

        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    private function getDataFromMinuteMetric($raspberryPiId, $hours)
    {
        $metrics = MinuteMetric::where(
            [
                ['raspberry_pi_id', '=', $raspberryPiId],
                ['created_at', '>=', \Carbon\Carbon::now(env('TIMEZONE'))->subHours(intval($hours))],
            ])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->reverse();

        return $metrics;
    }

    /**
     * Get energy data of last $minutes
     *
     * @param Request $request
     * @param $minutes
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getDataOfLastMinutes(Request $request, $minutes)
    {
        $response = $this->checkIfRequestParamsAreValid($request, $minutes, 'minutes');

        if ($response instanceof Response) {
            return $response;
        }

        $raspberryPi = $request->user()->raspberryPi;

        $metrics = TenSecondMetric::where(
            [
                ['raspberry_pi_id', '=', $raspberryPi->id],
                ['created_at', '>=', \Carbon\Carbon::now(env('TIMEZONE'))->subMinutes(intval($minutes))],
            ])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->reverse();

        $data = array();

        foreach ($metrics as $metric) {
            $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)
                ->format('H:i:s');

            $differenceSolarAndRedelivery = ($metric->solar_now - $metric->redelivery_now);
            $data['intake'][] = $metric->usage_now / 1000;
            $data['usage'][] = ($metric->usage_now + $differenceSolarAndRedelivery) / 1000;
            $data['redelivery'][]= $metric->redelivery_now / 1000;
            $data['solar'][]= $metric->solar_now / 1000;
        }

        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    /**
     * Get data of last update
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getDataOfLastUpdate(Request $request)
    {
        $raspberryPi = $request->user()->raspberryPi;

        if (empty($raspberryPi)) {
            return $this->sendNotFoundResponse();
        }

        $metric = TenSecondMetric::where('raspberry_pi_id', '=', $raspberryPi->id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $data = array();

        $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)
            ->format('H:i:s');

        $differenceSolarAndRedelivery = ($metric->solar_now - $metric->redelivery_now);
        $data['intake'][] = $metric->usage_now / 1000;
        $data['usage'][] = ($metric->usage_now + $differenceSolarAndRedelivery) / 1000;
        $data['redelivery'][]= $metric->redelivery_now / 1000;
        $data['solar'][]= $metric->solar_now / 1000;

        return response()->json(['data' => $data], Response::HTTP_OK);
    }
}