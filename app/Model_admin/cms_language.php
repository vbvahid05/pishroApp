<?php

namespace App\Model_admin;

use Illuminate\Database\Eloquent\Model;

class cms_language extends Model
{

    protected $fillable = [
        'lang_title','lang_name','lang_icon',
        'deleted_flag','archive_flag',
    ];
}
