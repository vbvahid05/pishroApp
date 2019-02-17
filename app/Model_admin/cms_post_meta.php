<?php

namespace App\Model_admin;

use Illuminate\Database\Eloquent\Model;

class cms_post_meta  extends Model
{
    protected $fillable = [
        'pst_meta_post_id', 'pst_meta_key', 'pst_meta_value',
        'deleted_flag' ,'archive_flag'
    ];
}
