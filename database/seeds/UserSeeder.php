<?php

use App\Permission as AppPermission;
use App\Role as AppRole;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::create(["name" => AppRole::USER]);
        $advancedUserRole = Role::create(["name" => AppRole::ADVANCED_USER]);
        $rpaRole = Role::create(["name" => AppRole::RPA]);
        $itRole = Role::create(["name" => AppRole::IT]);
        $changeBoardRole = Role::create(["name" => AppRole::CHANGE_BOARD]);
        $mtRole = Role::create(["name" => AppRole::MT]);
        $superAdminRole = Role::create(["name" => AppRole::SUPER_ADMIN]);

        $displayBackend = Permission::create(["name" => AppPermission::DISPLAY_BACKEND]);
        $displayCircles = Permission::create(["name" => AppPermission::DISPLAY_CIRCLES]);
        $displaySuperCircles = Permission::create(["name" => AppPermission::DISPLAY_SUPER_CIRCLES]);
        $displayJustifications = Permission::create(["name" => AppPermission::DISPLAY_JUSTIFICATIONS]);
        $editCircles = Permission::create(["name" => AppPermission::EDIT_CIRCLES]);
        $editSuperCircles = Permission::create(["name" => AppPermission::EDIT_SUPER_CIRCLES]);
        $editJustifications = Permission::create(["name" => AppPermission::EDIT_JUSTIFICATIONS]);
        $createCircles = Permission::create(["name" => AppPermission::CREATE_CIRCLES]);
        $createSuperCircles = Permission::create(["name" => AppPermission::CREATE_SUPER_CIRCLES]);
        $createJustifications = Permission::create(["name" => AppPermission::CREATE_JUSTIFICATIONS]);
        $deleteCircles = Permission::create(["name" => AppPermission::DELETE_CIRCLES]);
        $deleteSuperCircles = Permission::create(["name" => AppPermission::DELETE_SUPER_CIRCLES]);
        $deleteJustifications = Permission::create(["name" => AppPermission::DELETE_JUSTIFICATIONS]);

        $rpaRole->givePermissionTo($displayBackend);
        $rpaRole->givePermissionTo($displayCircles);
        $rpaRole->givePermissionTo($displaySuperCircles);
        $rpaRole->givePermissionTo($displayJustifications);
        $rpaRole->givePermissionTo($editCircles);
        $rpaRole->givePermissionTo($editSuperCircles);
        $rpaRole->givePermissionTo($editJustifications);
        $rpaRole->givePermissionTo($createCircles);
        $rpaRole->givePermissionTo($createSuperCircles);
        $rpaRole->givePermissionTo($createJustifications);
        $rpaRole->givePermissionTo($deleteCircles);
        $rpaRole->givePermissionTo($deleteSuperCircles);
        $rpaRole->givePermissionTo($deleteJustifications);

        $regularUser = User::create([
            "name" => "Regular User",
            "email" => "user@test.com",
            "password" => Hash::make("password"),
        ]);

        $regularUser->assignRole(AppRole::USER);

        $advancedUser = User::create([
            "name" => "Advanced User",
            "email" => "advanced.user@test.com",
            "password" => Hash::make("password"),
        ]);

        $advancedUser->assignRole(AppRole::ADVANCED_USER);

        $rpaUser = User::create([
            "name" => "RPA User",
            "email" => "rpa.user@test.com",
            "password" => Hash::make("password"),
        ]);

        $rpaUser->assignRole(AppRole::RPA);

        $itUser = User::create([
            "name" => "IT User",
            "email" => "it.user@test.com",
            "password" => Hash::make("password"),
        ]);

        $itUser->assignRole(AppRole::IT);

        $changeBoardUser = User::create([
            "name" => "Change Board User",
            "email" => "change.board.user@test.com",
            "password" => Hash::make("password"),
        ]);

        $changeBoardUser->assignRole(AppRole::CHANGE_BOARD);

        $mtUser = User::create([
            "name" => "MT User",
            "email" => "mt.user@test.com",
            "password" => Hash::make("password"),
        ]);

        $mtUser->assignRole(AppRole::MT);

        $superAdminUser = User::create([
            "name" => "Super Admin User",
            "email" => "super.admin@test.com",
            "password" => Hash::make("password"),
        ]);

        $superAdminUser->assignRole(AppRole::SUPER_ADMIN);
    }
}
