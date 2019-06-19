<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_stockrequests_archive extends Model
{
    protected $fillable = [
        'slsr_arch_stockrequests_id','slsr_arch_products_data', 'slsr_arch_more',
        'deleted_flag','archive_flag'
    ];

}
