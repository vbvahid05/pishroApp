<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class acl_action extends Model
{
    protected $fillable = [
        'actn_title', 'actn_actn_slug', 'actn_details',
        'deleted_flag' ,'archive_flag'
    ];
}
