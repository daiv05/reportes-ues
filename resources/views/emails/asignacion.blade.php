<x-emails.email-container>
    <x-emails.email-body>
        <x-emails.email-header />
        <p>
            Estimado usuario, ha sido asignado {{ $tableData['esSupervisor'] ? 'como SUPERVISOR' : '' }} para darle
            seguimiento al reporte
            <strong>#{{ $tableData['reporte']->id }}</strong>
            :
        </p>
        <table style="width: 100%; border-collapse: collapse; table-layout: fixed">
            <tr>
                <th style="padding: 10px; text-align: left; width: 30%">Reporte</th>
                <td style="padding: 10px">{{ $tableData['reporte']->titulo }}</td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Asignado por</th>
                <td style="padding: 10px">
                    {{ $tableData['reporte']->accionesReporte->usuarioAdministracion->persona->nombre . ' ' . $tableData['reporte']->accionesReporte->usuarioAdministracion->persona->apellido }}
                </td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Entidad</th>
                <td style="padding: 10px">{{ $tableData['reporte']->accionesReporte->entidadAsignada->nombre }}</td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Fecha de Asignación</th>
                <td style="padding: 10px">
                    {{ \Carbon\Carbon::parse($tableData['reporte']->accionesReporte->fecha_asignacion)->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Hora Asignada</th>
                <td style="padding: 10px">
                    {{ \Carbon\Carbon::parse($tableData['reporte']->accionesReporte->hora_inicio)->format('h:i A') }}
                </td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Supervisor</th>
                <td style="padding: 10px">
                    {{ $tableData['reporte']->accionesReporte->usuarioSupervisor->persona->nombre . ' ' . $tableData['reporte']->accionesReporte->usuarioSupervisor->persona->apellido }}
                </td>
            </tr>
        </table>
        <p>
            Puede consultar los detalles del reporte aquí:
            <a href="{{ config('app.url') . '/reportes/detalle/' . $tableData['reporte']->id }}" target="_blank"
                class="text-red-ues">#{{ $tableData['reporte']->id }}</a>
        </p>
    </x-emails.email-body>

    <x-emails.email-footer />
</x-emails.email-container>
