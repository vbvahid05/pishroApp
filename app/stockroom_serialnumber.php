<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stockroom_serialnumber extends Model
{
  protected $fillable = [
      'stkr_srial_putting_product_id','stkr_srial_parent','stkr_srial_serial_numbers_a','stkr_srial_serial_numbers_b' ,
      'stkr_srial_more','stkr_srial_status',
       'deleted_flag','archive_flag',
  ];
}
