<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Mentores - Héroes Digitales</title>
</head>
<body>
  <tr>
    <th align="center">Nombres</th>
    <th align="center">Apellidos</th>
    <th align="center">Correo electrónico</th>
    <th align="center">Celular</th>
    <th align="center">Fecha de nacimiento</th>
    <th align="center">Género</th>
    <th align="center">Ciudad</th>
    <th align="center">Trabajo</th>
    <th align="center">Profesión</th>
    <th align="center">Lugar de trabajo</th>
    <th align="center">Equipo</th>
    <th align="center">Habilitado</th>
  </tr>
  @foreach ($mentors as $mentor)
    <tr>
      <td >{{ $mentor->names }}</td>
      <td >{{ $mentor->lastnames }}</td>
      <td >{{ $mentor->email }}</td>
      <td align="center">{{ $mentor->cellphone }}</td>
      <td align="center">{{ $mentor->birth_date }}</td>
      <td align="center">{{ $mentor->gender }}</td>
      <td align="center">{{ $mentor->city['nombre'] }}</td>
      <td align="center">{{ $mentor->mentor['job'] }}</td>
      <td align="center">{{ $mentor->mentor['profession'] }}</td>
      <td align="center">{{ $mentor->mentor['work_place'] }}</td>
      @if(!isset($mentor->team))
        <td align="center">Sin equipo</td>
      @else
        <td align="center">{{  $mentor->team['team_name'] }}</td>
      @endif
      <td align="center">{{ $mentor->is_active == 1 ? 'Sí' : 'No' }}</td>
    </tr>
  @endforeach

</body>
</html>
