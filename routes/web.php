<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{TargetController, DashboardController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('target', TargetController::class);
    Route::get('/target/selector/{target}', [TargetController::class, 'addSelector'])->name('target.addSelector');
    Route::post('/target/saveSelector/{target}', [TargetController::class, 'saveSelector'])->name('target.saveSelector');
});

// Route::get('/', [TargetController::class, 'index'])->name('target.index');
// Route::get('/{id}', [TargetController::class, 'show'])->name('target.show');
// Route::get('/create', [TargetController::class, 'create'])->name('target.create');
// Route::post('/store', [TargetController::class, 'store'])->name('target.store');
// Route::get('/edit/{id}', [TargetController::class, 'edit'])->name('target.edit');
// Route::put('/update/{id}', [TargetController::class, 'update'])->name('target.update');
// Route::delete('/destroy/{id}', [TargetController::class, 'destroy'])->name('target.destroy');

// Route::get('/dashboard/target/create', function () {
//     dd('Test');
// })->name('target.create');
