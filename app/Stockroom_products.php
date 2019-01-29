<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockroom_products extends Model
{
  protected $fillable = [
      'stkr_prodct_partnumber_commercial', 'stkr_prodct_title', 'stkr_prodct_brand','stkr_prodct_type','stkr_prodct_type_cat',
      'stkr_prodct_price','stkr_tadbir_stock_id',
      'archive_flag','deleted_flag',
  ];
}
