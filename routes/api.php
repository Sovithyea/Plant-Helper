<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CropController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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




Route::group([
    'middleware' => ['auth:api', 'verified'],
], function () {
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::prefix('setting')->group(function () {

        Route::get('/profile', [SettingController::class, 'index']);
        Route::put('/change_profile', [SettingController::class, 'changeProfile']);
        Route::post('/change_password', [SettingController::class, 'changePassword']);
    });
    // dashboard
    Route::get('dashboard', DashboardController::class);
    Route::get('categoryChart', [DashboardController::class, 'categoryChart']);
    Route::get('diseaseChart', [DashboardController::class, 'diseaseChart']);
    Route::get('guideChart', [DashboardController::class, 'guideChart']);

    // crop
    Route::get('/crop/conditions', [CropController::class, 'createCondition']);
    Route::post('/crop/condition', [CropController::class, 'storeConditionCrop']);
    Route::get('/crop/{crop}/activity', [CropController::class, 'showActivity']);
    Route::get('/crop/{crop}/disease', [CropController::class, 'showDisease']);
    Route::get('/crop/{crop}/condition', [CropController::class, 'showCondition']);
    Route::get('/crop/{crop}/condition/{condition}/edit', [CropController::class, 'editCondition']);
    Route::put('/crop/{crop}/condition/{condition}/update', [CropController::class, 'updateCondition']);

    // softdeleteuser
    Route::get('/user/{id}/restore', [UserController::class, 'recovery']);
    Route::delete('/user/{id}/forceDelete', [UserController::class, 'delete']);
    Route::get('/user/trash', [UserController::class, 'trash']);
    // Route::apiResource('category',CategoryController::class);
    // routeresourceall
    Route::resource('crop', CropController::class);
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('disease', DiseaseController::class);
    Route::resource('condition', ConditionController::class);
    Route::resource('activity', ActivityController::class);

});
// Route::get('getCategory', [CategoryController::class, 'index']);

    // export
Route::get('dashboardExport', [DashboardController::class, 'export']);
Route::get('userExport', [UserController::class, 'export']);
Route::get('cropExport', [CropController::class, 'export']);
Route::get('diseaseExport', [DiseaseController::class, 'export']);
Route::get('guideExport', [ActivityController::class, 'export']);


// for api without authenticated
Route::get('getCategory', [ApiController::class, 'category']);
Route::get('getCropAll', [ApiController::class, 'cropAll']);
Route::get('getCrop/{category_id}', [ApiController::class, 'crop']);
Route::get('getCropDetail/{crop_id}', [ApiController::class, 'cropShow']);
Route::get('getCropDetail/{crop_id}/disease', [ApiController::class, 'cropDisease']);
Route::get('getCropDetail/{crop_id}/guide', [ApiController::class, 'cropGuide']);
Route::get('getDiseaseDetail/{disease_id}', [ApiController::class, 'diseaseShow']);
Route::get('getActivityDetail/{activity_id}', [ApiController::class, 'activityShow']);
Route::get('getDiseaseAll', [ApiController::class, 'diseaseAll']);
Route::get('getGuideAll', [ApiController::class, 'guideAll']);

//comment
Route::resource('comment', CommentController::class);



// auth
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('refresh', [LoginController::class, 'refresh']);

// Route::get('/email/verify/{id}/{hash}', function (Request $request) {
//     $request->fulfill();

//     return response()->json(['message' => 'verify success']);
// })->middleware(['auth:api', 'signed'])->name('verification.verify');

// Route::get('/email/verify/{id}/{hash}', function (Request $request) {
//     $request->fullUrl();
//     $user = User::where('id', );
//     return response()->json(['message' => 'verify success']);
// })->name('verification.verify');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');


Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        return success('Your password reset link has been sent to your email. If you not seeing in inbox please check in spam');
    }

    return server_error(__($status));
})->middleware('guest')->name('password.email');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return success('Password has been reset');
    }

    return server_error(__($status));
})->middleware('guest')->name('password.update');
