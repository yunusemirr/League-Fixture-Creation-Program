<?php

use App\Http\Controllers\Api\ChatController as ApiChatController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ChatController;
use App\Http\Controllers\Backend\SeasonController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\BackendController;
use App\Lib\MatchMaker;
use App\Models\File;
use App\Models\Season;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function () {
    $season = Season::first();
    $matchMaking = MatchMaker::init($season);
    $matchMaking->handleFirstHalf();
    dd($season);
});




Route::get('/login', fn() => redirect()->route('login.show'))->name('login');

Route::get('file-download/{file?}', function (File $file) {
    return response()->download(public_path("upload/" . $file->path));
})->name("file_downloader");

/**
 * Admin Routes
 */
Route::group([], function () {
    Route::get('/logout', [BackendController::class, 'postLogout'])->name('logout.post');
    Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
        Route::get('/', [BackendController::class, 'showLogin'])->name('show');
        Route::post('/', [BackendController::class, 'postLogin'])->name('post');
    });


    Route::group(['middleware' => ['auth', 'role.allow'], 'prefix' => '/'], function () {

        Route::group(['prefix' => 'season', 'as' => 'season.'], function () {
            Route::get('/', [SeasonController::class, 'index'])->name('index');
            Route::get('/create', [SeasonController::class, 'create'])->name('create');
            Route::post('/store', [SeasonController::class, 'store'])->name('store');
            Route::post('/update', [SeasonController::class, 'update'])->name('update');
            Route::delete('/delete', [SeasonController::class, 'delete'])->name('delete');

            Route::get('/{season:id}', [SeasonController::class, 'hydrateSeason'])->name('hydrate');
            Route::get('/{season:id}/show/{path?}', [SeasonController::class, 'showSeason'])->name('show')->whereIn("path", [
                "index",
                "table",
                "matches",
                "fixture"
            ]);
            Route::get('/{season:id}/final', [SeasonController::class, 'seasonFinal'])->name('final');
        });

        Route::group(['prefix' => 'team', 'as' => 'team.'], function () {
            Route::get('/', [TeamController::class, 'index'])->name('index');
            Route::get('/create', [TeamController::class, 'create'])->name('create');
            Route::post('/store', [TeamController::class, 'store'])->name('store');
            Route::post('/update', [TeamController::class, 'update'])->name('update');
            Route::delete('/delete', [TeamController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::post('/update', [UserController::class, 'update'])->name('update');
            Route::any('/ajax-check', [UserController::class, 'ajaxCheck'])->name('ajax_check');

            Route::delete('/delete', [UserController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/save', [SettingController::class, 'save'])->name('save');
        });

        Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
            Route::post('/store', [RoleController::class, 'store'])->name('store');
            Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('/delete', [RoleController::class, 'delete'])->name('delete');
        });

        Route::group(['as' => 'panel.'], function () {
            Route::get('/{selectedSeason?}', [DashboardController::class, 'getIndex'])->name('show');
        });
    });
});
