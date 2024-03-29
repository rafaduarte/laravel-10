<?php

use App\Enums\SupportStatus;
use App\Http\Controllers\Admin\{SupportController};
use App\Http\Controllers\site\SiteController;
use App\Models\Support;
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
// Route::get('/test', function () {
//     dd(SupportStatus::cases());
// });

// Route::get('/test', function () {
//     return SupportStatus::A;
// });

// Route::get('/test', function () {
//     dd(SupportStatus::class);
// });

Route::get('/test', function () {
    dd([
        'A' => SupportStatus::A,
        'C' => SupportStatus::C,
        'P' => SupportStatus::P,
    ]);
});


Route::get('/supports/create', [SupportController::class, 'create'])->name('supports.create');
Route::delete('/supports/{id}', [SupportController::class, 'destroy'])->name('supports.destroy');
Route::put('/supports/{id}', [SupportController::class, 'update'])->name('supports.update');
Route::get('/supports/{id}/edit', [SupportController::class, 'edit'])->name('supports.edit');
Route::get('/supports/{id}', [SupportController::class, 'show'])->name('supports.show');
Route::post('/supports', [SupportController::class, 'store'])->name('supports.store');
Route::get('/supports', [SupportController::class, 'index'])->name('supports.index');

Route::get('/contato', [SiteController::class, 'contact']);

Route::get('/', function () {
    return view('welcome');
});
