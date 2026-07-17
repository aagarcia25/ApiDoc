<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            background: #fff;
        }

        .page {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .content {
            position: absolute;
            top: 90px;
            left: 80px;
            right: 80px;
            bottom: 80px;
            text-align: center;
        }

        .titulo {
            font-size: 22px;
            color: #555;
            margin-top: 20px;
        }

        .constancia {
            font-size: 52px;
            font-weight: bold;
            color: #0a5b7d;
            letter-spacing: 2px;
            margin: 20px 0;
        }

        .nombre {
            font-size: 32px;
            color: #1d3f66;
            margin: 35px 0;
        }

        .evento {
            font-size: 24px;
            font-weight: bold;
            color: #0a5b7d;
        }

        .texto {
            font-size: 18px;
            color: #444;
            line-height: 30px;
        }

        .qr {
            position: absolute;
            right: 70px;
            top: 140px;
            width: 170px;
            text-align: center;
        }

        .firmas {
            position: absolute;
            left: 80px;
            right: 80px;
            bottom: 70px;
        }

        .firma {
            width: 45%;
            display: inline-block;
            text-align: center;
        }

        .linea {
            border-top: 1px solid #000;
            margin-bottom: 8px;
        }
    </style>

</head>

<body>

    <div class="page">

        {{-- Si tienes una plantilla de fondo --}}
        {{-- <img src="{{ public_path('img/certificado.png') }}" style="position:absolute;width:100%;height:100%;"> --}}

        <div class="content">

            <div class="titulo">
                EL CONSEJO ESTATAL DE ARMONIZACIÓN CONTABLE<br>
                DEL ESTADO DE NUEVO LEÓN
            </div>

            <div style="margin-top:15px;">
                OTORGA LA PRESENTE
            </div>

            <div class="constancia">
                CONSTANCIA
            </div>

            <div>
                A
            </div>

            <div class="nombre">
                {{ strtoupper($registro->nombre) }}
                {{ strtoupper($registro->apellido_paterno) }}
                {{ strtoupper($registro->apellido_materno) }}
            </div>

            <div class="texto">
                Por su asistencia al
            </div>

            <div class="evento">
                Jornada de Auditoría y Contabilidad Gubernamental
            </div>

            <div class="texto">
                realizado los días 24 y 25 de septiembre de 2026.
            </div>

            <div class="texto">
                Monterrey, Nuevo León<br>
                25 de septiembre de 2026
            </div>

        </div>

        <div class="qr">

            {!! QrCode::format('svg')->size(160)->generate('https://tesoreriavirtual.nl.gob.mx/foro-contabilidad/constancia/' . $registro->id) !!}

            <div style="font-size:10px;margin-top:10px;">
                Validación de constancia
            </div>

        </div>

        <div class="firmas">

            <div class="firma">
                <div class="linea"></div>
                <strong>C.P. Carlos Alberto Garza Ibarra</strong><br>
                Secretario de Finanzas y<br>
                Tesorero General del Estado
            </div>

            <div class="firma" style="float:right;">
                <div class="linea"></div>
                <strong>C.P. Jorge Guadalupe Galván González</strong><br>
                Director de Contabilidad Gubernamental
            </div>

        </div>

    </div>

</body>

</html>
