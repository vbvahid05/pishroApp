<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 23/02/2019
 * Time: 09:42 AM
 */

namespace App\Mylibrary\Sell\warranty;

use App\Mylibrary\PublicClass;
use App\sell_stockrequests_warrantie;
use App\sell_stockrequests_warranties_detail;
use App\stockroom_serialnumber;
use Illuminate\Support\Facades\Auth;

class Warranty
{
        public function  getWarrantyList($request)
        {
           $mode= $request['mode'];
            switch ($mode)
            {
                case 'addRequest':
                    $val = \DB::table('sell_stockrequests_warranties AS warranties')
                        ->join('sell_stockrequests AS stockrequests'   ,   'stockrequests.id' , '=' ,'warranties.ssw_stockReqID')
                        ->join('custommers'   ,   'custommers.id' , '=' ,'stockrequests.sel_sr_custommer_id')
                        ->join('custommerorganizations AS ORG'   ,   'ORG.id' , '=' ,'custommers.cstmr_organization')
                        ->select('*' ,\DB::raw('warranties.id AS warranty_id ,
                                        stockrequests.id AS stkRq_ID 
                
                '))
                        ->get();
                break;
                case 'stockOut':
                    $val = \DB::table('sell_stockrequests_warranties AS warranties')
                        ->join('sell_stockrequests AS stockrequests'   ,   'stockrequests.id' , '=' ,'warranties.ssw_stockReqID')
                        ->join('custommers'   ,   'custommers.id' , '=' ,'stockrequests.sel_sr_custommer_id')
                        ->join('custommerorganizations AS ORG'   ,   'ORG.id' , '=' ,'custommers.cstmr_organization')
                        ->select('*' ,\DB::raw('warranties.id AS warranty_id ,
                                        stockrequests.id AS stkRq_ID 
                
                '))
                        ->where('warranties.ssw_request_flag', '=', 1)
                        ->get();
                break;
            }



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

    function  SaveWarrantyForm ($request)
    {
        $warrantyInfo=$request[0];
        $warrantySerailList=$request[1];
        $pb=new PublicClass();
         $pb->jalali_to_gregorian_byString($warrantyInfo['start_date']);

        $warrantyTable=new sell_stockrequests_warrantie;
        $warrantyTable->ssw_stockReqID=$warrantyInfo['stockrequestsID'];
        $warrantyTable->ssw_warranty_start_date=$pb->jalali_to_gregorian_byString($warrantyInfo['start_date']);
        $warrantyTable->ssw_duration_of_warranty=$warrantyInfo['WarrantyPeriod'];
        $warrantyTable->ssw_duration_unit=$warrantyInfo['WarrantyDuration'];
        $warrantyTable->ssw_delivery_date= $pb->jalali_to_gregorian_byString($warrantyInfo['delevery_date']);
        $warrantyTable->ssw_pdf_setting='';
        $warrantyTable->created_by=Auth::user()->id;
        $warrantyTable->updated_by=Auth::user()->id;
        $warrantyTable->read_status_flag=0;
        $warrantyTable->deleted_flag=0;
        $warrantyTable->archive_flag=0;
        $warrantyTable->save();

        $st="";
        $warrantyID= $warrantyTable->id;
        foreach ($warrantySerailList AS $wList)
        {
            try
            {
                $warrantyTable_detail=new sell_stockrequests_warranties_detail;
                $warrantyTable_detail->sswd_warrantie_id=$warrantyID;
                $warrantyTable_detail->sswd_faulty_serial=$wList['id'];
                $warrantyTable_detail->sswd_alternative_serial=0;
                $warrantyTable_detail->created_by=Auth::user()->id;
                $warrantyTable_detail->updated_by=Auth::user()->id;
                $warrantyTable_detail->read_status_flag=0;
                $warrantyTable_detail->deleted_flag=0;
                $warrantyTable_detail->archive_flag=0;
                $warrantyTable_detail->save();
            }
            catch (\Exception $e)
            {
                return $e->getMessage();
            }
        }
        return '('.$warrantyID.')'.$st;
    }
//------------------------------------------------------

    public function UpdateWarrantyForm($request)
    {
        $WarrantyId=$request[2];

        $WarrantyDuration=$request[0]['WarrantyDuration'];
        $WarrantyPeriod  =$request[0]['WarrantyPeriod'];
        $delevery_date   =$request[0]['delevery_date'];
        $warranty_start_date      =$request[0]['start_date'];
        $stockrequestsID =$request[0]['stockrequestsID'];

        $pb=new PublicClass();
      return  $affectedRows = sell_stockrequests_warrantie
                        ::where('id', '=', $WarrantyId)
                        ->update(array(
                            'ssw_warranty_start_date' => $pb->jalali_to_gregorian_byString($warranty_start_date)  ,
                            'ssw_delivery_date' =>$pb->jalali_to_gregorian_byString($delevery_date)  ,
                            'ssw_duration_of_warranty' => $WarrantyPeriod ,
                            'ssw_duration_unit' => $WarrantyDuration
                            ));


    }
//------------------------------------------------------


public function getSavedWarrantyDataByID($request)
    {
        $warrantyID=$request['warrantyID'];
        return $serials=
            \DB::table('sell_stockrequests_warranties AS warranty')
                ->join('sell_stockrequests            AS stockrequests'    ,   'stockrequests.id' , '=' ,'warranty.ssw_stockReqID')
                ->join('sell_stockrequests_warranties_details    AS warranties_details'          ,    'warranties_details.sswd_warrantie_id'  , '=' ,'warranty.id')

                ->join('stockroom_serialnumbers           AS serialnumbers'                ,   'serialnumbers.id'                , '=' ,'warranties_details.sswd_faulty_serial')
                ->join('stockroom_stock_putting_products    AS putting_prod'                ,   'serialnumbers.stkr_srial_putting_product_id'                , '=' ,'putting_prod.id')

                ->join('custommers                       AS custommer'          ,   'custommer.id'          , '=' ,'stockrequests.sel_sr_custommer_id')
                ->join('custommerorganizations           AS ORG'                ,   'ORG.id'                , '=' ,'custommer.cstmr_organization')

                ->join('stockroom_products               AS products'           ,   'products.id'           , '=' ,'putting_prod.stkr_stk_putng_prdct_product_id')
                ->join('stockroom_products_brands        AS brands'             ,   'brands.id'             , '=' ,'products.stkr_prodct_brand')
               ->join('stockroom_products_types         AS types'              ,   'types.id'              , '=' ,'products.stkr_prodct_type')

             //   ->select('*')
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
                              stockrequests.sel_sr_delivery_date AS     stockreqDelivery_date,
                                
                              warranty.id AS warrantyID,
                              warranty.ssw_warranty_start_date AS warranty_start_date,
                              warranty.ssw_delivery_date       AS warranty_delivery_date,
                              
                              warranty.ssw_duration_of_warranty AS WarrantyPeriod,
                              warranty.ssw_duration_unit        AS WarrantyDuration,
                              
                              warranty.ssw_request_flag AS request_flag
    
                            '))
                ->where('warranties_details.sswd_warrantie_id', '=', $warrantyID)
                // ->select('*')
                ->get();
    }



}