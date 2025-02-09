<?php

namespace App\Enums;

enum PermisosEnum: string
{
    case REPORTES_CREAR = 'REPORTES_CREAR';
    case REPORTES_ASIGNAR = 'REPORTES_ASIGNAR';
    case REPORTES_ACTUALIZAR_ESTADO = 'REPORTES_ACTUALIZAR_ESTADO';
    case REPORTES_VER_LISTADO_GENERAL = 'REPORTES_VER_LISTADO_GENERAL';
    case REPORTES_REVISION_SOLUCION = 'REPORTES_REVISION_SOLUCION';
    case REPORTES_VER_ASIGNACIONES = 'REPORTES_VER_ASIGNACIONES';
    case USUARIOS_VER = 'USUARIOS_VER';
    case USUARIOS_CREAR = 'USUARIOS_CREAR';
    case USUARIOS_EDITAR = 'USUARIOS_EDITAR';
    case ESCUELAS_VER = 'ESCUELAS_VER';
    case ESCUELAS_CREAR = 'ESCUELAS_CREAR';
    case ESCUELAS_EDITAR = 'ESCUELAS_EDITAR';
    case ASIGNATURAS_VER = 'ASIGNATURAS_VER';
    case ASIGNATURAS_CREAR = 'ASIGNATURAS_CREAR';
    case ASIGNATURAS_EDITAR = 'ASIGNATURAS_EDITAR';
    case AULAS_VER = 'AULAS_VER';
    case AULAS_CREAR = 'AULAS_CREAR';
    case AULAS_EDITAR = 'AULAS_EDITAR';
    case CICLOS_VER = 'CICLOS_VER';
    case CICLOS_CREAR = 'CICLOS_CREAR';
    case CICLOS_EDITAR = 'CICLOS_EDITAR';
    case BITACORA_VER = 'BITACORA_VER';
    case ENTIDADES_VER = 'ENTIDADES_VER';
    case ENTIDADES_CREAR = 'ENTIDADES_CREAR';
    case ENTIDADES_EDITAR = 'ENTIDADES_EDITAR';
    case PUESTOS_VER = 'PUESTOS_VER';
    case PUESTOS_CREAR = 'PUESTOS_CREAR';
    case PUESTOS_EDITAR = 'PUESTOS_EDITAR';
    case EMPLEADOS_VER = 'EMPLEADOS_VER';
    case EMPLEADOS_CREAR = 'EMPLEADOS_CREAR';
    case EMPLEADOS_EDITAR = 'EMPLEADOS_EDITAR';
    case CLASES_VER = 'CLASES_VER';
    case CLASES_CREAR = 'CLASES_CREAR';
    case CLASES_EDITAR = 'CLASES_EDITAR';
    case EVENTOS_VER = 'EVENTOS_VER';
    case EVENTOS_CREAR = 'EVENTOS_CREAR';
    case EVENTOS_EDITAR = 'EVENTOS_EDITAR';
    case ACTIVIDADES_CARGA_EXCEL = 'ACTIVIDADES_CARGA_EXCEL';
    case RECURSOS_VER = 'RECURSOS_VER';
    case RECURSOS_CREAR = 'RECURSOS_CREAR';
    case RECURSOS_EDITAR = 'RECURSOS_EDITAR';
    case UNIDADES_MEDIDA_VER = 'UNIDADES_MEDIDA_VER';
    case UNIDADES_MEDIDA_CREAR = 'UNIDADES_MEDIDA_CREAR';
    case UNIDADES_MEDIDA_EDITAR = 'UNIDADES_MEDIDA_EDITAR';
    case ACTIVIDADES_CREAR_REPORTE = 'ACTIVIDADES_CREAR_REPORTE';
    case ASIGNATURAS_SUBIR_EXCEL = 'ASIGNATURAS_SUBIR_EXCEL';
    case BIENES_VER = 'BIENES_VER';
    case BIENES_CREAR = 'BIENES_CREAR';
    case BIENES_EDITAR = 'BIENES_EDITAR';
    case TIPOS_BIENES_VER = 'TIPOS_BIENES_VER';
    case TIPOS_BIENES_CREAR = 'TIPOS_BIENES_CREAR';
    case TIPOS_BIENES_EDITAR = 'TIPOS_BIENES_EDITAR';
    case ASIGNAR_PUESTOS_EMPLEADOS = 'ASIGNAR_PUESTOS_EMPLEADOS';
    case EDITAR_PUESTOS_EMPLEADOS = 'EDITAR_PUESTOS_EMPLEADOS';
    case VER_PUESTOS_EMPLEADOS='VER_PUESTOS_EMPLEADOS';
    case ROLES_VER = 'ROLES_VER';
    case ROLES_CREAR = 'ROLES_CREAR';
    case ROLES_EDITAR = 'ROLES_EDITAR';
    case FORMATOS_DESCARGAR = 'FORMATOS_DESCARGAR';
    case DESCARGAR_IMPORTACION_ACTIVIDADES = 'DESCARGAR_IMPORTACION_ACTIVIDADES';
    case DESCARGAR_BIENES = 'DESCARGAR_BIENES';
    case DESCARGAR_RECURSOS = 'DESCARGAR_RECURSOS';
    case DESCARGAR_ASIGNATURAS = 'DESCARGAR_ASIGNATURAS';
    case DESCARGAR_CLASES = 'DESCARGAR_CLASES';
    case DESCARGAR_EMPLEADOS = 'DESCARGAR_EMPLEADOS';
    case DESCARGAR_LOCALES = 'DESCARGAR_LOCALES';
    case FONDOS_VER = 'FONDOS_VER';
    case FONDOS_CREAR = 'FONDOS_CREAR';
    case FONDOS_EDITAR = 'FONDOS_EDITAR';

}
