<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_takeoutproduct extends Model
{
  protected $fillable = [
      'sl_top_stockrequest_id','sl_top_product_serialnumber_id', 'sl_top_productid' ,'sl_top_StockRequestRowID',
      'deleted_flag','archive_flag',
  ];
}
