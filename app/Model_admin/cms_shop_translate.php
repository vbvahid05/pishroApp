<?php

namespace App\Model_admin;

use Illuminate\Database\Eloquent\Model;

class cms_shop_translate extends Model
{
    protected $fillable = [
        'cmsshptransl_type', 'cmsshptransl_target_id', 'cmsshptransl_lang_id', 'cmsshptransl_title'

    ];
}
