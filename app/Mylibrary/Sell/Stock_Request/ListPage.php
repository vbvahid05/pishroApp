<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 22/05/2018
 * Time: 09:45 AM
 */

namespace App\Mylibrary\Sell\Stock_Request;


use App\User;

class ListPage
{
    public  function Get_ListPage ($request)
    {

        $data = $request->all();
        $mode=$data['mode'];
        $type=$data['type'];
        if ($type==0)
        {
            $valus = \DB::table('sell_stockrequests AS stockrequests')
                ->join('custommers'   ,   'custommers.id', '=','stockrequests.sel_sr_custommer_id')
                ->join('custommerorganizations AS cusmrORD'   ,   'cusmrORD.id', '=','custommers.cstmr_organization')
                ->select('*', \DB::raw('stockrequests.id AS stockrequestsID '))
                ->where('stockrequests.deleted_flag', '=', $mode)
                ->where('stockrequests.sel_sr_type', '=', $type)
                ->orderBy('stockrequestsID', 'desc')
                ->get();
        }
        else   {
            $valus = \DB::table('sell_stockrequests AS stockrequests')
                ->join('custommers'   ,   'custommers.id', '=','stockrequests.sel_sr_custommer_id')
                ->join('custommerorganizations AS cusmrORD'   ,   'cusmrORD.id', '=','custommers.cstmr_organization')
                ->select('*', \DB::raw('stockrequests.id AS stockrequestsID '))
                ->where('stockrequests.deleted_flag', '=', $mode)
                ->orderBy('stockrequestsID', 'desc')
                ->get();
        }


        $arrayLength=count($valus);
        $outArray=array();
        foreach ($valus as $val)
        {

            $user = user::find($val->sel_sr_created_by);

            /* Count of comited requerst*/
            $stockrequestsID=  $val->stockrequestsID  ;
            $Resvalus = \DB::table('sell_takeoutproducts AS takeoutproducts')
                ->where('takeoutproducts.sl_top_stockrequest_id', '=', $stockrequestsID)
                ->where('takeoutproducts.deleted_flag', '=', 0)
                ->get();
            $serilaCount=count($Resvalus ) ;
//-------------
            $totalQTY = \DB::table('sell_stockrequests_details AS stockrequests_details')
                ->where('stockrequests_details.ssr_d_stockrequerst_id', '=', $val->stockrequestsID)
                //->select(   \DB::raw('sum(stockrequests_details.ssr_d_qty) AS stockrequestsQTY ') ))
                ->sum('stockrequests_details.ssr_d_qty');
            $qtyStatus='';
            if ($serilaCount==$totalQTY && $serilaCount !=0 && $totalQTY!=0)
                $qtyStatus='Print';
            $array = array(
                "userName" => $user['name'] ,
                "cstmr_name"    => $val->cstmr_name,
                "cstmr_family"  => $val->cstmr_family,
                "org_name" => $val->org_name,
                "sel_sr_type" =>  $val->sel_sr_type ,
                "sel_sr_registration_date" =>  $val->sel_sr_registration_date  ,
                "sel_sr_delivery_date" => $val->sel_sr_delivery_date ,
                "sel_sr_pre_contract_number" => $val->sel_sr_pre_contract_number ,
                "AvailableQTY" =>  $serilaCount ,
                "totalQTY"=> $totalQTY,
                "qtyStatus"=> $qtyStatus,
                "lockStatus"=>$val->sel_sr_lock_status,
                "id" =>  $val->stockrequestsID,
                "btn" =>'<button class="btn" >sss</button>'


            );

            array_push($outArray,$array);
        }
        return $outArray;
    }
}