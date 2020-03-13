<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function fetchRoleList()
    {
        return Role::all();
    }

    public function fetchRole(Role $role)
    {
        return $role;
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            "name" => ['required','string', Rule::unique("roles")->ignore($role)],
            "permissions.*" => "exists:permissions,id",
        ]);

        $role->update($request->only(["name"]));

        $role->syncPermissions($request["permissions"]);

        return Role::where("id", $role->id)->first();
    }

    public function createRole(Request $request)
    {
        $request->validate([
            "name" => ['required','string', Rule::unique("roles")],
            "permissions.*" => "exists:permissions,id",
        ]);

        $role = Role::create($request->only(["name"]));

        $role->syncPermissions($request["permissions"]);

        return Role::where("id", $role->id)->first();
    }

    public function deleteRole(Role $role)
    {
        $role->syncPermissions([]);

        $role->delete();

        return "Success";
    }
}
