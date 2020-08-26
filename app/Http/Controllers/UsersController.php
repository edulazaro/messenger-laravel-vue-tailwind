<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->orderBy('name', 'ASC')->get();
        return response()->json($users);
    }
}
