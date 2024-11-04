<?php

use App\Http\Controllers\Actividades\ActividadController;
use App\Http\Controllers\Actividades\TipoActividadController;
use App\Http\Controllers\Mantenimientos\AsignaturaController;
use App\Http\Controllers\Mantenimientos\AulasController;
use App\Http\Controllers\Mantenimientos\EscuelaController;
use App\Http\Controllers\rhu\EntidadesController;
use App\Http\Controllers\rhu\PuestoController;
use App\Http\Controllers\Seguridad\ProfileController;
use App\Http\Controllers\Reporte\ReporteController;
use App\Http\Controllers\rhu\EmpleadoPuestoController;
use App\Http\Controllers\Seguridad\RoleController;
use App\Http\Controllers\Seguridad\UsuarioController;
use App\Http\Controllers\Mantenimientos\CicloController;
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
        Route::get('/listado-general', [ReporteController::class, 'index'])->name('reportes-generales');
        Route::get('/registrar', [ReporteController::class, 'create'])->name('crear-reporte');
        Route::post('/store', [ReporteController::class, 'store'])->name('reportes.store');
        Route::get('/detalle/{id}', [ReporteController::class, 'detalle'])->name('detalle-reporte');
        Route::put('/marcar-no-procede/{id}', [ReporteController::class, 'marcarNoProcede'])->name('reportes.noProcede');
        Route::post('/realizar-asignacion/{id}', [ReporteController::class, 'realizarAsignacion'])->name('reportes.realizarAsignacion');
        Route::post('/actualizar-estado/{id}', [ReporteController::class, 'actualizarEstadoReporte'])->name('reportes.actualizarEstado');
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
        Route::get('/importar-actividades', function () {
            return view('actividades.importacion-actividades.importacion-actividades');
        })->name('importar-actividades');
        Route::post('/importar-actividades', [ActividadController::class, 'importarExcel'])->name('importar-actividades-post');
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

         // Rutas de Ciclos
        Route::prefix('ciclos')->group(function () {
            Route::get('/', [CicloController::class, 'index'])->name('ciclos.index');
            Route::post('/', [CicloController::class, 'store'])->name('ciclos.store');
            Route::put('/{id}', [CicloController::class, 'update'])->name('ciclos.update');
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

    /* ****************************************** */
    /*   ************* RHU ************   */
    /* ****************************************** */
    Route::prefix('rhu')->group(function () {
        // Rutas de entidades
        Route::prefix('entidades')->group(function () {
            Route::get('/', [EntidadesController::class, 'index'])->name('entidades.index');
            Route::post('/', [EntidadesController::class, 'store'])->name('entidades.store');
            Route::put('/{id}', [EntidadesController::class, 'update'])->name('entidades.update');
        });
        /*Puestos*/
        Route::get('/puestos', [PuestoController::class, 'index'])->name('puestos.index');
        Route::resource('puestos', PuestoController::class)->except(['destroy']);
        Route::patch('puestos/{puesto}/toggle', [PuestoController::class, 'toggleActivo'])->name('puestos.toggleActivo');
        /*Empleados Puestos*/
        Route::get('/busqueda-por-nombre/{id_entidad}', [EmpleadoPuestoController::class, 'buscarPorNombre'])->name('empleadosPuestos.buscarPorNombre');
        Route::get('/busqueda-supervisor-por-nombre', [EmpleadoPuestoController::class, 'buscarSupervisorPorNombre'])->name('empleadosPuestos.buscarSupervisorPorNombre');
    });


    /* ****************************************** */
    /*   ************* GENERAL ************   */
    /* ****************************************** */
    Route::prefix('general')->group(function () {
        // Rutas de general

    });
});


require __DIR__ . '/auth.php';
