<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function fetchUserList()
    {
        return User::all();
    }

    public function fetchUser(User $user)
    {
        return $user;
    }

    public function createUser(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "password" => "required|string",
            "passwordRepeat" => "required|same:password",
            "role" => "required|exists:roles,id"
        ]);

        $user = User::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "password" => Hash::make($request["password"]),
        ]);

        $user->assignRole($request->role);

        return $user;
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "password" => "nullable|string",
            "passwordRepeat" => "nullable|same:password",
            "role" => "required|exists:roles,id"
        ]);

        $user->update([
            "name" => $request["name"],
            "email" => $request["email"],
        ]);

        $user->syncRoles([$request["role"]]);

        if($request["password"]) {
            $user->update([
                "password" => Hash::make($request["password"]),
            ]);
        }

        return $user;
    }

    public function deleteUser(User $user)
    {
        $user->syncRoles([]);
        $user->delete();

        return "Success";
    }

    public function fetchUserPermissions()
    {
        return auth()->user()->getAllPermissions();
    }
}
