<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro Exitoso - Taller de Integración de Estados Financieros</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">

    <p>
        Estimado(a) {{ $nombre }} {{ $aPaterno }} {{ $aMaterno }},
    </p>

    <p>
        Su registro para el <strong>Taller de Integración de Estados Financieros</strong>
        se ha completado correctamente. A continuación, se muestran los datos capturados:
    </p>

    <table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse;">
        <tr>
            <td><strong>Nombre</strong></td>
            <td>{{ $nombre }}</td>
        </tr>
        <tr>
            <td><strong>Apellido Paterno</strong></td>
            <td>{{ $aPaterno }}</td>
        </tr>
        <tr>
            <td><strong>Apellido Materno</strong></td>
            <td>{{ $aMaterno }}</td>
        </tr>
        <tr>
            <td><strong>Cargo</strong></td>
            <td>{{ $cargo }}</td>
        </tr>
        <tr>
            <td><strong>Ente</strong></td>
            <td>{{ $ente }}</td>
        </tr>
        <tr>
            <td><strong>Correo Electrónico</strong></td>
            <td>{{ $correo }}</td>
        </tr>
        <tr>
            <td><strong>Teléfono</strong></td>
            <td>{{ $telefono }}</td>
        </tr>
    </table>

    <br>

    <p>
        <strong>Nota importante:</strong><br>
        Le recomendamos llegar con tiempo, ya que el recinto no cuenta con estacionamiento.
        Se pueden utilizar estacionamientos aledaños sujetos a disponibilidad.
    </p>

    <br>

    <p>
        <strong>Taller de Integración de Estados Financieros</strong>
    </p>

    <p style="font-size: 12px; color: #555;">
        Este es un mensaje automático, por favor no responda este correo.
    </p>

</body>

</html>
