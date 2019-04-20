<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    //

    public function index(Request $request)
    {
        return response()->json([
            'status_code' => 200,
            'msg' => $request->input('name')
        ]);
    }

}
