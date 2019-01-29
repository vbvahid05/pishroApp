<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockroom_products_brands extends Model
{
  protected $fillable = [
      'stkr_prodct_brand_title', 'stkr_prodct_brand_archive', 'stkr_prodct_brand_deleted',
  ];
}
