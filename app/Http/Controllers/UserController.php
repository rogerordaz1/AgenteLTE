<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('can:dashboard.users.index')->only('index');
        $this->middleware('can:dashboard.users.create')->only('create');
        $this->middleware('can:dashboard.users.store')->only('store');
        $this->middleware('can:dashboard.users.show')->only('show');
        $this->middleware('can:dashboard.users.edit')->only('edit');
        $this->middleware('can:dashboard.users.update')->only('update');
        $this->middleware('can:dashboard.users.delete')->only('delete');
    }
    


    public function index()
    {
        $users = User::all();
        $usersCount = User::all()->count();

        return view(
            'users.index',
            [
                'users' => $users,
                'usersCount' =>  $usersCount
            ]
        );
    }

    public function create()
    {
        $roles = Role::all();
        $usersCount = User::all()->count();
        return view(
            'users.create',
            [
                'roles' => $roles,
                'usersCount' =>  $usersCount
            ]
        );
    }
  
    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt( $request->get('pass'));
       

        $user->save();

        return redirect('/dashboard/users');
    }
  
    public function show($id)
    {
        $user = User::find($id);
        $usersCount = User::all()->count();
        return view(
            'users.show',

            [
                'user' => $user,
                
                'usersCount' =>  $usersCount
            ]
        );
    }
  
    public function edit($id)
    {
        $user = User::find($id);
         $roles = Role::all();
        $usersCount = User::all()->count();
        return view(
            'users.edit',

            [
                'user' => $user,
                'roles' => $roles,
                'usersCount' =>  $usersCount
            ]
        );
    }
   
    public function update(Request $request, User $user)
    {
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt( $request->get('pass'));

        
        $user->roles()->sync($request->get('role_id'));
        
        $user->save();

        return redirect('/dashboard/users');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/dashboard/users');
    }
}
