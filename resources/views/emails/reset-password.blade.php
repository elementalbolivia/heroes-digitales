<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Heroes Digitales - Reestablecer contraseña</title>
</head>
<body>
	<h1 style="text-align:center;"> Recupere su contraseña - Héroes Digitales</h1>
	<p>Estimado {{ $names . ' ' . $lastnames }}, ingrese al siguiente enlace para que pueda recuperar su contraseña:</p>
		<a href="{{$verificationUrl}}" target="_blank"> Recuperar contraseña</a>
</body>
</html>