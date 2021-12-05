<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{

    public function index()
    {
        //abort_if(Gate::denies('user_index'), 403);
        $users = User::all()->load('roles');
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($request->only('name', 'email')
            + [
                'password' => bcrypt($request->input('password')),
            ]);

        $roles = $request->input('roles', []);
        $user->syncRoles($roles);
        return response()->json($user);
    }

    public function show(User $user)
    {
        //abort_if(Gate::denies('user_show'), 403);
        // $user = User::findOrFail($id);
        $user->load('roles');
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        // $user=User::findOrFail($id);
        $data = $request->only('name', 'email');
        $password = $request->input('password');
        if ($password)
            $data['password'] = bcrypt($password);

        $user->update($data);

        if(!empty($request->input('roles',[])))
        $user->syncRoles($request->input('roles', []));
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        //abort_if(Gate::denies('user_destroy'), 403);
        if (auth('sanctum')->user()->id == $user->id) {
            return response()->json($user, 400);
        }

        $user->delete();
        return response()->noContent(200);
    }
}
