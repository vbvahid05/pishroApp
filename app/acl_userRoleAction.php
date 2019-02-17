<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class acl_userRoleAction extends Model
{
    protected $fillable = [
        'ura_user_id', 'ura_role_action_Id', 'ura_details','ura_avatar',
        'deleted_flag' ,'archive_flag'
    ];



    public function getActionIds()
    {
        //return $this->hasMany('App\acl_roleAction','XXX');


    }



}
