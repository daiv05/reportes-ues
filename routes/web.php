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
    Route::get('/aulas', [AulasController::class, 'index'])->name('aulas.index');
    Route::resource('aulas', AulasController::class)->except(['destroy']);
    Route::patch('aulas/{aula}/toggle', [AulasController::class, 'toggleActivo'])->name('aulas.toggleActivo');
});

// Rutas para Tipo de Actividades
Route::get('/tipo-actividad', [App\Http\Controllers\TipoActividadController::class, 'create'])->name('actividad-tipo.create');
Route::post('/actividades', [App\Http\Controllers\TipoActividadController::class, 'store'])->name('tipo-actividades.store');
// Ruta para la edición
Route::put('/tipo-actividad/{id}', [App\Http\Controllers\TipoActividadController::class, 'update'])->name('actividad-tipo.update');

// Ruta para la eliminación
Route::delete('/tipo-actividad/{id}', [App\Http\Controllers\TipoActividadController::class, 'destroy'])->name('actividad-tipo.destroy');

require __DIR__ . '/auth.php';
