<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custommerorganization extends Model
{
    protected $fillable = [
        'org_name', 'org_tel', 'org_address','org_postalCode', 'org_codeeghtesadi', 'org_deleted','	org_archived',
    ];
}
