<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
  


    public function __construct()
    {
        $this->middleware('can:dashboard.roles.index')->only('index');
        $this->middleware('can:dashboard.roles.create')->only('create');
        $this->middleware('can:dashboard.roles.store')->only('store');
        $this->middleware('can:dashboard.roles.edit')->only('edit');
        $this->middleware('can:dashboard.roles.update')->only('update');
        $this->middleware('can:dashboard.roles.delete')->only('delete');
    }
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', [
            'roles' => $roles
        ]);
    }

   
    public function create()
    {
        $permissions = Permission::all();

        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }

    
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required'
        ]);

        $role = Role::create($request->all());

        $role->permissions()->sync($request->permissions);

        return redirect()->route('dashboard.roles.index');
    }


    
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('roles.edit',
         [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([

            'name' => 'required'
        ]);

        $role->update($request->all());

        $role->permissions()->sync($request->permissions);

        return redirect()->route('dashboard.roles.edit' , $role)->with('info' , 'El Rol se modifico con exito');
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('dashboard.roles.index')->with('info' , 'El Rol se elimino con exito');
    }
}
