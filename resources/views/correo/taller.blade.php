<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro Exitoso - Taller de Integración de Estados Financieros</title>
</head>

<body
    style="font-family: Arial, sans-serif; font-size: 14px; color: #000; background-color: #f4f6f8; margin: 0; padding: 0;">

    <!-- Contenedor principal -->
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 30px 0;">
        <tr>
            <td align="center">

                <!-- Caja blanca -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

                    <tr>
                        <td>

                            <p style="margin-top: 0;">
                                Estimado(a) {{ $nombre }} {{ $aPaterno }} {{ $aMaterno }},
                            </p>

                            <p>
                                Su registro para el
                                <strong style="color: #0097b2;">Taller de Integración de Estados Financieros</strong>
                                se ha completado correctamente. A continuación, se muestran los datos capturados:
                            </p>

                            <!-- Tabla -->
                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse: collapse; margin: 20px 0;">

                                <tr style="background-color: #f0f8fa;">
                                    <td style="border: 1px solid #ddd;"><strong>Nombre</strong></td>
                                    <td style="border: 1px solid #ddd;">{{ $nombre }}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;"><strong>Apellido Paterno</strong></td>
                                    <td style="border: 1px solid #ddd;">{{ $aPaterno }}</td>
                                </tr>
                                <tr style="background-color: #f0f8fa;">
                                    <td style="border: 1px solid #ddd;"><strong>Apellido Materno</strong></td>
                                    <td style="border: 1px solid #ddd;">{{ $aMaterno }}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;"><strong>Cargo</strong></td>
                                    <td style="border: 1px solid #ddd;">{{ $cargo }}</td>
                                </tr>
                                <tr style="background-color: #f0f8fa;">
                                    <td style="border: 1px solid #ddd;"><strong>Ente</strong></td>
                                    <td style="border: 1px solid #ddd;">{{ $ente }}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;"><strong>Correo Electrónico</strong></td>
                                    <td style="border: 1px solid #ddd;">{{ $correo }}</td>
                                </tr>
                                <tr style="background-color: #f0f8fa;">
                                    <td style="border: 1px solid #ddd;"><strong>Teléfono</strong></td>
                                    <td style="border: 1px solid #ddd;">{{ $telefono }}</td>
                                </tr>
                            </table>

                            <p>
                                <strong style="color: #0097b2;">Nota importante:</strong><br>
                                Le recomendamos llegar con tiempo, ya que el recinto no cuenta con estacionamiento.
                                Se pueden utilizar estacionamientos aledaños sujetos a disponibilidad.
                            </p>

                            <p style="margin-bottom: 0;">
                                <strong style="color: #0097b2;">Taller de Integración de Estados Financieros</strong>
                            </p>

                        </td>
                    </tr>
                </table>

                <!-- Footer -->
                <table width="600" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="padding-top: 15px;">
                            <p style="font-size: 12px; color: #555; margin: 0;">
                                Este es un mensaje automático, por favor no responda este correo.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>
