<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Heroes Digitales - Verificación</title>
</head>
<body>
	<h1 style="text-align:center;"> Gracias por realizar su registro en el concurso Héroes Digitales de Elemental</h1>
	<p>Estimado {{ $name . ' ' . $lastname }}, estamos muy contentos que hayas realizado tu registro,
		ingresa al siguiente enlace para completar tu inscripción, y puedas acceder a la plataforma:</p>
		<a href="{{$verificationUrl}}" target="_blank"> Completa tu inscripción</a>
</body>
</html>