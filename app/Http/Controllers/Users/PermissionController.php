<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('permission_index'), 403);
        $permissions = Permission::all();
        return  response()->json($permissions);
    }

    public function store(Request $request)
    {
        Permission::create($request->only('name'));
        return  response()->noContent();
    }

    public function show(Permission $permission)
    {
        //abort_if(Gate::denies('permission_show'), 403);
        return  response()->json($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->only('name'));
        return  response()->json($permission);
    }

    public function destroy(Permission $permission)
    {
        //abort_if(Gate::denies('permission_delete'), 403);
        $permission->delete();
        return  response()->json($permission);
    }
}
