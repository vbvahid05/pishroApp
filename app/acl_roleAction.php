<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class acl_roleAction extends Model
{
    protected $fillable = [
        'role_roleID', 'role_Action_id', 'role_details',
        'deleted_flag' ,'archive_flag'
    ];

    public function userRoleAction()
    {
        //return $this->belongsTo('acl_userRoleAction','ura_role_action_Id');
    }
}
