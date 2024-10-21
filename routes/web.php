<?php

use App\Http\Controllers\Mantenimientos\AsignaturaController;
use App\Http\Controllers\Mantenimientos\AulasController;
use App\Http\Controllers\Mantenimientos\DepartamentoController;
use App\Http\Controllers\Mantenimientos\EscuelaController;
use App\Http\Controllers\Seguridad\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Actividades\TipoActividadController;
use App\Http\Controllers\Seguridad\RoleController;
use App\Http\Controllers\Seguridad\UsuarioController;

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

    //Actividades
    Route::prefix('actividad')->group(function () {
        Route::get('/tipo', [TipoActividadController::class, 'index'])->name('actividad-tipo.index');
        Route::post('/tipo', [TipoActividadController::class, 'store'])->name('actividades_tipo.store');
        Route::put('/tipo/{id}', [TipoActividadController::class, 'update'])->name('actividad-tipo.update');
        Route::delete('/tipo/{id}', [TipoActividadController::class, 'destroy'])->name('actividad-tipo.destroy');
    });


    /* ***************************************** */
    /*   ************* REPORTES *************    */
    /* ***************************************** */
    Route::prefix('reportes')->group(function () {
        Route::get('/listado-general', function () {
            return view('reportes.index');
        })->name('reportes-generales');
        Route::get('/registrar', function () {
            return view('reportes.create');
        })->name('crear-reporte');
        Route::get('/detalle', function () {
            return view('reportes.detail');
        })->name('detalle-reporte');
    });

    /* ****************************************** */
    /*   ************* ACTIVIDADES ************   */
    /* ****************************************** */
    Route::prefix('actividades')->group(function () {
        Route::get('/clases', function () {
            return view('actividades.listado-actividades.listado-clases');
        })->name('listado-clases');
        Route::get('/eventos-y-evaluaciones', function () {
            return view('actividades.listado-actividades.listado-eventos-evaluaciones');
        })->name('listado-eventos-evaluaciones');
    });
    /* ********************************************* */
    /*   ****** GESTIONES DE MANTENIMIENTOS ******   */
    /* ********************************************* */
    Route::prefix('mantenimientos')->group(function () {
        // Rutas de Escuela
        Route::prefix('escuelas')->group(function () {
            Route::get('/', [EscuelaController::class, 'index'])->name('escuelas.index');
            Route::patch('/{escuela}/toggle', [EscuelaController::class, 'toggleActivo'])->name('escuelas.toggleActivo');
        });
        Route::resource('/escuela', EscuelaController::class)->except(['destroy']);

        // Rutas de Aulas
        Route::get('/aulas', [AulasController::class, 'index'])->name('aulas.index');
        Route::resource('aulas', AulasController::class)->except(['destroy']);
        Route::patch('aulas/{aula}/toggle', [AulasController::class, 'toggleActivo'])->name('aulas.toggleActivo');

        // Rutas de Asignaturas
        Route::prefix('asignaturas')->group(function () {
            Route::get('/', [AsignaturaController::class, 'index'])->name('asignaturas.index');
            Route::patch('/{asignatura}/toggle', [AsignaturaController::class, 'toggleActivo'])->name('asignaturas.toggleActivo');
        });
        Route::resource('/asignatura', AsignaturaController::class)->except(['destroy']);

        // Rutas de Departamentos
        Route::prefix('departamentos')->group(function () {
            Route::get('/', [DepartamentoController::class, 'index'])->name('departamentos.index');
            Route::post('/', [DepartamentoController::class, 'store'])->name('departamentos.store');
            Route::put('/{id}', [DepartamentoController::class, 'update'])->name('departamentos.update');
        });
    });
    /* ****************************************** */
    /*   ************* SEGURIDAD ************   */
    /* ****************************************** */
    Route::prefix('seguridad')->group(function () {
        /*ROLES*/
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::resource('roles', RoleController::class)->except(['destroy']);
        Route::patch('roles/{rol}/toggle', [RoleController::class, 'toggleActivo'])->name('roles.toggleActivo');

        /*USUARIOS*/
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::resource('usuarios', UsuarioController::class)->except(['destroy']);
        Route::patch('usuarios/{usuario}/toggle', [UsuarioController::class, 'toggleActivo'])->name('usuarios.toggleActivo');

    });
});


require __DIR__ . '/auth.php';
