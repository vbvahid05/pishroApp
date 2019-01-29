<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stockroom_orders_seller extends Model
{
  protected $fillable = [
      'stkr_ordrs_slr_name', 'stkr_ordrs_slr_tel', 'stkr_ordrs_slr_info',
      'archive_flag','deleted_flag',
  ];
}
