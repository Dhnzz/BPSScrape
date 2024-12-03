<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{TargetController, DashboardController, ScraperController, ResultController, KeywordController};

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
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::prefix('dashboard')->group(function () {

    Route::resource('target', TargetController::class);
    Route::get('/target/selector/{target}', [TargetController::class, 'addSelector'])->name('target.addSelector');
    Route::post('/target/saveSelector/{target}', [TargetController::class, 'saveSelector'])->name('target.saveSelector');
    Route::get('/target/editSelector/{target}', [TargetController::class, 'editSelector'])->name('target.editSelector');
    Route::put('/target/updateSelector/{target}', [TargetController::class, 'updateSelector'])->name('target.updateSelector');
    Route::post('/scrape/{target}', [ScraperController::class, 'index'])->name('scrape');
    Route::get('/target/result/{id}', [ResultController::class, 'index'])->name('result.index');
    Route::get('/target/result/show/{result}', [ResultController::class, 'show'])->name('result.show');

    Route::resource('keyword', KeywordController::class);

    Route::get('/scrape_test/{target}', [ScraperController::class, 'test'])->name('test');
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
