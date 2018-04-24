<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DateController extends Controller
{
    public function getMondays(Request $request){
        $this->validate($request,[
            'month'=>'required|integer|min:1|max:12',
            'year'=>'required|integer|min:1990'
        ]);
        $first_month = $request['month'];
        $next_month = $request['month']+1;
        $carbon = Carbon::createFromFormat('Y-m-d',$request['year'].'-'.$first_month.'-'.'1');
        $carbon_next = Carbon::createFromFormat('Y-m-d', $request['year'].'-'.$next_month.'-'.'1');
        $date_period = new \DatePeriod(
            $carbon->parse('first monday '.$carbon),
            CarbonInterval::week(),
            $carbon->parse('first monday '.$carbon_next));
        $mondays = array();
        foreach($date_period as $date){
            array_push($mondays, $date->toDateString());
        }

        return response()->json($mondays,200);
    }
}
