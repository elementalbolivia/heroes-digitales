<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Heroes Digitales - Autorización</title>
</head>
<body>
  <h1>Autorización para participación</h1>
	<h1 style="text-align:center;"> Estimado padre/madre/apoderado, tenemos el agrado de comunicarle que su hijo
    {{ $name . ' ' . $lastname }}, participará en el concurso Héroes Digitales de Elemental</h1>
	<p>De forma que su hijo pueda participar activamente en el concurso, debe autorizarlo,
  aceptando el reglamento, que puede ser leído más detalladamente en el siguiente enlace</p>
		<a href="{{$url}}" target="_blank"> Leer autorización</a>
</body>
</html>
