<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custommer extends Model
{

    protected $fillable = [
        'cstmr_name', 'cstmr_family', 'cstmr_organization','cstmr_post', 'cstmr_tel','cstmr_dakheli','cstmr_Mobiletel', 'cstmr_email',
        'cstmr_postalcode', 'cstmr_address', 'cstmr_codeghtesadi', 'cstmr_detials','cstmr_desc','deleted_flag' ,'archive_flag'
    ];
}
