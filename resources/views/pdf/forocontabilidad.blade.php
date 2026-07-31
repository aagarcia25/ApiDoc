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
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .title {
            font-size: 32px;
            color: #5A9FAC;
            font-weight: bold;
        }

        .subtitle {
            font-size: 26px;
            font-weight: bold;
        }

        .text {
            font-size: 21px;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            color: #111;
        }

        .event {
            font-size: 24px;
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

        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:0px;">
            <tr>
                <td width="25%" align="left" style="padding-left:35px; padding-top: 25px;">
                    <img src="{{ public_path('images/CEACNL.png') }}" height="70">
                </td>
                <td width="50%" align="center">
                    <img src="{{ public_path('images/fondo.png') }}" height="105">
                </td>
                <td width="25%" align="right" style="padding-right:35px; padding-top: 25px;">
                    <img src="{{ public_path('images/logo_estado_vertical.png') }}" height="70">
                </td>
            </tr>
        </table>

        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:25px;">
            <tr>
                <td height="20"></td>
            </tr>
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
                <td align="center" style="font-size:26px;">
                    otorga el presente
                </td>
            </tr>
            <tr>
                <td height="5"></td>
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

                    <table width="620" cellspacing="0" cellpadding="0" align="center"
                        style="margin-left:auto; margin-right:auto;">
                        <tr>

                            <td width="45"
                                style="
                        font-size:24px;
                        text-align:left;
                    ">
                                A:
                            </td>

                            <td
                                style="
                        border-bottom:2px solid #5A9FAC;
                        text-align:center;
                        font-size:25px;
                        font-weight:bold;
                    ">
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
            <tr>
                <td height="30"></td>
            </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>

                <td width="200" valign="bottom" style="padding-left:30px;">
                    <img src="data:image/png;base64,{{ $qr }}" width="100" height="100">
                </td>

                <td></td>
                <td></td>



            </tr>
            <tr>
                <td style="padding-left:30px; font-size:12px;">{{ $registro->id }}</td>
                <td></td>
                <td width="350" align="right" valign="bottom"
                    style="
                    font-size:12px;
                    padding-right:30px;
                ">
                    Ciudad Universitaria, Nuevo León, 25 de septiembre de 2026
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
