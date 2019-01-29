<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_invoice_currency extends Model
{
    protected $fillable=[
        'sic_Currency',
        'deleted_flag','archive_flag',
    ];
}
