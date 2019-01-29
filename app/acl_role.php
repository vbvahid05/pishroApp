<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class acl_role extends Model
{
    protected $fillable = [
        'role_title', 'role_slug', 'role_details',
        'deleted_flag' ,'archive_flag'
    ];
}
