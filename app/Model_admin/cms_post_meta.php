<?php

namespace App\Model_admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class cms_post_meta  extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $fillable = [
        'pst_meta_post_id', 'pst_meta_key', 'pst_meta_value',
        'deleted_flag' ,'archive_flag'
    ];

}
