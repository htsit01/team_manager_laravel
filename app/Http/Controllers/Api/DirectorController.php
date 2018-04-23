<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\VisitPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    public function getManagerVerification(Request $request){
        $this->validate($request, [
            'month'=>'required|integer|min:1|max:12',
            'year'=>'required'
        ]);

        $month = $request['month'];
        $year = $request['year'];

        $verifications = DB::table('verifications')
            ->whereMonth('date_time',$month)
            ->whereYear('date_time', $year)
            ->orderBy('user_id')
            ->get();


        foreach ($verifications as $item){
            $visit_plan = VisitPlan::find($item->visit_plan_id);
            $item->visit_plan = $visit_plan;
            $item->manager = User::find($item->user_id)->name;
            $item->salesman = User::find($visit_plan->user_id)->name;
        }

        return response()->json($verifications, 200);
    }
}
