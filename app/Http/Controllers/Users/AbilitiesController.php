<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AbilitiesController extends Controller
{
    public function index()
    {
        $permissions = User::findOrFail(auth('sanctum')->user()->id)->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->toArray();

        return response()->json($permissions);
    }
}
