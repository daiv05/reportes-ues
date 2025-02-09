<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SUPERADMIN = 'SUPERADMIN';
    case ADMIN_REPORTE = 'ADMINISTRADOR DE REPORTES';
    case SUPERVISOR_REPORTE = 'SUPERVISOR';
    case EMPLEADO = 'EMPLEADO';
    case USUARIO = 'USUARIO';
}
