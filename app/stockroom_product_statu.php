<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stockroom_product_statu extends Model
{
  protected $fillable = [
      'sps_product_id', 'sps_available', 'sps_reserved',
      'sps_sold', 'sps_warranty', '	sps_borrowed',
      'deleted_flag', 'archive_flag' ,
  ];
}
