<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class version_log extends Model
{
    protected $fillable = [
        'vrl_title','vrl_version',
    ];
}
