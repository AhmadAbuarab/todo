<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Todo_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\JWTAuth;
use App\User;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller {

    protected $jwt;

    public function __construct(JWTAuth $jwt) {
        $this->jwt = $jwt;
    }

    public function add(request $request) {

        $this->validate($request, [
            'name'          => 'required|max:255',
            'description'   => 'required|max:255',
            'status'        => 'required',
            'category'      => 'required'
        ]);

        $add = DB::table('todo_list')->insert([
            'name'           => $request->post('name'),
            'description'    => $request->post('description'),
            'date'           => time(),
            'status'         => $request->post('status'),
            'category'       => $request->post('category'),
            'usr_id'         => Auth::User()->id
        ]);

        if($add)
            return 'success';
    }


    public function show() {

        return response()->json(['todo_list' =>  Todo_list::all()], 200);
    }

    public function showById($id = null) {

        return response()->json(['todo_list' =>  Todo_list::where('id', $id)->get()], 200);
    }

    public function showByUserId($id = null) {

        return response()->json(['todo_list' =>  Todo_list::where('usr_id', $id)->get()], 200);
    }
}

?>