<x-emails.email-container>
    <x-emails.email-header
        logoSrc="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3JjWq5hKtAVSofTTo72ynt7SlCxi2G6WXmA&s" />
    <!-- Mensaje -->
    <p>Estimado usuario, ha sido asignado para darle seguimiento al reporte
        <strong>#201</strong> para realizar el seguimiento correspondiente:
    </p>
    <x-emails.email-body>
        <table>
            <tr>
                <th>Reporte</th>
                <td>Reporte #12345</td>
            </tr>
            <tr>
                <th>Asignado por</th>
                <td>Juan Pérez</td>
            </tr>
            <tr>
                <th>Departamento</th>
                <td>Innovación y Tecnología</td>
            </tr>
            <tr>
                <th>Fecha de Asignación</th>
                <td>10 de noviembre de 2024</td>
            </tr>
            <tr>
                <th>Hora Asignada</th>
                <td>10:00 AM</td>
            </tr>
            <tr>
                <th>Supervisor</th>
                <td>Maria Rodríguez</td>
            </tr>
        </table>

        <p>Puede consultar los detalles del reporte aquí: <a href="URL_DE_DETALLES" class="text-red-600">Detalles del
                reporte</a></p>
    </x-emails.email-body>

    <x-emails.email-footer :footerLinks="[
        ['label' => 'Página oficial', 'url' => 'https://www.ues.edu.sv'],
        ['label' => 'Contacto', 'url' => 'https://www.ues.edu.sv/contacto/'],
        ['label' => 'Noticias', 'url' => 'https://www.ues.edu.sv/noticias/'],
    ]" />
</x-emails.email-container>
