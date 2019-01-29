<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class stockroom_order extends Model
{
  protected $fillable = [
      'stk_ordrs_id_code','stk_ordrs_id_number', 'stk_ordrs_seller_id', 'stk_ordrs_putting_date', 'stk_ordrs_status_id','stk_ordrs_comment','stk_ordrs_user_id',
      'deleted_flag','archive_flag',
  ];



  public function seller()
  {
     return $this->belongsTo('App\stockroom_orders_seller', 'stk_ordrs_seller_id');
  }

  public function status()
  {
     return $this->belongsTo('App\stockroom_orders_status', 'stk_ordrs_status_id');
  }
}
