<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Heroes Digitales - Autorización</title>
</head>
<body>
  <h1>Invitación a equipo {{ $team }}</h1>
	<p>Has sido invitado por {{ $leadername }} a formar parte del equipo {{ $team }} del concurso Héroes Digitales, para aceptar
  la invitación debes registrarte en el siguiente enlace a continuación: </p>
		<a href="{{$url}}" target="_blank"> Aceptar invitación y registrarme</a>
</body>
</html>
