<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SUPERADMIN = 'ROLE_USUARIO_SUPER_ADMIN';
    case ENCARGADO_REPORTE = 'ROLE_USUARIO_ENCARGADO_REPORTE';
    case EMPLEADO = 'ROLE_USUARIO_EMPLEADO';
    case USUARIO = 'ROLE_USUARIO_BASE';
}
