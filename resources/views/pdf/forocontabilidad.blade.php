<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <title>Reconocimiento - Foro Estatal de Contabilidad</title>
    <style>
        @page {
            size: Letter landscape;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #e9e9e9;
            font-family: 'Quicksand', Arial, Helvetica, sans-serif;
            color: #111;
        }

        .page {
            width: 27.94cm;
            height: 21.59cm;
            margin: 0 auto;
            background: #fff;
            position: relative;
            overflow: hidden;
            padding: 1.1cm 1.8cm 1.1cm 1.8cm;
            page-break-after: always;
        }

        /* Contenedor superior dividido en 3 div */
        .header {
            display: grid;
            grid-template-columns: 1fr 1.4fr 1fr;
            align-items: start;
            width: 100%;
            height: 3.2cm;
        }

        .header-left,
        .header-center,
        .header-right {
            min-height: 3.2cm;
            position: relative;
        }

        .header-left {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
        }

        .header-right {
            display: flex;
            align-items: flex-start;
            justify-content: flex-end;
        }

        .logo-ceacnl {
            width: 4.8cm;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .logo-placeholder {
            width: 4.5cm;
            height: 2.7cm;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b6b6b;
            font-size: 10px;
            text-align: center;
        }

        .logo-placeholder.ceacnl {
            color: #11866f;
            font-weight: 700;
            font-size: 26px;
            letter-spacing: 1px;
            align-items: center;
            justify-content: flex-start;
            text-align: left;
        }

        .logo-placeholder.nl {
            color: #d97855;
            font-weight: 700;
            font-size: 18px;
            line-height: 1.15;
            text-align: center;
        }

        .logo-estado-vertical {
            width: 3cm;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .top-ribbon {
            width: 9.5cm;
            height: 2.25cm;
            margin: -1.1cm auto 0 auto;
            position: relative;
            background: linear-gradient(180deg, #4e9eab 0%, #4f98a6 100%);
            clip-path: polygon(0 0, 100% 0, 67% 65%, 50% 100%, 33% 65%);
            opacity: .95;
        }

        .top-ribbon::after {
            content: "";
            position: absolute;
            left: 1.2cm;
            right: 1.2cm;
            bottom: -0.35cm;
            height: .85cm;
            background: #527d8f;
            clip-path: polygon(0 0, 100% 0, 80% 100%, 50% 100%, 20% 100%);
            opacity: .85;
            z-index: -1;
        }

        .content {
            text-align: center;
            padding-top: 1.4cm;
        }

        .institution {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.6px;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .grant-text {
            font-size: 25px;
            font-weight: 600;
            margin-bottom: .8cm;
            margin-top: .5cm;
        }

        .title {
            font-size: 38px;
            color: #539ca8;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 1.1cm;
            text-transform: uppercase;
        }

        .recipient-row {
            display: grid;
            grid-template-columns: 1cm 1fr;
            align-items: center;
            gap: .35cm;
            width: 22.5cm;
            margin: 0 auto .15cm auto;
            text-align: left;
            font-size: 22px;
        }

        .recipient-line {
            height: .2cm;
            border-bottom: 4px solid #559da8;
            position: relative;
            top: .15cm;
        }

        .recipient-line::before,
        .recipient-line::after {
            content: "";
            position: absolute;
            bottom: -4px;
            width: 2cm;
            height: 4px;
            background: #559da8;
        }

        .recipient-line::before {
            left: -.05cm;
            clip-path: polygon(0 100%, 100% 0, 100% 100%);
        }

        .recipient-line::after {
            right: -.05cm;
            clip-path: polygon(0 0, 100% 100%, 0 100%);
        }

        .attendance {
            font-size: 25px;
            line-height: 1.35;
            margin-top: .25cm;
        }

        .event-name {
            color: #559da8;
            font-size: 30px;
            font-weight: 800;
        }

        .event-date {
            font-size: 23px;
            font-weight: 600;
        }

        /* Contenedor inferior dividido en 3 div */
        .footer {
            position: absolute;
            left: 1.8cm;
            right: 1.8cm;
            bottom: 1cm;
            display: grid;
            grid-template-columns: 5.5cm 1fr 13cm;
            align-items: end;
            min-height: 5.2cm;
        }

        .footer-image-space,
        .footer-blank-space,
        .footer-date {
            min-height: 5.2cm;
        }

        .footer-image-space {
            display: flex;
            align-items: flex-end;
            justify-content: flex-start;
        }

        .fondo-superior {
            width: 15cm;
            height: auto;
            display: block;
            margin: -1.1cm auto 0 auto;
            object-fit: contain;
        }

        .image-box {
            width: 4cm;
            height: 4cm;
            border: 1.5px dashed #bdbdbd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9a9a9a;
            font-size: 12px;
            text-align: center;
            padding: .3cm;
        }

        .footer-blank-space {
            background: transparent;
        }

        .footer-date {
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            text-align: right;
            font-size: 14px;
            font-weight: 500;
            padding-bottom: .1cm;
            white-space: nowrap;
        }

        @media print {
            body {
                background: #fff;
            }

            .page {
                margin: 0;
                box-shadow: none;
            }

            .image-box {
                border-color: #d0d0d0;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <section class="header">
            <div class="header-left">
                <img src="{{ public_path('images/CEACNL.png') }}" alt="CEACNL" class="logo-ceacnl">
            </div>
            <div class="header-center">
                <img src="{{ public_path('images/fondo.png') }}" alt="Fondo" class="fondo-superior">
            </div>

            <div class="header-right">
                <img src="{{ public_path('images/logo_estado_vertical.png') }}" alt="Estado"
                    class="logo-estado-vertical">
            </div>
        </section>

        <section class="content">
            <div class="institution">
                EL CONSEJO ESTATAL DE ARMONIZACIÓN CONTABLE<br>
                DEL ESTADO DE NUEVO LEÓN
            </div>

            <div class="grant-text">otorga el presente</div>

            <div class="title">RECONOCIMIENTO</div>

            <div class="recipient-row">
                <div>A:</div>
                <div class="recipient-line">
                    <div
                        style="
                            position:absolute;
                            width:100%;
                            top:-20px;
                            left:0;
                            text-align:center;
                            font-size:30px;
                            font-weight:700;
                            color:#000;
                            text-transform:uppercase;
                        ">
                        {{ ucwords(trim($registro->nombre . ' ' . $registro->apellido_paterno . ' ' . $registro->apellido_materno)) }}
                    </div>
                </div>
            </div>

            <div class="attendance">
                <div style="font-weight: 600;">Por su asistencia a la</div>
                <div class="event-name">Jornada de Auditoría y Contabilidad Gubernamental</div>
                <div class="event-date">realizado el 24 y 25 de septiembre del 2026.</div>
            </div>
        </section>

        <section class="footer">
            <div class="footer-image-space">
                <div style="width:4cm;height:4cm;">
                    <img src="data:image/png;base64,{{ $qr }}" style="width:4cm;height:4cm;">
                </div>
                <div
                    style="
                            position:absolute;
                            right:0;
                            bottom:-18px;
                            font-size:11px;
                            color:#666;
                        ">
                    Folio: {{ $registro->id }}
                </div>
            </div>

            <div class="footer-blank-space"></div>

            <div class="footer-date">
                Ciudad Universitaria, Nuevo León, 25 de septiembre del 2026
            </div>
        </section>
    </main>
</body>

</html>
