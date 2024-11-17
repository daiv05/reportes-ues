<x-emails.email-container>
    <x-emails.email-body>
        <x-emails.email-header
            logoSrc="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3JjWq5hKtAVSofTTo72ynt7SlCxi2G6WXmA&s"
        />
        <!-- Mensaje -->
        <p>
            Estimado usuario, el reporte al que fue asignado, con codigo:
            <strong>#{{ $tableData['reporte']->id }}</strong>
            ha sido actualizado a:
        </p>
        <x-status.chips :text="$reporte->estado_ultimo_historial->nombre" class="mb-2" />
        <table style="width: 100%; border-collapse: collapse; table-layout: fixed">
            <tr>
                <th style="padding: 10px; text-align: left; width: 30%">Reporte</th>
                <td style="padding: 10px">{{ $tableData['reporte']->titulo }}</td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Asignado por</th>
                <td style="padding: 10px">
                    {{
                        $tableData['reporte']->accionesReporte->usuarioAdministracion->persona->nombre . ' ' . $tableData['reporte']->accionesReporte->usuarioAdministracion->persona->apellido
                    }}
                </td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Entidad</th>
                <td style="padding: 10px">{{ $tableData['reporte']->accionesReporte->entidadAsignada->nombre }}</td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Fecha de Asignación</th>
                <td style="padding: 10px">{{ $tableData['reporte']->accionesReporte->fecha_asignacion }}</td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Hora Asignada</th>
                <td style="padding: 10px">{{ $tableData['reporte']->accionesReporte->hora_inicio }}</td>
            </tr>
            <tr>
                <th style="padding: 10px; text-align: left">Supervisor</th>
                <td style="padding: 10px">
                    {{
                        $tableData['reporte']->accionesReporte->usuarioSupervisor->persona->nombre . ' ' . $tableData['reporte']->accionesReporte->usuarioSupervisor->persona->apellido
                    }}
                </td>
            </tr>
        </table>

        <p>
            Puede consultar los detalles del reporte aquí:
            <a href="URL_DE_DETALLES" class="text-red-600">Detalles del reporte</a>
        </p>
    </x-emails.email-body>

    <x-emails.email-footer
        :footerLinks="[
            ['label' => 'Página oficial', 'url' => 'https://www.ues.edu.sv'],
            ['label' => 'Contacto', 'url' => 'https://www.ues.edu.sv/contacto/'],
            ['label' => 'Noticias', 'url' => 'https://www.ues.edu.sv/noticias/'],
        ]"
    />
</x-emails.email-container>