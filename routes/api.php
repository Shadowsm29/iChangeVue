<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

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
        $user = $request->user();
        $permissions = $user->getAllPermissions();
        $user->permissions = $permissions;
        return $user;
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::get("circles", "CircleController@fetchCircles");
    Route::post("circles/new", "CircleController@ceateNewCircle");
    Route::post("circles/{circle}/update", "CircleController@updateCircle");
    Route::delete("circles/{circle}/delete", "CircleController@deleteCircle");

    Route::get("super-circles", "SuperCircleController@fetchSuperCircles");
    Route::post("super-circles/{super_circle}/update", "SuperCircleController@updateSuperCircle");
    Route::post("super-circles/new", "SuperCircleController@createNewSuperCircle");
    Route::delete("super-circles/{super_circle}/delete", "SuperCircleController@deleteSuperCircle");

    Route::get("justifications", "JustificationController@fetchJustifications");
    Route::post("justifications/{justification}/update", "JustificationController@updateJustification");
    Route::post("justifications/new", "JustificationController@createNewJustification");
    Route::delete("justifications/{justification}/delete", "JustificationController@deleteJustification");
});

Route::get("user/permissions", "UserController@fetchUserPermissions");

Route::get("users", "UserController@fetchUserList");

Route::get("users/{user}", "UserController@fetchUser");

Route::post("users/{user}/update", "UserController@updateUser");

Route::delete("users/{user}/delete", "UserController@deleteUser");

Route::post("users/new", "UserController@createUser");

Route::get("roles", "RoleController@fetchRoleList");

Route::post("roles/new", "RoleController@createRole");

Route::get("roles/{role}", "RoleController@fetchRole");

Route::post("roles/{role}/update", "RoleController@updateRole");

Route::delete("roles/{role}/delete", "RoleController@deleteRole");

Route::get("permissions", "PermissionController@fetchPermissionList");



