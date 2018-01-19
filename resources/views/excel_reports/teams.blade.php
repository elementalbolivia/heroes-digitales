<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Equipos - Héroes Digitales</title>
</head>
<body>
  <table>
    <tr>
      <th align="center">Nombre equipo</th>
      <th align="center">Categoría</th>
      <th align="center">División</th>
      <th align="center">Ciudad</th>
      <th align="center" width="15">Tiene mentor</th>
      <th align="center">Mentor/es</th>
      <th align="center" colspan="4">Estudiante/s</th>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <th align="center" width="15">Nombre</th>
      <th align="center" width="15">Edad</th>
      <th align="center" width="17">Fecha de nacimiento</th>
      <th align="center" width="15">Ciudad</th>
    </tr>
    @foreach ($teams as $team)
      <tr>
        <td valign="middle" rowspan="{{ count($team['members']['students']) > 0 ?  count($team['members']['students']) : 2}}">
          {{ $team['team_name'] }}
        </td>
        <td width="20" valign="middle" rowspan="{{ count($team['members']['students']) > 0 ?  count($team['members']['students']) : 2}}">
          {{ $team['category'] == null ? '' : $team['category']['nombre'] }}
        </td>
        <td width="20" valign="middle" rowspan="{{ count($team['members']['students']) > 0 ?  count($team['members']['students']) : 2}}">
          {{ $team['division']['nombre'] }}
        </td>
        <td valign="middle" rowspan="{{ count($team['members']['students']) > 0 ?  count($team['members']['students']) : 2}}">
          {{ $team['city']['nombre'] }}
        </td>
        <td valign="middle" rowspan="{{ count($team['members']['students']) > 0 ?  count($team['members']['students']) : 2}}">
          {{ $team['has_mentor'] ? 'Sí' : 'No' }}
        </td>
        <td width="30">
          <table>
            <td></td>
            @foreach ($team['members']['mentors'] as $mentor)
            <tr>
              <td>
                {{ $mentor['names'] . ' ' . $mentor['lastnames'] }}
              </td>
            </tr>
            @endforeach
          </table>
        </td>
        <td width="30">
          <table>
            @foreach ($team['members']['students'] as $student)
            <tr>
              <td>
                {{ $student['names'] . ' ' . $student['lastnames'] }}
              </td>
              <td>{{ $student['age'] }}</td>
              <td>{{ $student['birth_date'] }}</td>
              <td>{{ $student['city'] }}</td>
            </tr>
            @endforeach
          </table>
        </td>
      </tr>
    @endforeach
  </table>
</body>
</html>
