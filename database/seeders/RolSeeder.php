<?php

namespace Database\Seeders;

use App\Enums\PermisosEnum;
use Illuminate\Database\Seeder;
use App\Enums\RolesEnum;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $rolePermissions = [
            'SUPERADMIN' => [],
            'ADMIN_REPORTE' => [
                PermisosEnum::REPORTES_CREAR->value,
                PermisosEnum::REPORTES_ASIGNAR->value,
                PermisosEnum::REPORTES_ACTUALIZAR_ESTADO->value,
                PermisosEnum::REPORTES_VER_LISTADO_GENERAL->value,
                PermisosEnum::REPORTES_VER_ASIGNACIONES->value,
                PermisosEnum::REPORTES_REVISION_SOLUCION->value,
                PermisosEnum::ACTIVIDADES_CREAR_REPORTE->value,
                PermisosEnum::RECURSOS_VER->value,
                PermisosEnum::RECURSOS_CREAR->value,
                PermisosEnum::RECURSOS_EDITAR->value,
                PermisosEnum::UNIDADES_MEDIDA_VER->value,
                PermisosEnum::UNIDADES_MEDIDA_CREAR->value,
                PermisosEnum::UNIDADES_MEDIDA_EDITAR->value,
                PermisosEnum::CLASES_VER->value,
                PermisosEnum::EVENTOS_VER->value,
                PermisosEnum::BIENES_VER->value,
                PermisosEnum::BIENES_CREAR->value,
                PermisosEnum::BIENES_EDITAR->value,
                PermisosEnum::FONDOS_VER->value,
                PermisosEnum::FONDOS_CREAR->value,
                PermisosEnum::FONDOS_EDITAR->value,
            ],
            'SUPERVISOR_REPORTE' => [
                PermisosEnum::REPORTES_CREAR->value,
                PermisosEnum::REPORTES_ACTUALIZAR_ESTADO->value,
                PermisosEnum::REPORTES_VER_LISTADO_GENERAL->value,
                PermisosEnum::REPORTES_VER_ASIGNACIONES->value,
                PermisosEnum::REPORTES_REVISION_SOLUCION->value,
                PermisosEnum::ACTIVIDADES_CREAR_REPORTE->value,
                PermisosEnum::RECURSOS_VER->value,
                PermisosEnum::RECURSOS_CREAR->value,
                PermisosEnum::RECURSOS_EDITAR->value,
                PermisosEnum::UNIDADES_MEDIDA_VER->value,
                PermisosEnum::UNIDADES_MEDIDA_CREAR->value,
                PermisosEnum::UNIDADES_MEDIDA_EDITAR->value,
                PermisosEnum::CLASES_VER->value,
                PermisosEnum::EVENTOS_VER->value,
                PermisosEnum::BIENES_VER->value,
                PermisosEnum::BIENES_CREAR->value,
                PermisosEnum::BIENES_EDITAR->value,
            ],
            'EMPLEADO' => [
                PermisosEnum::REPORTES_CREAR->value,
                PermisosEnum::REPORTES_ACTUALIZAR_ESTADO->value,
                PermisosEnum::REPORTES_VER_LISTADO_GENERAL->value,
                PermisosEnum::REPORTES_VER_ASIGNACIONES->value,
                PermisosEnum::ACTIVIDADES_CREAR_REPORTE->value,
                PermisosEnum::RECURSOS_VER->value,
                PermisosEnum::CLASES_VER->value,
                PermisosEnum::EVENTOS_VER->value,
                PermisosEnum::BIENES_VER->value

            ],
            'USUARIO' => [
                PermisosEnum::REPORTES_CREAR->value,
                PermisosEnum::REPORTES_VER_LISTADO_GENERAL->value,
                PermisosEnum::ACTIVIDADES_CREAR_REPORTE->value,
                PermisosEnum::CLASES_VER->value,
                PermisosEnum::EVENTOS_VER->value,
            ]
        ];
        foreach (RolesEnum::cases() as $rol) {
            $role = Role::firstOrCreate(['name' => $rol->value]);
            if ($rolePermissions[$rol->name]) {
                $role->syncPermissions($rolePermissions[$rol->name]);
            }
        }
    }
}
