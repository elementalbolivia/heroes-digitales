<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Heroes Digitales - Verificación</title>
</head>
<body>
	<h1 style="text-align:center;"> FELICIDADES <br />Su petición para ser juez/experto fue aprobada</h1>
	<p>Estimado {{ $name . ' ' . $lastname }}, estamos muy contentos que desees formar parte del equipo evaluador del concurso Héroes Digitales, ingresa al siguiente enlace para completar tu inscripción, y puedas acceder a la plataforma:</p>
		<a href="{{$verificationUrl}}" target="_blank"> Completa tu inscripción</a>
</body>
</html>