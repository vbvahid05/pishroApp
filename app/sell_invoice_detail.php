<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_invoice_detail extends Model
{
    protected $fillable=[
        'sid_invoice_id ','sid_product_id' ,'sid_qty','sid_parent','sid_position',
        'deleted_flag','archive_flag'
    ];
}
