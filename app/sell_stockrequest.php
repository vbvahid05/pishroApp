<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_stockrequest extends Model
{
  protected $fillable = [
      'sel_sr_type','sel_sr_custommer_id', 'sel_sr_registration_date', 'sel_sr_delivery_date', 'sel_sr_pre_contract_number',
      'sel_sr_lock_status','sel_sr_pdf_setting','deleted_flag','archive_flag',
  ];




}
