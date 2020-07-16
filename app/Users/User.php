<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model 
{
    use SoftDeletes;
    protected $connection = 'mysql';

    protected $fillable = [
        'name', 'username', 'password',
        ];
    protected $hidden = [
        'password', 'remember_token',
        ];

    //estrangeiras
    public function cargo() {
        return $this->belongsTo('App\Users\Cargo','cargo_id','id');
    }

    public function carteira() {
        return $this->belongsTo('App\Users\Carteira','carteira_id','id');
    }

    public function ilha() {
        return $this->belongsTo('App\Users\Ilha','ilha_id','id');
    }

    public function userType() {
        return $this->belongsTo('App\Users\UserType','usertype_id','id');
    }

    public function quiz()
    {
        return $this->hasOne('App\Quiz\Quiz', 'creator_id', 'id');
    }

    //locais
   
    //Logs
    public function logQuiz()
    {
        return $this->hasOne('App\Logs\Quiz', 'user_id', 'id');
    }

    public function logChat()
    {
        return $this->hasOne('App\Logs\Chat', 'user_id', 'id');
    }

    public function logMaterialLogs()
    {
        return $this->hasOne('App\Logs\MaterialLogs', 'user_id', 'id');
    }

    public function log()
    {
        return $this->hasMany('App\Logs\Log', 'user_id', 'id');
    }

}
