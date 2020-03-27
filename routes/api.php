<?php

use App\Http\Controllers\UserController;
use App\Permission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        $user = User::with(["manager"])->where("id", $request->user()->id)->firstOrFail();
        return $user;
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::get("circles", "CircleController@fetchCircles")
        ->middleware("hasPermission:" . Permission::DISPLAY_BACKEND . "," . Permission::CREATE_IDEA);
    Route::post("circles/new", "CircleController@ceateNewCircle")
        ->middleware("hasPermission:" . Permission::CREATE_CIRCLES);
    Route::post("circles/{circle}/update", "CircleController@updateCircle")
        ->middleware("hasPermission:" . Permission::EDIT_SUPER_CIRCLES);
    Route::delete("circles/{circle}/delete", "CircleController@deleteCircle")
        ->middleware("hasPermission:" . Permission::DELETE_CIRCLES);

    Route::get("super-circles", "SuperCircleController@fetchSuperCircles")
        ->middleware("hasPermission:" . Permission::DISPLAY_BACKEND . "," . Permission::CREATE_IDEA);
    Route::post("super-circles/new", "SuperCircleController@createNewSuperCircle")
        ->middleware("hasPermission:" . Permission::CREATE_SUPER_CIRCLES);
    Route::post("super-circles/{super_circle}/update", "SuperCircleController@updateSuperCircle")
        ->middleware("hasPermission:" . Permission::EDIT_SUPER_CIRCLES);
    Route::delete("super-circles/{super_circle}/delete", "SuperCircleController@deleteSuperCircle")
        ->middleware("hasPermission:" . Permission::DELETE_SUPER_CIRCLES);

    Route::get("justifications", "JustificationController@fetchJustifications")
        ->middleware("hasPermission:" . Permission::DISPLAY_BACKEND . "," . Permission::CREATE_IDEA);
    Route::post("justifications/new", "JustificationController@createNewJustification")
        ->middleware("hasPermission:" . Permission::CREATE_JUSTIFICATIONS);
    Route::post("justifications/{justification}/update", "JustificationController@updateJustification")
        ->middleware("hasPermission:" . Permission::EDIT_JUSTIFICATIONS);
    Route::delete("justifications/{justification}/delete", "JustificationController@deleteJustification")
        ->middleware("hasPermission:" . Permission::DELETE_JUSTIFICATIONS);

    Route::get("change-types", "ChangeTypeController@fetchChangeTypes")
        ->middleware("hasPermission:" . Permission::CREATE_IDEA);

    Route::post("ideas/create", "IdeaController@createIdea")
        ->middleware("hasPermission:" . Permission::CREATE_IDEA);
    Route::get("ideas/my-ideas", "IdeaController@fetchMyIdeas")
        ->middleware("hasPermission:" . Permission::CREATE_IDEA);
    Route::get("ideas/pending-at-me", "IdeaController@fetchIdeasPendingAtMe");
    // ->middleware("hasPermission:" . Permission::PROCESS_IDEAS);
    Route::get("ideas", "IdeaController@fetchAllIdeas")
        ->middleware("hasPermission:" . Permission::SEE_ALL_IDEAS);
    Route::get("ideas/{idea}", "IdeaController@fetchIdea");

    Route::get("user/permissions", "UserController@fetchUserPermissions");

    Route::get("users", "UserController@fetchUserList")->middleware("hasPermission:create idea,display backend");

    Route::get("users/{user}", "UserController@fetchUser");

    Route::post("users/{user}/update", "UserController@updateUser");

    Route::delete("users/{user}/delete", "UserController@deleteUser");

    Route::post("users/new", "UserController@createUser");
});



Route::get("roles", "RoleController@fetchRoleList");

Route::post("roles/new", "RoleController@createRole");

Route::get("roles/{role}", "RoleController@fetchRole");

Route::post("roles/{role}/update", "RoleController@updateRole");

Route::delete("roles/{role}/delete", "RoleController@deleteRole");

Route::get("permissions", "PermissionController@fetchPermissionList");
