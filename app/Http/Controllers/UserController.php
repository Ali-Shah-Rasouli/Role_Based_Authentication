<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\View;
use Illuminate\Support\Arr;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use DB;
use Hash;

class UserController extends Controller
{
Public function index(Request $request): view{
     $data=User::latest()->paginates(5);
     return view('users.index', compact('data')->with('i', ($request->input('page', 1) -1)*5));
     }



    //
}
