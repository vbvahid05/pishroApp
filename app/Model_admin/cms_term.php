<?php
/**
 * Created by PhpStorm.
 * User: vahid
 * Date: 17/02/2019
 * Time: 03:35 PM
 */

namespace App\Model_admin;
use Illuminate\Database\Eloquent\Model;
class cms_term extends Model
{
    protected $fillable = [
        'trm_type', 'trm_title', 'trm_slug','trm_parent', 'trm_lang', 'trm_permission', 'trm_public_name',
        'deleted_flag' ,'archive_flag'
    ];
}