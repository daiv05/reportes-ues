<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Actividades\ActividadController;
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
use App\Http\Controllers\Mantenimientos\RecursoController;
use App\Http\Controllers\Mantenimientos\UnidadMedidaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auditorias\UserAuditController;
use App\Http\Controllers\Estadisticas\EstadisticasController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\Mantenimientos\BienController;
use App\Http\Controllers\Mantenimientos\TipoBienController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('auth')->group(function () {

    Route::get('/inicio', [InicioController::class, 'inicio'])->name('dashboard');

    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tipos - Actividades
    // Route::prefix('actividad')->group(function () {
    //     Route::get('/tipo', [TipoActividadController::class, 'index'])->name('actividad-tipo.index');
    //     Route::post('/tipo', [TipoActividadController::class, 'store'])->name('actividades_tipo.store');
    //     Route::put('/tipo/{id}', [TipoActividadController::class, 'update'])->name('actividad-tipo.update');
    //     Route::delete('/tipo/{id}', [TipoActividadController::class, 'destroy'])->name('actividad-tipo.destroy');
    // });


    /* ***************************************** */
    /*   ************* REPORTES *************    */
    /* ***************************************** */
    Route::prefix('reportes')->group(function () {
        Route::get('/listado-general', [ReporteController::class, 'index'])->middleware('permission:REPORTES_VER_LISTADO_GENERAL')->name('reportes-generales');
        Route::get('/registrar', [ReporteController::class, 'create'])->middleware('permission:REPORTES_CREAR')->name('crear-reporte');
        Route::post('/store', [ReporteController::class, 'store'])->middleware('permission:REPORTES_CREAR')->name('reportes.store');
        Route::get('/detalle/{id}', [ReporteController::class, 'detalle'])->middleware('permission:REPORTES_VER_LISTADO_GENERAL')->name('detalle-reporte');
        Route::get('/reportes/ver-informe/{id}', [ReporteController::class, 'verInforme'])->middleware('permission:REPORTES_ASIGNAR|REPORTES_REVISION_SOLUCION')->name('reportes.verInforme');
        Route::put('/marcar-no-procede/{id}', [ReporteController::class, 'marcarNoProcede'])->middleware('permission:REPORTES_ASIGNAR')->name('reportes.noProcede');
        Route::post('/realizar-asignacion/{id}', [ReporteController::class, 'realizarAsignacion'])->middleware('permission:REPORTES_ASIGNAR')->name('reportes.realizarAsignacion');
        Route::post('/actualizar-estado/{id}', [ReporteController::class, 'actualizarEstadoReporte'])->middleware('permission:REPORTES_ACTUALIZAR_ESTADO')->name('reportes.actualizarEstado');
        Route::get('/mis-reportes', [ReporteController::class, 'indexMisReportes'])->middleware('permission:REPORTES_CREAR')->name('reportes.misReportes');
        Route::get('/mis-asignaciones', [ReporteController::class, 'misAsignaciones'])->middleware('permission:REPORTES_VER_ASIGNACIONES')->name('reportes.misAsignaciones');
    });

    /* ****************************************** */
    /*   ************* ACTIVIDADES ************   */
    /* ****************************************** */
    Route::prefix('actividades')->group(function () {
        Route::get('/clases', [ActividadController::class, 'listadoClases'])->middleware('permission:CLASES_VER')->name('listado-clases');
        Route::post('/clases', [ActividadController::class, 'storeOneClass'])->middleware('permission:CLASES_CREAR')->name('clase.store');
        Route::put('/clases/{id}', [ActividadController::class, 'updateClass'])->middleware('permission:CLASES_EDITAR')->name('clase.update');
        Route::post('/eventos-y-evaluaciones', [ActividadController::class, 'storeOneEvent'])->middleware('permission:EVENTOS_CREAR')->name('evento.store');
        Route::put('/eventos-y-evaluaciones/{id}', [ActividadController::class, 'updateEvent'])->middleware('permission:CLASES_EDITAR')->name('evento.update');
        Route::get('/eventos-y-evaluaciones', [ActividadController::class, 'listadoEventos'])->middleware('permission:EVENTOS_VER')->name('listado-eventos-evaluaciones');
        Route::get('/importar-actividades', [ActividadController::class, 'importarActividadesView'])->middleware('permission:ACTIVIDADES_CARGA_EXCEL')->name('importar-actividades');
        Route::delete('/eliminar-evento-sesion/{index}', [ActividadController::class, 'eliminarDeSesion'])->middleware('permission:ACTIVIDADES_CARGA_EXCEL')->name('eliminar-evento-sesion');
        Route::post('/importar-actividades', [ActividadController::class, 'importarExcel'])->middleware('permission:ACTIVIDADES_CARGA_EXCEL')->name('importar-actividades-post');
        Route::post('/importar-actividades/clases', [ActividadController::class, 'storeClases'])->middleware('permission:ACTIVIDADES_CARGA_EXCEL')->name('importar-clases');
        Route::post('/importar-actividades/eventos', [ActividadController::class, 'storeEventos'])->middleware('permission:ACTIVIDADES_CARGA_EXCEL')->name('importar-eventos');
    });

    /* ********************************************* */
    /*   ****** GESTIONES DE MANTENIMIENTOS ******   */
    /* ********************************************* */
    Route::prefix('mantenimientos')->group(function () {
        //  Route::get('/escuelas', [EscuelaController::class, 'index'])->middleware('permission:ASIGNATURAS_VER')->name('escuelas.index');
        //  Route::patch('/escuelas/{escuela}/toggle', [EscuelaController::class, 'toggleActivo'])->middleware('permission:AULAS_EDITAR')->name('escuelas.toggleActivo');
        Route::get('escuela', [EscuelaController::class, 'index'])->middleware('permission:ESCUELAS_VER')->name('escuela.index');
        Route::post('escuela', [EscuelaController::class, 'store'])->middleware('permission:ESCUELAS_CREAR')->name('escuela.store');
        Route::get('escuela/create', [EscuelaController::class, 'create'])->middleware('permission:ESCUELAS_CREAR')->name('escuela.create');
        Route::get('escuela/{escuela}', [EscuelaController::class, 'show'])->middleware('permission:ESCUELAS_VER')->name('escuela.show');
        Route::put('escuela/{escuela}', [EscuelaController::class, 'update'])->middleware('permission:ESCUELAS_EDITAR')->name('escuela.update');
        Route::patch('escuela/{escuela}', [EscuelaController::class, 'update'])->middleware('permission:ESCUELAS_EDITAR')->name('escuela.patch');
        Route::get('escuela/{escuela}/edit', [EscuelaController::class, 'edit'])->middleware('permission:ESCUELAS_EDITAR')->name('escuela.edit');
        Route::patch('escuelas/{escuela}/toggle', [EscuelaController::class, 'toggleActivo'])->middleware('permission:ESCUELAS_EDITAR')->name('escuelas.toggleActivo');

        // Rutas de Aulas
        Route::get('aulas', [AulasController::class, 'index'])->middleware('permission:AULAS_VER')->name('aulas.index');
        Route::post('aulas', [AulasController::class, 'store'])->middleware('permission:AULAS_CREAR')->name('aulas.store');
        Route::get('aulas/create', [AulasController::class, 'create'])->middleware('permission:AULAS_CREAR')->name('aulas.create');
        Route::get('aulas/{aula}', [AulasController::class, 'show'])->middleware('permission:AULAS_VER')->name('aulas.show');
        Route::put('aulas/{aula}', [AulasController::class, 'update'])->middleware('permission:AULAS_EDITAR')->name('aulas.update');
        Route::patch('aulas/{aula}', [AulasController::class, 'update'])->middleware('permission:AULAS_EDITAR')->name('aulas.update');
        Route::get('aulas/{aula}/edit', [AulasController::class, 'edit'])->middleware('permission:AULAS_EDITAR')->name('aulas.edit');
        Route::patch('aulas/{aula}/toggle', [AulasController::class, 'toggleActivo'])->middleware('permission:AULAS_EDITAR')->name('aulas.toggleActivo');

        // Rutas de Asignaturas
        Route::get('asignatura', [AsignaturaController::class, 'index'])->middleware('permission:ASIGNATURAS_VER')->name('asignatura.index');
        Route::post('asignatura', [AsignaturaController::class, 'store'])->middleware('permission:ASIGNATURAS_CREAR')->name('asignatura.store');
        Route::get('asignatura/create', [AsignaturaController::class, 'create'])->middleware('permission:ASIGNATURAS_CREAR')->name('asignatura.create');
        Route::get('asignatura/{asignatura}', [AsignaturaController::class, 'show'])->middleware('permission:ASIGNATURAS_VER')->name('asignatura.show');
        Route::put('asignatura/{asignatura}', [AsignaturaController::class, 'update'])->middleware('permission:ASIGNATURAS_EDITAR')->name('asignatura.update');
        Route::patch('asignatura/{asignatura}', [AsignaturaController::class, 'update'])->middleware('permission:ASIGNATURAS_EDITAR')->name('asignatura.update');
        Route::get('asignatura/{asignatura}/edit', [AsignaturaController::class, 'edit'])->middleware('permission:ASIGNATURAS_EDITAR')->name('asignatura.edit');
        Route::patch('asignatura/{asignatura}/toggle', [AsignaturaController::class, 'toggleActivo'])->middleware('permission:ASIGNATURAS_EDITAR')->name('asignatura.toggleActivo');
        Route::post('asignatura/importar', [AsignaturaController::class, 'importarDatos'])->middleware('permission:ASIGNATURAS_CREAR')->name('asignatura.importar');


        // Rutas de Ciclos
        Route::prefix('ciclos')->group(function () {
            Route::get('/', [CicloController::class, 'index'])->middleware('permission:CICLOS_VER')->name('ciclos.index');
            Route::post('/', [CicloController::class, 'store'])->middleware('permission:CICLOS_CREAR')->name('ciclos.store');
            Route::put('/{id}', [CicloController::class, 'update'])->middleware('permission:CICLOS_EDITAR')->name('ciclos.update');
        });

        // Unidades de medida
        Route::prefix('unidades-medida')->group(function () {
            Route::get('/', [UnidadMedidaController::class, 'index'])->middleware('permission:UNIDADES_MEDIDA_VER')->name('unidades-medida.index');
            Route::post('/', [UnidadMedidaController::class, 'store'])->middleware('permission:UNIDADES_MEDIDA_CREAR')->name('unidades-medida.store');
            Route::put('{id}', [UnidadMedidaController::class, 'update'])->middleware('permission:UNIDADES_MEDIDA_EDITAR')->name('unidades-medida.update');
        });

        // Recursos
        Route::prefix('recursos')->group(function () {
            Route::get('/', [RecursoController::class, 'index'])->middleware('permission:RECURSOS_VER')->name('recursos.index');
            Route::post('/', [RecursoController::class, 'store'])->middleware('permission:RECURSOS_CREAR')->name('recursos.store');
            Route::put('/{id}', [RecursoController::class, 'update'])->middleware('permission:RECURSOS_EDITAR')->name('recursos.update');
        });

        // Bienes
        Route::prefix('bienes')->group(function () {
            Route::get('/', [BienController::class, 'index'])->middleware('permission:BIENES_VER')->name('bienes.index');
            Route::post('/', [BienController::class, 'store'])->middleware('permission:BIENES_CREAR')->name('bienes.store');
            Route::put('/{id}', [BienController::class, 'update'])->middleware('permission:BIENES_EDITAR')->name('bienes.update');
            Route::get('filtro', [BienController::class, 'findByNameOrCode'])
                ->middleware('permission:BIENES_VER|REPORTES_CREAR')
                ->name('bienes.findByNameOrCode');
        });

        // Tipos de bienes
        Route::prefix('tipos-bienes')->group(function () {
            Route::get('/', [TipoBienController::class, 'index'])->middleware('permission:TIPOS_BIENES_VER')->name('tiposBienes.index');
            Route::post('/', [TipoBienController::class, 'store'])->middleware('permission:TIPOS_BIENES_CREAR')->name('tiposBienes.store');
            Route::put('/{id}', [TipoBienController::class, 'update'])->middleware('permission:TIPOS_BIENES_EDITAR')->name('tiposBienes.update');
        });
    });

    /* ****************************************** */
    /*   ************* SEGURIDAD ************   */
    /* ****************************************** */
    Route::prefix('seguridad')->group(function () {

        // Rutas para los roles
        Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:ROLES_VER')->name('roles.index');
        Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:ROLES_CREAR')->name('roles.store');
        Route::get('/roles/create', [RoleController::class, 'create'])->middleware('permission:ROLES_CREAR')->name('roles.create');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:ROLES_EDITAR')->name('roles.update');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:ROLES_EDITAR')->name('roles.edit');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->middleware('permission:ROLES_VER')->name('roles.show');

        // Rutas para los usuarios
        Route::get('/usuarios', [UsuarioController::class, 'index'])->middleware('permission:USUARIOS_VER')->name('usuarios.index');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->middleware('permission:USUARIOS_CREAR')->name('usuarios.store');
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->middleware('permission:USUARIOS_CREAR')->name('usuarios.create');
        Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])->middleware('permission:USUARIOS_VER')->name('usuarios.show');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->middleware('permission:USUARIOS_EDITAR')->name('usuarios.update');
        Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->middleware('permission:USUARIOS_EDITAR')->name('usuarios.edit');
    });


    /* ****************************************** */
    /*   ************* RHU ************   */
    /* ****************************************** */
    Route::prefix('recursos-humanos')->group(function () {
        // Rutas de entidades
        Route::prefix('entidades')->group(function () {
            Route::get('/', [EntidadesController::class, 'index'])->middleware('permission:ENTIDADES_VER')->name('entidades.index');
            Route::post('/', [EntidadesController::class, 'store'])->middleware('permission:ENTIDADES_CREAR')->name('entidades.store');
            Route::put('/{id}', [EntidadesController::class, 'update'])->middleware('permission:ENTIDADES_EDITAR')->name('entidades.update');
        });
        // Puestos
        Route::get('/puestos', [PuestoController::class, 'index'])->name('puestos.index');
        Route::resource('puestos', PuestoController::class)->except(['destroy']);
        Route::patch('puestos/{puesto}/toggle', [PuestoController::class, 'toggleActivo'])->name('puestos.toggleActivo');
        // Empleados Puestos
        Route::get('/empleados', [EmpleadoPuestoController::class, 'index'])->middleware('permission:EMPLEADOS_VER')->name('empleadosPuestos.index');
        Route::post('/empleados-puestos', [EmpleadoPuestoController::class, 'store'])->middleware('permission:EMPLEADOS_CREAR')->name('empleadosPuestos.store');
        Route::put('/empleados-puestos/{id}', [EmpleadoPuestoController::class, 'update'])->middleware('permission:EMPLEADOS_EDITAR')->name('empleadosPuestos.update');
        Route::get('/empleados-puestos/{id}', [EmpleadoPuestoController::class, 'show'])->middleware('permission:EMPLEADOS_VER')->name('empleadosPuestos.show');
        // Route::get('/busqueda-por-nombre/{id_entidad}', [EmpleadoPuestoController::class, 'buscarPorNombre'])->middleware('permission:ENTIDADES_EDITAR')->name('empleadosPuestos.buscarPorNombre');
        // Route::get('/busqueda-supervisor-por-nombre', [EmpleadoPuestoController::class, 'buscarSupervisorPorNombre'])->middleware('permission:ENTIDADES_EDITAR')->name('empleadosPuestos.buscarSupervisorPorNombre');
    });

    Route::prefix('bitacora')->group(function () {
        Route::get('/', [UserAuditController::class, 'index'])->middleware('permission:BITACORA_VER')->name('general.index');
        Route::get('/get-events', [UserAuditController::class, 'getEvents'])->middleware('permission:BITACORA_VER');
    });

    Route::prefix('estadisticas')->group(function () {
        Route::get('/', [EstadisticasController::class, 'index'])->middleware('permission:BITACORA_VER')->name('estadisticas.index');
    });
});


require __DIR__ . '/auth.php';
