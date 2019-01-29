<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_TakeOutProduct extends Model
{
  protected $fillable = [
      'sl_top_stockrequest_id','sl_top_product_serialnumber_id', 'sl_top_productid' ,
      'deleted_flag','archive_flag',
  ];

}
