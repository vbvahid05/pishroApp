<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sell_invoice extends Model
{
     protected $fillable=[
         'si_Alias_id ','si_Currency' ,'si_custommer_id','si_date',
         'si_Discount','si_warranty','si_Payment','si_deliveryDate','si_delivery_type','si_Description','si_created_by','si_VerifiedBy','si_pdf_settings',
         'deleted_flag','archive_flag'
         ];
}
