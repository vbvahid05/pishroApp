<?php

namespace App\Model_admin;

use Illuminate\Database\Eloquent\Model;

class cms_term_relation extends Model
{
    protected $fillable = [
        'trmrel_term_id', 'trmrel_title', 'trmrel_slug', 'trmrel_action', 'trmrel_value', 'trmrel_parent','trmrel_icon', 'trmrel_class', 'trmrel_lang_label',
        'deleted_flag' ,'archive_flag'
    ];
}
