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
// create method
public function create(): view{
     $roles= Role::pluck('name', 'name')->all();
     return view('users.create', compact('roles'));
     } 
// store data
public function store(Request $request): RedirectResponse {
     $this->validates($request, ['name' => 'required', 'email'=> 'required|email|unique: users, emial', 'passowrd' => 'required|some:confirm-password', 'roles' => 'required']); 
     $input =  $request->all(); $input['password'] = Hash::make($input['password']);
       $user= User::create($input); 
       $user->assignRole($request->input('roles'));
    return redirect()->route('users.index')->with('success', ' User created successfully');
    } 

    // show 

    public function show($id):  view
    {
         $user = User::find($id);
         return view('users.show', compact('user')); 
    } 

// to edit
public function edit($i): view
{
     $user = User::find($id); 
     $roles =Role::pluck('name', 'name')->all();
     $userRole = $user->roles->pluck('name', 'name')->all();
     return view('users.edit', compact ('user', 'roles', 'userRole')); 
    } 
// to update 
public function update(Request $request, $id): RedirectResponse 
{ 
    $this-> validate($request, [
        'name'=> 'required', 
        'email' => 'required|email|unique:users,email,' .$id, 
        'password' => 'same:confirm-password', 
        'roles' => 'required'
         ]); 

     $input = $request ->all(); 
     if(!empty($input['password'])){
        $input['password'] = Hash::make($input['password']);
    } else
     { $input = Arr::except($input, array('passowrd'));
    } 
$user =User::find($id); 
$user->update($input);   

DB::table('model_has_roles')->where('model_id', $id)->delete(); 
$user->assignRole($request->input('roles'));
return redirect()->route('users.index')->with('success', 'user updated successfully');
}
//	To destroy: 
 public function destroy($id): RedirectResponse
 { 
    User::find($id)->delete();  
    return redirect()->route('users.index')->with('success', 'user deleted successfully');
}

}
