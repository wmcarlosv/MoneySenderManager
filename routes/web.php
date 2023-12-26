<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ReportController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

if (config('app.debug')) {
    Route::get('/dev/{command}', function ($command) {
        Artisan::call($command);
        $output = Artisan::output();
        dd($output);
    });
}

Auth::routes();

Route::group(['prefix'=>'admin', 'middleware'=>['auth']], function(){
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::resource('users',UserController::class);
    
    Route::get('profile',[UserController::class, 'profile'])->name('profile');
    Route::put('update-profile',[UserController::class, 'update_profile'])->name('update_profile');
    Route::put('change-password',[UserController::class, 'change_password'])->name('change_password');

    Route::resource('countries',CountryController::class);
    Route::resource('services',ServiceController::class);
    Route::resource('persons',PersonController::class);
    Route::post('delete-image', [PersonController::class, 'deleteImage'])->name('deleteImage');
    Route::resource('shipments',ShipmentController::class);

    Route::get('reports-movements',[ReportController::class, 'reports_movements'])->name('reports.movements');
    Route::get('reports-movements-sum-by-service',[ReportController::class, 'reports_movements_sum_by_service'])->name('reports.reports_movements_sum_by_service');
});