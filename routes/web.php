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
use App\Http\Controllers\Reporte\EstadoController;
use App\Http\Controllers\rhu\EmpleadoPuestoController;
use App\Http\Controllers\Seguridad\RoleController;
use App\Http\Controllers\Seguridad\UsuarioController;
use App\Http\Controllers\Mantenimientos\CicloController;
use App\Http\Controllers\Mantenimientos\RecursoController;
use App\Mail\EnvioMailable;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auditorias\UserAuditController;

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

/*Route::get('/contactos', function () {
    Mail::to('bryan@ues.edu.sv')->send(new EnvioMailable);
    return "mensaje enviado";
})->name('contactos');*/


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
        // Reportes
        Route::get('/listado-general', [ReporteController::class, 'index'])->name('reportes-generales');
        Route::get('/registrar', [ReporteController::class, 'create'])->name('crear-reporte');
        Route::post('/store', [ReporteController::class, 'store'])->name('reportes.store');
        Route::get('/detalle/{id}', [ReporteController::class, 'detalle'])->name('detalle-reporte');
        Route::get('/reportes/ver-informe/{id}', [ReporteController::class, 'verInforme'])->name('reportes.verInforme');
        Route::put('/marcar-no-procede/{id}', [ReporteController::class, 'marcarNoProcede'])->name('reportes.noProcede');
        Route::post('/realizar-asignacion/{id}', [ReporteController::class, 'realizarAsignacion'])->name('reportes.realizarAsignacion');
        Route::post('/actualizar-estado/{id}', [ReporteController::class, 'actualizarEstadoReporte'])->name('reportes.actualizarEstado');
        Route::get('/mis-reportes', [ReporteController::class, 'indexMisReportes'])->name('reportes.misReportes');
        Route::get('/mis-asignaciones', [ReporteController::class, 'misAsignaciones'])->name('reportes.misAsignaciones');
    });

    /* ****************************************** */
    /*   ************* ACTIVIDADES ************   */
    /* ****************************************** */
    Route::prefix('actividades')->group(function () {
        Route::get('/clases', [ActividadController::class, 'listadoClases'])->name('listado-clases');
        Route::get('/eventos-y-evaluaciones', [ActividadController::class, 'listadoEventos'])->name('listado-eventos-evaluaciones');
        Route::get('/importar-actividades', [ActividadController::class, 'importarActividadesView'])->name('importar-actividades');
        Route::delete('/eliminar-evento-sesion/{index}', [ActividadController::class, 'eliminarDeSesion'])->name('eliminar-evento-sesion');
        Route::post('/importar-actividades', [ActividadController::class, 'importarExcel'])->name('importar-actividades-post');
        Route::post('/importar-actividades/clases', [ActividadController::class, 'storeClases'])->name('importar-clases');
        Route::post('/importar-actividades/eventos', [ActividadController::class, 'storeEventos'])->name('importar-eventos');
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
        Route::prefix('aulas')->group(function () {
            Route::get('/', [AulasController::class, 'index'])->name('aulas.index');
            Route::patch('/{aula}/toggle', [AulasController::class, 'toggleActivo'])->name('aulas.toggleActivo');
        });
        Route::resource('aulas', AulasController::class)->except(['destroy']);

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

        //Recursos
        Route::resource('recursos', RecursoController::class)->except(['destroy']);
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
        Route::get('/empleados-puestos', [EmpleadoPuestoController::class, 'index'])->name('empleadosPuestos.index');
        Route::post('/empleados-puestos', [EmpleadoPuestoController::class, 'store'])->name('empleadosPuestos.store');
        Route::put('/empleados-puestos/{id}', [EmpleadoPuestoController::class, 'update'])->name('empleadosPuestos.update');
        Route::get('/empleados-puestos/{id}', [EmpleadoPuestoController::class, 'show'])->name('empleadosPuestos.show');
    });


    /* ****************************************** */
    /*   ************* GENERAL ************   */
    /* ****************************************** */
    Route::prefix('general')->group(function () {
        // Rutas de general

    });


    Route::get('/auditorias', [UserAuditController::class, 'index'])->name('general.index');
    Route::get('/auditorias/get-events', [UserAuditController::class, 'getEvents']); // Ruta AJAX

});


require __DIR__ . '/auth.php';
