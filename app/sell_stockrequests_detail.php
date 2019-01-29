<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_stockrequests_detail extends Model
{
  protected $fillable = [
      'ssr_d_stockrequerst_id','ssr_d_product_id', 'ssr_d_qty', 'ssr_d_ParentChasis',
      'deleted_flag','archive_flag',
  ];



}

