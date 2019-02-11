<?php
/**
 * Created by PhpStorm.
 * User: vahid
 * Date: 12/02/2019
 * Time: 12:16 AM
 */

namespace App\Model_admin;
use Illuminate\Database\Eloquent\Model;

class cms_post extends Model
{
    protected $fillable = [
        'post_title','post_slug','post_status','post_categury' ,'post_type' ,'post_content' ,'post_lang','post_author_id',
        'deleted_flag','archive_flag',
    ];
}




