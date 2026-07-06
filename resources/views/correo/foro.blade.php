<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro - Foro Estatal de Contabilidad Gubernamental</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:8px;overflow:hidden;">

                    <!-- Encabezado -->
                    <tr>
                        <td align="center" style="background:#0b4a7d;padding:25px;color:#ffffff;">

                            <h2 style="margin:0;">
                                Foro Estatal de Contabilidad Gubernamental
                            </h2>

                            <p style="margin:8px 0 0 0;">
                                Confirmación de registro
                            </p>

                        </td>
                    </tr>

                    <!-- Contenido -->
                    <tr>
                        <td style="padding:30px;">

                            <p>
                                Estimado(a)
                                <strong>
                                    {{ $nombre }}
                                    {{ $apellido_paterno }}
                                    {{ $apellido_materno }}
                                </strong>,
                            </p>

                            <p>
                                Su registro se realizó correctamente.
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse;margin-top:20px;">

                                <tr style="background:#f4f4f4;">
                                    <td><strong>Nombre</strong></td>
                                    <td>{{ $nombre }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Apellido paterno</strong></td>
                                    <td>{{ $apellido_paterno }}</td>
                                </tr>

                                <tr style="background:#f4f4f4;">
                                    <td><strong>Apellido materno</strong></td>
                                    <td>{{ $apellido_materno }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Cargo</strong></td>
                                    <td>{{ $cargo }}</td>
                                </tr>

                                <tr style="background:#f4f4f4;">
                                    <td><strong>Ente</strong></td>
                                    <td>{{ $ente }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Correo</strong></td>
                                    <td>{{ $correo }}</td>
                                </tr>

                                <tr style="background:#f4f4f4;">
                                    <td><strong>Teléfono</strong></td>
                                    <td>{{ $telefono }}</td>
                                </tr>

                            </table>

                            <br>

                            <h3 style="text-align:center;color:#0b4a7d;">
                                Código QR de acceso
                            </h3>

                            <p style="text-align:center;">
                                Presente este código al ingresar al evento.
                            </p>

                            <div style="text-align:center;margin:20px 0;">

                                {!! QrCode::size(260)->margin(1)->generate('https://tesoreriavirtual.nl.gob.mx/foro-contabilidad/acceso/' . $id) !!}

                            </div>

                            <hr style="margin:35px 0;">

                            <p>
                                Una vez concluido el foro y registradas sus asistencias de
                                <strong>jueves y viernes</strong>, podrá descargar su
                                constancia desde el siguiente enlace:
                            </p>

                            <p style="text-align:center;">

                                <a href="https://tesoreriavirtual.nl.gob.mx/foro-contabilidad/constancia/{{ $id }}"
                                    style="background:#0b4a7d;
                                      color:#ffffff;
                                      padding:12px 20px;
                                      text-decoration:none;
                                      border-radius:5px;
                                      display:inline-block;">

                                    Descargar constancia

                                </a>

                            </p>

                            <p style="margin-top:30px;">
                                <strong>Importante:</strong><br>
                                Conserve este correo. El código QR será utilizado para registrar
                                su asistencia al evento.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#f2f2f2;padding:20px;font-size:12px;color:#666;">


                            Este es un mensaje automático. Favor de no responder este correo.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
