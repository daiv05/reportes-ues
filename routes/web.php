<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AulasController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/realizar-reporte', function () {
        return view('reportes-dd/crear-reporte');
    })->name('crear-reporte');
    Route::get('/reportes-generales', function () {
        return view('listado-reportes.reportes_generales');
    })->name('reportes-generales');

    //Mantenimientos
    Route::resource('aulas', AulasController::class)->except(['destroy']);
    Route::patch('aulas/{aula}/toggle', [AulasController::class, 'toggleActivo'])->name('aulas.toggleActivo');
});

require __DIR__ . '/auth.php';
