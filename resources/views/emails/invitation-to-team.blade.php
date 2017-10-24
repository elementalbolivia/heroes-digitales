<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Heroes Digitales - Autorización</title>
</head>
<body>
  <h1>Invitación a equipo {{ $teamName }}</h1>
	<p>Has sido invitado a formar parte del equipo {{ $teamName }} dentro la plataforma Héroes Digitales. <br>
  Puedes aceptar o rechazar la invitación mediante los siguiente enlaces:</p>
  <a href="{{$acceptUrl}}" target="_blank"> Aceptar invitación</a>
	<a href="{{$refuseUrl}}" target="_blank"> Rechazar invitación</a>
</body>
</html>
