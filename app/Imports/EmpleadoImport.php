<?php

namespace App\Imports;

use Illuminate\Support\Str;
use App\Models\Registro\Persona;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\rhu\Puesto;
use App\Models\Seguridad\User;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmpleadoImport implements ToModel, WithHeadingRow
{
    protected $importedData = [];

    public function model(array $row)
    {
        if (!isset($row['nombres']) || !isset($row['apellidos']) || !isset($row['correo_electronico']) || !isset($row['idpuesto'])) {
            return;
        } else {
            if ($row['nombres'] == '' || $row['apellidos'] == '' || $row['correo_electronico'] == '' || $row['idpuesto'] == '') {
                return null;
            } else {
                if (User::where('email', $row['correo_electronico'])->exists()) {
                    throw new \Exception('El correo electrónico ' . $row['correo_electronico'] . ' ya está registrado en el sistema.');
                }

                if (!filter_var($row['correo_electronico'], FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception('El correo electrónico ' . $row['correo_electronico'] . ' no es válido.');
                }
                if (!Puesto::where('id', $row['idpuesto'])->exists()) {
                    throw new \Exception('El puesto con id ' . $row['idpuesto'] . ' no existe.');
                }
            }
        }

        $carnet = explode('@', $row['correo_electronico'])[0];

        if (User::where('carnet', $carnet)->exists()) {
            $carnet = $carnet . '_' . rand(1, 1000);
        }

        $persona = Persona::create([
            'nombre' => $row['nombres'],
            'apellido' => $row['apellidos'],
            'fecha_nacimiento' => isset($row['fecha_de_nacimiento']) ? Date::excelToDateTimeObject($row['fecha_de_nacimiento'])->format('Y-m-d') : null,
            'telefono' => isset($row['telefono']) ? $row['telefono'] : null,
        ]);
        $tempPass = Str::random(16);
        $usuario = User::create([
            'email' => $row['correo_electronico'],
            'carnet' => $carnet,
            'activo' => true,
            'password' => Hash::make($tempPass),
            'id_persona' => $persona->id,
            'es_estudiante' => false,
        ]);

        $usuario->assignRole('EMPLEADO');

        $empleadoPuesto = EmpleadoPuesto::create([
            'id_usuario' => $usuario->id,
            'id_puesto' => $row['idpuesto'],
            'activo' => true,
        ]);

        $this->importedData[] = [
            'usuario' => $usuario,
            'password' => $tempPass,
            'puesto' => $empleadoPuesto,
        ];
    }

    public function getData()
    {
        return $this->importedData;
    }
}
