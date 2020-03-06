<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;
use App\User;

class ExampleController extends Controller {
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt) {
        $this->jwt = $jwt;
    }

    public function postLogin(Request $request) {
        $this->validate($request, ['email' => 'required|email|max:255', 'password' => 'required',]);

        try {

            if (!$token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'));
    }

    public function register(request $request) {

        $this->validate($request, [
            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',
            'email'             => 'unique:users|required|email|max:25',
            'password'          => 'required',
            'gender'            => 'required|in:male,female',
            'birth_day'         => 'required|date',
            'mobile_number'     => 'unique:users|required|max:20'
            ]);

        $add = DB::table('users')->insert([
            'first_name'        => $request->post('first_name'),
            'last_name'         => $request->post('last_name'),
            'email'             => $request->post('email'),
            'password'          => Hash::make($request->post('password')),
            'gender'            => $request->post('gender'),
            'birth_day'         => $request->post('birth_day'),
            'mobile_number'     => $request->post('mobile_number')
        ]);

        if ($add)
            return 'success';
    }


}
