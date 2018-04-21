<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    private $client;
    public function __construct()
    {
        $this->client = Client::find(1);
    }

    public function postLogin(Request $request)
    {
        /* Login Function
         *
         * parameter needed: email, password & mac_address
         * parameter mac_address send automatically by system
         *
         * */

        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);

        /*$attempt variable contains parameter datas that user send
         * then the system check if parameter datas meet user credential
         *
         * */
        $attempt = Auth::attempt([
            'email'=>$request['email'],
            'password'=>$request['password'],
            'mac_address'=>$request['mac_address']
        ]);

        /*If attempt meet usr credential,
         * Do laravel login logic
         * Documentation: https://laravel.com/docs/5.6/passport;
         *
         * Data send by this route is:
         * {
         *      "token_type": "Bearer",
         *      "expires_in": 31536000,
         *      "access_token": "random access token format",
         *      "refresh_token": "random refresh token format"
         * }
         *
         * */

        if($attempt){
            $params = [
                'grant_type' => 'password',
                'client_id' => $this->client->id,
                'client_secret' => $this->client->secret,
                'username' => $request['email'],
                'password' => $request['password'],
                'scope' => '',
            ];

            $request->request->add($params);
            $proxy = Request::create('oauth/token','POST');

            return Route::dispatch($proxy);
        }
        return response()->json([
            "message"=>"The user credentials were incorrect."
        ],401);
    }

    public function postRefresh(Request $request)
    {
        /* The purpose of this function is:
         * to refresh user generated access token
         */

        $this->validate($request,[
            'refresh_token'=>'required'
        ]);

        $params = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request['email'],
            'password' => $request['password'],
        ];

        $request->request->add($params);
        $proxy = Request::create('oauth/token','POST');

        return Route::dispatch($proxy);
    }

    public function postLogout()
    {
        $access_token = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id',$access_token->id)
            ->update(['revoked' =>true]);

        $access_token->revoke();

        return response()->json([
            'message'=>'Logout Successfully.'
        ],200);
    }
}
