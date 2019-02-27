<?php

namespace App\Model_admin;

use Illuminate\Database\Eloquent\Model;

class cms_media_center extends Model
{
    protected $fillable = [
        'mdiac_category','mdiac_name','mdiac_filename','mdiac_mime_type' ,'mdiac_size' ,'mdiac_upload_by' ,'mdiac_permission','mdiac_options',
        'deleted_flag','archive_flag',
    ];
}
