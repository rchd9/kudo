<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function users(Request $request)
    {
        $users = User::all()->except(\Auth::id());

        return response()->json([
          'success' => true,
          'data' => $users
        ], 201);
        
    }
}
