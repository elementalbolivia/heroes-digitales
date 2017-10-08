<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UsuarioTieneRol;
use App\Models\Ciudad;
use App\Models\Zona;
use App\Models\Genero;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Usuario extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $table = 'usuario';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['correo', 'password', 'nombres', 'apellidos', 'fecha_nacimiento',
    						'celular', 'ciudad_id', 'genero_id'];
    public function roles(){
    	return $this->belongsToMany('App\Models\Roles', 'usuario_tiene_rol', 'usuario_id', 'rol_id')
    			->withPivot('fecha_creacion', 'fecha_actualizacion');
    }
    public function role($id){
        return UsuarioTieneRol::where('usuario_id', $id)->first();
    }
    public function resetPassword(){
    	return $this->hasOne('App\Models\ReestablecerPassword', 'usuario_id');
    }
    public function image(){
    	return $this->hasOne('App\Models\Imagen', 'usuario_id');
    }
    public function biography(){
    	return $this->hasOne('App\Models\Biografia', 'usuario_id');
    }
    public function emailConfirmation(){
        return $this->hasOne('App\Models\ConfirmacionEmail', 'usuario_id');
    }
    public function student(){
        return $this->hasOne('App\Models\Estudiante', 'usuario_id');
    }
    public function mentor(){
        return $this->hasOne('App\Models\Mentor', 'usuario_id');
    }
    public function judge(){
        return $this->hasOne('App\Models\Juez', 'usuario_id');
    }
    public function expert(){
        return $this->hasOne('App\Models\Experto', 'usuario_id');
    }
    public function admin(){
        return $this->hasOne('App\Models\Admin', 'usuario_id');
    }
    public function proffesionalData(){
        return $this->hasOne('App\Models\DatosProfesionales', 'usuario_id');
    }
    public function city($cityId){
        return Ciudad::find($cityId);
    }
    public function genre($genreId){
        return Genero::find($genreId);
    }
    public function zone(){
        return $this->hasOne('App\Models\Zona', 'usuario_id');
    }

}
