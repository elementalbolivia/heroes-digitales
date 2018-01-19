<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Estudiantes - Héroes Digitales</title>
</head>
<body>
  <tr>
    <th align="center">Nombres</th>
    <th align="center">Apellidos</th>
    <th align="center">Correo electrónico</th>
    <th align="center">Celular</th>
    <th align="center">Fecha de nacimiento</th>
    <th align="center">División</th>
    <th align="center">Género</th>
    <th align="center">Ciudad</th>
    <th align="center">Colegio</th>
    <th align="center">Equipo</th>
    <th align="center">Habilitado</th>
  </tr>
  @foreach ($students as $student)
    <tr>
      <td >{{ $student->names }}</td>
      <td >{{ $student->lastnames }}</td>
      <td >{{ $student->email }}</td>
      <td align="center">{{ $student->cellphone }}</td>
      <td align="center">{{ $student->birth_date }}</td>
      <td align="center">{{ $student->student['division'] }}</td>
      <td align="center">{{ $student->gender }}</td>
      <td align="center">{{ $student->city['nombre'] }}</td>
      <td align="center">{{ $student->student['school'] }}</td>
      @if(!isset($student->team))
        <td align="center">Sin equipo</td>
      @else
        <td align="center">{{  $student->team['team_name'] }}</td>
      @endif
      <td align="center">{{ $student->is_active == 1 ? 'Sí' : 'No' }}</td>
    </tr>
  @endforeach

</body>
</html>
