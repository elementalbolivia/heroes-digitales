<?php
namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Mail\ParentsAuth;
use App\Mail\EmailInvitation;
use App\Mail\RequestToJoin;
use App\Mail\Invitation;
use App\Models\Usuario;
use Hash;

date_default_timezone_set('America/La_Paz');

trait EmailTrait{
	public static function authEmail($email){
		$user = Usuario::where('correo', $email)->first();
		$now = date('Y-m-d H:i:s');
		$emailConf = [
			'token'			=> md5($user->id) . md5(date('YmdHis')),
			'fecha_inicio'	=> $now,
			'fecha_fin'		=> date('Y-m-d H:i:s', strtotime($now . ' + 3 days')),
		];
		$user->resetPassword()->create($emailConf);
		$resetUrl =  config('constants.STATE.LOCAL_URL') . 'reestablecer-contraseña/' . $user->id .'/'. $emailConf['token'];
		Mail::to($email)
	    			->send(new ResetPassword($user->nombres, $user->apellidos, $resetUrl));
	}
	public static function parentsEmail($user, $email, $rid, $token){
		$authUrl = config('constants.STATE.LOCAL_URL') .'autorizacion-padres/' . $rid .'/'. $token;
		Mail::to($email)
	    			->send(new ParentsAuth($user->nombres, $user->apellidos, $authUrl));
	}
	public static function invitationEmail($email, $leadername, $teamname, $url){
		Mail::to($email)
			->send(new EmailInvitation($leadername, $teamname, $url));
	}
	public static function requestEmail($name, $email){
		$url = config('constants.STATE.LOCAL_URL') . 'dashboard';
		Mail::to($email)
			->send(new RequestToJoin($name, $url));
	}
	public static function sendInvitationEmail($email, $teamname, $aUrl, $rUrl){
		Mail::to($email)
			->send(new RequestToJoin($teamname, $aUrl, $rUrl));
	}
}
