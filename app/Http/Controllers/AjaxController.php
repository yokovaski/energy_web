<?php

namespace App\Http\Controllers;

use App\Models\TenSecondMetric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
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
    public function getTestData()
    {
        $metrics = TenSecondMetric::where('raspberry_pi_id', 1)
            ->orderBy('created_at', 'DESC')
            ->take(50)
            ->get();

        $data = array();

        foreach ($metrics as $metric) {
            $data['timestamps'][] = Carbon::createFromFormat('Y-m-d H:i:s', $metric->created_at)
                ->format('H:i:s');
            $data['usage'][]= $metric->usage_now;
            $data['redelivery'][]= $metric->redelivery_now;
        }

        return response()->json(['data' => $data], Response::HTTP_OK);
    }
}
