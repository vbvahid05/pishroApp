<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stockroom_orders_status extends Model
{
  protected $table = 'stockroom_orders_status';

  protected $fillable = [
      '	stkr_ordrs_stus_title',
      '	deleted_flag','archive_flag',
  ];
}
