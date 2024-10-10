<?php

use App\Http\Controllers\Mantenimientos\AsignaturaController;
use App\Http\Controllers\Mantenimientos\AulasController;
use App\Http\Controllers\Mantenimientos\DepartamentoController;
use App\Http\Controllers\Mantenimientos\EscuelaController;
use App\Http\Controllers\Seguridad\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Actividades\TipoActividadController;

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
        return view('reportes.reportes-dd.crear-reporte');
    })->name('crear-reporte');
    Route::get('/reportes-generales', function () {
        return view('reportes.listado-reportes.reportes_generales');
    })->name('reportes-generales');

    //Mantenimientos
    Route::get('/aulas', [AulasController::class, 'index'])->name('aulas.index');
    Route::resource('aulas', AulasController::class)->except(['destroy']);
    Route::patch('aulas/{aula}/toggle', [AulasController::class, 'toggleActivo'])->name('aulas.toggleActivo');

    //Actividades
    Route::prefix('actividad')->group(function () {
        Route::get('/tipo', [TipoActividadController::class, 'index'])->name('actividad-tipo.index');
        Route::post('/tipo', [TipoActividadController::class, 'store'])->name('actividades_tipo.store');
        Route::put('/tipo/{id}', [TipoActividadController::class, 'update'])->name('actividad-tipo.update');
        Route::delete('/tipo/{id}', [TipoActividadController::class, 'destroy'])->name('actividad-tipo.destroy');
    });

    // Rutas de Escuela
    Route::prefix('escuela')->group(function () {
        Route::get('/', [EscuelaController::class, 'index'])->name('escuela.index');
        Route::patch('/{escuela}/toggle', [EscuelaController::class, 'toggleActivo'])->name('escuela.toggleActivo');
    });
    Route::resource('/escuela', EscuelaController::class)->except(['destroy']);

    // Rutas de asignatura
    Route::prefix('asignatura')->group(function () {
        Route::get('/', [AsignaturaController::class, 'index'])->name('asignatura.index');
        Route::patch('/{asignatura}/toggle', [AsignaturaController::class, 'toggleActivo'])->name('asignatura.toggleActivo');
    });
    Route::resource('/asignatura', AsignaturaController::class)->except(['destroy']);
    // Departamentos
    Route::prefix('departamentos')->group(function () {
        Route::get('/', [DepartamentoController::class, 'index'])->name('departamentos.index');
        Route::post('/', [DepartamentoController::class, 'store'])->name('departamentos.store');
        Route::put('/{id}', [DepartamentoController::class, 'update'])->name('departamentos.update');
    });

    Route::prefix('actividades')->group(function () {
        Route::get('/clases', function () {
            return view('actividades.listado-actividades.listado-clases');
        })->name('listado-clases');
        Route::get('/eventos-evaluaciones', function () {
            return view('actividades.listado-actividades.listado-eventos-evaluaciones');
        })->name('listado-eventos-evaluaciones');
    });
});



require __DIR__ . '/auth.php';
