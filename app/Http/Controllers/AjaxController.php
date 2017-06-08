<?php

namespace App\Http\Controllers;

use App\Models\TenSecondMetric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
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

    /**
     * Get energy data of last $hours
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getDataOfLastHours(Request $request, $hours)
    {
        $raspberryPi = $request->user()->raspberryPi;

        if (empty($raspberryPi)) {
            return $this->sendNotFoundResponse();
        }

        if (empty($hours) || !intval($hours)) {
            return $this->sendCustomErrorResponse(Response::HTTP_BAD_REQUEST,
                'hours should be of type integer');
        }

        $metrics = TenSecondMetric::where(
            [
                ['raspberry_pi_id', '=', $raspberryPi->id],
                ['created_at', '>=', \Carbon\Carbon::now(env('TIMEZONE'))->subHours(intval($hours))],
            ])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->reverse();

        $data = array();

        foreach ($metrics as $metric) {
            $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)
                ->format('H:i:s');
            $data['usage'][]= $metric->usage_now;
            $data['redelivery'][]= $metric->redelivery_now;
        }

        return response()->json(['data' => $data], Response::HTTP_OK);
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
        $raspberryPi = $request->user()->raspberryPi;

        if (empty($raspberryPi)) {
            return $this->sendNotFoundResponse();
        }

        if (empty($minutes) || !intval($minutes)) {
            return $this->sendCustomErrorResponse(Response::HTTP_BAD_REQUEST,
                'hours should be of type integer');
        }

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
            $data['usage'][]= $metric->usage_now;
            $data['redelivery'][]= $metric->redelivery_now;
        }

        return response()->json(['data' => $data], Response::HTTP_OK);
    }

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
        $data['usage'][]= $metric->usage_now;
        $data['redelivery'][]= $metric->redelivery_now;

        return response()->json(['data' => $data], Response::HTTP_OK);
    }
}
