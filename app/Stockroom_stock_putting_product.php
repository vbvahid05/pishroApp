<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockroom_stock_putting_product extends Model
{
   protected $fillable = [
          'stkr_stk_putng_prdct_order_id', 'stkr_stk_putng_prdct_product_id','stkr_stk_putng_prdct_partofchassis',
           'stkr_stk_putng_prdct_tech_part_numbers','stkr_stk_putng_prdct_qty','stkr_stk_putng_prdct_serial_Number_id',
           'stkr_stk_putng_prdct_in_date','stkr_stk_putng_prdct_chassis_number','stkr_stk_putng_prdct_SO_Number',
           'stkr_stk_putng_prdct_More_info','deleted_flag','archive_flag',
      ];

}
