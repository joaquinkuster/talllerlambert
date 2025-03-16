<!DOCTYPE html>
<html>
<head>
    <title>Restablecimiento de contraseña</title>
</head>
<body>
    <h1>Restablecimiento de contraseña</h1>
    <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta.</p>
    <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
    <a href="{{ url('restablecer-contraseña/'.$token) }}">Restablecer contraseña</a>
</body>
</html>
