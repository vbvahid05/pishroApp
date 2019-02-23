<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_stockrequests_warranties_detail extends Model
{
    protected $fillable = [
        'sswd_warrantie_id','sswd_faulty_serial', 'sswd_alternative_serial',
        'created_by','updated_by','read_status_flag','deleted_flag','archive_flag',
    ];

}
