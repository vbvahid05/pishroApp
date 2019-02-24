<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 23/02/2019
 * Time: 09:42 AM
 */

namespace App\Mylibrary\Sell\warranty;


use App\sell_stockrequests_warrantie;
use App\stockroom_serialnumber;

class Warranty
{
        public function  getWarrantyList()
        {
            $val = \DB::table('sell_stockrequests_warranties AS warranties')

                ->join('sell_stockrequests AS stockrequests'   ,   'stockrequests.id' , '=' ,'warranties.ssw_stockReqID')
                ->join('custommers'   ,   'custommers.id' , '=' ,'stockrequests.sel_sr_custommer_id')
                ->join('custommerorganizations AS ORG'   ,   'ORG.id' , '=' ,'custommers.cstmr_organization')
                ->select('*' ,\DB::raw('warranties.id AS w_id'))
//                ->join('sell_invoice_currencies AS currency'   ,   'currency.id' , '=' ,'invoices.si_Currency')
//                ->join('custommers AS custommer'              ,   'custommer.id', '=' ,'invoices.si_custommer_id')
//                ->join('custommerorganizations AS org'   ,   'org.id' , '=' ,'custommer.cstmr_organization')
//                ->select( \DB::raw('
//                            invoices.id            AS  id,
//                            invoices.si_Alias_id   AS  invoices_Alias,
//                            invoices.si_date       AS  invoices_Date ,
//                            invoices.si_VerifiedBy AS  VerifiedBy,
//                            custommer.cstmr_name   AS  custommer_name,
//                            custommer.cstmr_family AS  custommer_family,
//                            org.org_name           AS  orgName,
//                            users.name             AS  createdBy
//
//                                '))
//                ->where('invoices.deleted_flag', '=', $mode)
//
//                ->orderBy('id', 'Desc')
                ->get();
            return $val;
        }

        public static function  GetSerialNumbers()
        {
            $serials=  \DB::table('stockroom_serialnumbers AS serialnumbers')
//                ->join('stockroom_stock_putting_products AS putting_products'   ,   'putting_products.id' , '=' ,'serialnumbers.stkr_srial_putting_product_id')
//                ->join('stockroom_products AS products'   ,   'products.id' , '=' ,'putting_products.stkr_stk_putng_prdct_product_id')
                ->select( \DB::raw('
                            serialnumbers.id   AS  sn_id, 
                            serialnumbers.stkr_srial_serial_numbers_a   AS  serial_numberA,
                            serialnumbers.stkr_srial_serial_numbers_b   AS  serial_numberB
                             
                                '))
                ->where('serialnumbers.stkr_srial_status', '=', 1)
                ->get();
          //  $serials=stockroom_serialnumber::all();
            $str_return='';
            foreach ( $serials AS  $rr  )
            {
                $serB='';
                if ($rr->serial_numberB) $serB='  |   '.$rr->serial_numberB ;
                $str_return=$str_return.'<option value="'.$rr->sn_id.'">'.$rr->serial_numberA .$serB.'</option>';
            }
            return $str_return;
        }
//-----------------------------------
    function  getInfoAroundSerialNumber($request)
    {
        $SerialNumberID= $request['SerialNumberID'];
        return $serials=
            \DB::table('stockroom_serialnumbers AS serialnumbers')
            ->join('sell_takeoutproducts             AS takeoutproducts'    ,   'takeoutproducts.sl_top_product_serialnumber_id' , '=' ,'serialnumbers.id')
            ->join('stockroom_products               AS products'           ,   'products.id'           , '=' ,'takeoutproducts.sl_top_productid')
            ->join('stockroom_products_brands        AS brands'             ,   'brands.id'             , '=' ,'products.stkr_prodct_brand')
            ->join('stockroom_products_types         AS types'              ,   'types.id'              , '=' ,'products.stkr_prodct_type')
            ->join('sell_stockrequests               AS stockrequests'      ,   'stockrequests.id'      , '=' ,'takeoutproducts.sl_top_stockrequest_id')
            ->join('custommers                       AS custommer'          ,   'custommer.id'          , '=' ,'stockrequests.sel_sr_custommer_id')
            ->join('custommerorganizations           AS ORG'                ,   'ORG.id'                , '=' ,'custommer.cstmr_organization')

                ->select( \DB::raw('
                              serialnumbers.id                              AS SN_ID,
                              serialnumbers.stkr_srial_serial_numbers_a     AS  snA,
                              serialnumbers.stkr_srial_serial_numbers_b     AS  snB,
                              products.stkr_prodct_partnumber_commercial    AS  partnumber ,
                              products.stkr_prodct_title AS  prodctTitle,
                              brands.stkr_prodct_brand_title   AS  Brand,
                              types.stkr_prodct_type_title AS  Type,
                              custommer.cstmr_name AS custommerName,
                              custommer.cstmr_family AS custommerFamily,                              
                              ORG.org_name AS   orgName , 
                              stockrequests.id AS  stockrequestsID ,
                              stockrequests.sel_sr_registration_date AS  stockreqRegistr_date ,
                              stockrequests.sel_sr_delivery_date AS     stockreqDelivery_date

                            '))
            ->where('serialnumbers.id', '=', $SerialNumberID)
           // ->select('*')
            ->get();
    }
}