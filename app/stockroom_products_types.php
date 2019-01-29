<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stockroom_products_types extends Model
{
      protected $fillable = [
        'stkr_prodct_type_title','stkr_prodct_type_In_brands', '	stkr_prodct_type_archive', 'stkr_prodct_type_deleted',
      ];
}
