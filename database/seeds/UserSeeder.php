<?php

use App\Circle;
use App\Idea;
use App\Permission as AppPermission;
use App\Role as AppRole;
use App\SuperCircle;
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
        $createIdea = Permission::create(["name" => AppPermission::CREATE_IDEA]);
        $createAdvancedIdea = Permission::create(["name" => AppPermission::CREATE_IDEA_ADVANCED]);
        $seeAllIdeas = Permission::create(["name" => AppPermission::SEE_ALL_IDEAS]);
        $seeMyIdeas = Permission::create(["name" => AppPermission::SEE_MY_IDEAS]);

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
        $rpaRole->givePermissionTo($seeAllIdeas);
        
        $userRole->givePermissionTo($createIdea);
        $userRole->givePermissionTo($seeMyIdeas);

        $advancedUserRole->givePermissionTo($createIdea);
        $advancedUserRole->givePermissionTo($seeMyIdeas);
        $advancedUserRole->givePermissionTo($createAdvancedIdea);

        $managerUser = User::create([
            "name" => "Line Manager User",
            "email" => "line.manager@test.com",
            "password" => Hash::make("password"),
        ]);

        $managerUser->update([
            "manager_id" => $managerUser->id,
        ]);

        $headOfUser1 = User::create([
            "name" => "Head of Department User 1",
            "email" => "head.of1@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $headOfUser2 = User::create([
            "name" => "Head of Department User 2",
            "email" => "head.of2@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $regularUser = User::create([
            "name" => "Regular User",
            "email" => "user@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $advancedUser = User::create([
            "name" => "Advanced User",
            "email" => "advanced.user@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $rpaUser = User::create([
            "name" => "RPA User",
            "email" => "rpa.user@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $itUser = User::create([
            "name" => "IT User",
            "email" => "it.user@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $changeBoardUser = User::create([
            "name" => "Change Board User",
            "email" => "change.board.user@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $mtUser = User::create([
            "name" => "MT User",
            "email" => "mt.user@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $superAdminUser = User::create([
            "name" => "Super Admin User",
            "email" => "super.admin@test.com",
            "password" => Hash::make("password"),
            "manager_id" => $managerUser->id,
        ]);

        $managerUser->assignRole(AppRole::USER);
        $headOfUser1->assignRole(AppRole::USER);
        $headOfUser2->assignRole(AppRole::USER);
        $regularUser->assignRole(AppRole::USER);
        $advancedUser->assignRole(AppRole::ADVANCED_USER);
        $rpaUser->assignRole(AppRole::RPA);
        $itUser->assignRole(AppRole::IT);
        $changeBoardUser->assignRole(AppRole::CHANGE_BOARD);
        $mtUser->assignRole(AppRole::MT);
        $superAdminUser->assignRole(AppRole::SUPER_ADMIN);

        $sc1 = SuperCircle::create([
            "name" => "Super Circle 1",
            "head_of_id" => $headOfUser1->id,
        ]);

        $sc2 = SuperCircle::create([
            "name" => "Super Circle 2",
            "head_of_id" => $headOfUser1->id,
        ]);

        $sc3 = SuperCircle::create([
            "name" => "Super Circle 3",
            "head_of_id" => $headOfUser2->id,
        ]);

        Circle::create([
            "name" => "Circle 1",
            "super_circle_id" => $sc1->id
        ]);

        Circle::create([
            "name" => "Circle 2",
            "super_circle_id" => $sc1->id
        ]);

        Circle::create([
            "name" => "Circle 3",
            "super_circle_id" => $sc2->id
        ]);

        Circle::create([
            "name" => "Circle 4",
            "super_circle_id" => $sc2->id
        ]);

        Circle::create([
            "name" => "Circle 5",
            "super_circle_id" => $sc3->id
        ]);

        Circle::create([
            "name" => "Circle 6",
            "super_circle_id" => $sc3->id
        ]);
    }
}
