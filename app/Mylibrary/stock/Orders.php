<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 05/12/2018
 * Time: 09:58 AM
 */

namespace App\Mylibrary\stock;
use App\stockroom_order;


class Orders
{
    public function updateStackrequest_info($data)
    {
       $OrderID=$data['OrderID'];
       $field=$data['field'];
       $value=$data['value'];
        switch ($field)
        {
            case 'orderComment':
                $field_name='stk_ordrs_comment';
            break;
        }
       if ( stockroom_order::where('id', '=', $OrderID) ->update(array($field_name => $value)))
           return 1;
        else return 0;


    }
}