<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_stockrequests_warrantie extends Model
{
    protected $fillable = [
        'ssw_stockReqID','ssw_warranty_start_date', 'ssw_duration_of_warranty', 'ssw_duration_unit', 'ssw_delivery_date','ssw_pdf_setting','ssw_request_flag',
        'created_by','updated_by','read_status_flag','deleted_flag','archive_flag',
    ];
}
