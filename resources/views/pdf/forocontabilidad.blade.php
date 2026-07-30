<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">

    <style>
        @page {
            size: letter landscape;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
        }

        .page {
            width: 1056px;
            height: 816px;
            position: relative;
            overflow: hidden;
        }

        .title {
            font-size: 42px;
            color: #5A9FAC;
            font-weight: bold;
        }

        .subtitle {
            font-size: 31px;
            font-weight: bold;
        }

        .text {
            font-size: 24px;
        }

        .name {
            font-size: 34px;
            font-weight: bold;
            color: #111;
        }

        .event {
            font-size: 30px;
            color: #5A9FAC;
            font-weight: bold;
        }

        .date {
            font-size: 22px;
        }
    </style>

</head>

<body>

    <div class="page">

        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:25px;">
            <tr>

                <td width="25%" align="left" style="padding-left:35px;">
                    <img src="{{ public_path('images/CEACNL.png') }}" width="180">
                </td>

                <td width="50%" align="center">
                    <img src="{{ public_path('images/fondo.png') }}" width="330">
                </td>

                <td width="25%" align="right" style="padding-right:35px;">
                    <img src="{{ public_path('images/logo_estado_vertical.png') }}" width="110">
                </td>

            </tr>
        </table>

        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:25px;">

            <tr>
                <td align="center" class="subtitle">
                    EL CONSEJO ESTATAL DE ARMONIZACIÓN CONTABLE
                </td>
            </tr>

            <tr>
                <td align="center" class="subtitle">
                    DEL ESTADO DE NUEVO LEÓN
                </td>
            </tr>

            <tr>
                <td height="30"></td>
            </tr>

            <tr>
                <td align="center" style="font-size:26px;">
                    otorga el presente
                </td>
            </tr>

            <tr>
                <td height="25"></td>
            </tr>

            <tr>
                <td align="center" class="title">
                    RECONOCIMIENTO
                </td>
            </tr>

            <tr>
                <td height="40"></td>
            </tr>

            <tr>
                <td align="center">

                    <table width="820" cellspacing="0" cellpadding="0">

                        <tr>

                            <td width="45" style="font-size:24px;">
                                A:
                            </td>

                            <td style="border-bottom:4px solid #5A9FAC;"></td>

                        </tr>

                        <tr>

                            <td></td>

                            <td align="center" class="name" style="padding-top:12px;">

                                {{ ucwords(
                                    mb_strtolower(
                                        trim($registro->nombre . ' ' . $registro->apellido_paterno . ' ' . $registro->apellido_materno),
                                        'UTF-8',
                                    ),
                                ) }}

                            </td>

                        </tr>

                    </table>

                </td>
            </tr>

            <tr>
                <td height="30"></td>
            </tr>

            <tr>
                <td align="center" class="text">
                    Por su asistencia a la
                </td>
            </tr>

            <tr>
                <td align="center" class="event">
                    Jornada de Auditoría y Contabilidad Gubernamental
                </td>
            </tr>

            <tr>
                <td align="center" class="date">
                    realizada el 24 y 25 de septiembre del 2026.
                </td>
            </tr>

        </table>
        <table width="100%" cellspacing="0" cellpadding="0"
            style="position:absolute;left:35px;bottom:35px;width:986px;">
            <tr>
                <td width="180" valign="bottom">
                    <img src="data:image/png;base64,{{ $qr }}" width="130" height="130">
                </td>
                <td></td>
                <td width="350" align="right" style="font-size:18px;">
                    Ciudad Universitaria, Nuevo León<br>
                    25 de septiembre de 2026
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
