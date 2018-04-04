<?php
namespace App\Traits;
use App\Models\Experto;
use App\Models\Equipo;
use DB;

date_default_timezone_set('America/La_Paz');

/**
 *
 */
trait ExpertTrait
{
  public static function assignRandomTeams(){
    $experts = DB::table('usuario')
                ->join('experto', 'usuario.id', '=', 'experto.usuario_id')
                ->select('experto.id')
                ->where('usuario.activo', '=', 1)
                ->get();
    $teams = DB::table('equipo')
                ->where('activo', '=', 1)
                ->select('id')
                ->get();
    $num_teams = count($teams);
    $num_experts = count($experts);
    $per_team = $num_teams / (float)$num_experts;
    $teams_per_expert = floor($per_team);
    $queue = array();
    $experts_assigned = [];
    for ($i = 0; $i < $num_experts; $i++) {
      $counter = $teams_per_expert;
      while($counter > 0){
        $to_enqueue = self::getRandomMember($teams, $num_teams, $queue);
        if($to_enqueue[0]) {
          $experts_assigned[] = [
            'experto_id'  => $experts[$i]->id,
            'equipo_id' => $to_enqueue[1],
            'fecha_creacion'  => date('Y-m-d H:i:s'),
            'fecha_actualizacion'  => date('Y-m-d H:i:s'),
          ];
          $queue[] = $to_enqueue[1];
          $counter--;
        }
        
      }
    }
    return $experts_assigned;
  }

  private static function getRandomMember($arr, $arr_len, $inQueue){
    $randIndex = 0;
    $r_element = random_int(0, $arr_len - 1);
    if (in_array($arr[$r_element]->id, $inQueue))  return [false];
    else return [true, $arr[$r_element]->id];
  }
}
