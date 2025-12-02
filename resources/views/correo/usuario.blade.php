<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $asunto ?? 'Correo' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
            font-size: 16px;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .info {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}"
                style="width:250px; display:block; margin:0 auto;">
        </div>
        <h1>Secretaría de Finanzas y Tesorería General del Estado</h1>
        <h2>{{ $mensaje ?? 'Hola' }}, {{ $usuario ?? '' }}!</h2>

        <p>
            @if ($tipo == 'bienvenido')
                Bienvenido a nuestra plataforma. Aquí están tus credenciales de acceso:
            @elseif($tipo == 'restablecido')
                Tu contraseña ha sido actualizada exitosamente. Tus nuevas credenciales son:
            @else
            @endif
        </p>

        <div class="info">
            <p><strong>Usuario:</strong> {{ $usuario }}</p>
            <p><strong>Contraseña:</strong> {{ $password }}</p>
        </div>

        <p>Consejos importantes de seguridad::</p>
        <ol>
            <li>Mantén los datos de tu cuenta en un lugar seguro.</li>
            <li>No compartas tus datos de acceso con otras personas.</li>
            <li>Cambia tu contraseña regularmente.</li>
        </ol>
        <p>Para iniciar sesión, haz click en el botón de abajo:</p>

        <a class="btn" href="{{ env('APP_LOGIN_URL') }}">Iniciar Sesión</a>
    </div>
</body>

</html>
