<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo contacto</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px;">

    <h2>Nuevo registro t</h2>

    <table cellpadding="6" cellspacing="0" border="1" width="100%">
        <tr>
            <td><strong>Nombre completo</strong></td>
            <td>
                {{ $nombre }} {{ $aPaterno }} {{ $aMaterno }}
            </td>
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
            <td><strong>Correo</strong></td>
            <td>{{ $correo }}</td>
        </tr>

        <tr>
            <td><strong>Teléfono</strong></td>
            <td>{{ $telefono }}</td>
        </tr>
    </table>

</body>

</html>
