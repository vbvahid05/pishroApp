<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_activity_log extends Model
{
    protected $fillable = [
        'ual_userId','ual_ip','ual_status','ual_Activity' ,
    ];
}
