<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correo Electrónico - Asignación de Reporte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px; /* Ajustar según el tamaño que desees */
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin: 0 0 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        a {
            color: #d32f2f; /* Rojo de la UES */
            text-decoration: none;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombra para el cuadro */
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            font-weight: bold;
            color: #d32f2f; /* Rojo de la UES */
            border-bottom: 2px solid #ddd; /* Línea abajo de los encabezados */
            text-transform: uppercase; /* Todo en mayúsculas para mayor formalidad */
        }

        td {
            font-weight: normal;
            color: #555;
            border-bottom: 1px solid #ddd; /* Línea abajo de las celdas */
        }

        td:first-child {
            font-weight: bold; /* Negrita solo para las celdas de la izquierda */
        }

        /* Fila alternada para mayor legibilidad */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .footer a {
            color: #d32f2f; /* Rojo de la UES */
            margin: 0 10px;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="container">
        <!-- Logo -->
        <div class="header">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3JjWq5hKtAVSofTTo72ynt7SlCxi2G6WXmA&s" class="h-36" alt="Reportfia Logo" />
        </div>

        <!-- Título -->
        <h2>Asignación de Reporte</h2>

        <!-- Mensaje -->
        <p>Estimado usuario, ha sido asignado para darle seguimiento al reporte
             <strong>#201</strong> para realizar el seguimiento correspondiente:</p>

        <!-- Detalles del reporte -->
        <div class="table-container">
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
        </div>

        <!-- Enlace de más detalles -->
        <p style="font-size: 16px; color: #555;">Puede consultar los detalles del reporte aquí:
            <a href="URL_DE_DETALLES">Detalles del reporte</a>
        </p>

        <!-- Firma -->
        <div style="text-align: center; margin-top: 20px; color: #555;">
            <strong>Espacio para firma</strong>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 Universidad de El Salvador</p>
            <p>
                <a href="https://www.ues.edu.sv" target="_blank">Página oficial</a> |
                <a href="https://www.ues.edu.sv/contacto/" target="_blank">Contacto</a> |
                <a href="https://www.ues.edu.sv/noticias/" target="_blank">Noticias</a>
            </p>
        </div>
    </div>

</body>
</html>
