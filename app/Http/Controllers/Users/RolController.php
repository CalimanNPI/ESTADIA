<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{

    public function index()
    {
        // abort_if(Gate::denies('role_index'), 403);
        $roles = Role::all()->load('permissions');
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $role = Role::create($request->only('name'));
        $role->syncPermissions($request->input('permissions', []));
        return response()->noContent();
    }

    public function show(Role $role)
    {
        //abort_if(Gate::denies('role_show'), 403);
       $role->load('permissions');
       return response()->json($role);
    }

    // public function edit(Role $role)
    // {
    //     abort_if(Gate::denies('role_edit'), 403);
    //     $permissions = Permission::all()->pluck('name', 'id');
    //     $role->load('permissions');
    //     return response()->json($role);
    //     return view('roles.edit', compact('role', 'permissions'));
    // }

    public function update(Request $request, Role $role)
    {
        $role->update($request->only('name'));
        $role->syncPermissions($request->input('permissions', []));
        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        //abort_if(Gate::denies('role_delete'), 403);
        $role->delete();
        return response()->noContent();
    }
}
