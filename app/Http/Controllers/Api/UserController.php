<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUser(Request $request){
        return response()->json(
            $request->user()
        ,200);
    }
}
