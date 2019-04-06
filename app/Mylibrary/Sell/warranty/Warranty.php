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
use App\sell_takeoutproduct;
use App\stockroom_product_statu;
use App\stockroom_serialnumber;
use App\Stockroom_stock_putting_product;
use Illuminate\Support\Facades\Auth;
use mPDF;

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
                        ->orderby('warranty_id','')
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
                        ->where('warranties.ssw_request_flag', '=', 1) // 1 : send Request
                        ->orderby('warranty_id','')
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
                ->where('serialnumbers.stkr_srial_status', '=', 1) // 1 : serial is sold
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
        $val=
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
                              stockrequests.sel_sr_delivery_date AS     stockreqDelivery_date,
                              stockrequests.sel_sr_warranty_priod AS stockrequests_warranty_priod

                            '))
            ->where('serialnumbers.id', '=', $SerialNumberID)
           // ->select('*')
            ->get();

            $warranty_date = date('Y-m-d', strtotime("+".$val[0]->stockrequests_warranty_priod." months", strtotime($val[0]->stockreqDelivery_date)));
            $Vval = array(
                "SN_ID"=>$val[0]->SN_ID,
                "snA"=>$val[0]->snA,
                "snB"=>$val[0]->snB  ,
                "partnumber"=>$val[0]->partnumber ,
                "prodctTitle"=>$val[0]->prodctTitle,

                "Brand"=>$val[0]->Brand,
                "Type"=>$val[0]->Type  ,
                "custommerName"=>$val[0]->custommerName ,
                "custommerFamily"=>$val[0]->custommerFamily,

                "orgName"=>$val[0]->orgName,
                "stockrequestsID"=>$val[0]->stockrequestsID  ,
                "stockreqRegistr_date"=>$val[0]->stockreqRegistr_date ,
                "stockreqDelivery_date"=>$val[0]->stockreqDelivery_date,
                "Warranty_total_Expired_Date"=>$warranty_date ,
                "stockrequests_warranty_priod"=>$val[0]->stockrequests_warranty_priod ,
                "todayDate"=>date("Y-m-d")
            );
            $ret=[];
            array_push($ret,$Vval);
            return  $ret;

    }
//-----------------------------------
    function  SaveWarrantyForm ($request,$RequestStatus)
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
        $warrantyTable->ssw_request_flag=$RequestStatus;
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
                echo  $e->getMessage();
            }
        }
        return '('.$warrantyID.')'.$st;
    }
//------------------------------------------------------

    public function UpdateWarrantyForm($request,$RequestStatus)
    {
       try
       {
           $allSerials= $request[1];
           $WarrantyId=$request[2];

           $WarrantyDuration=$request[0]['WarrantyDuration'];
           $WarrantyPeriod  =$request[0]['WarrantyPeriod'];
           $delevery_date   =$request[0]['delevery_date'];
           $warranty_start_date      =$request[0]['start_date'];
           $stockrequestsID =$request[0]['stockrequestsID'];

           $pb=new PublicClass();
           $affectedRows = sell_stockrequests_warrantie
               ::where('id', '=', $WarrantyId)
               ->update(array(
                   'ssw_warranty_start_date' => $pb->jalali_to_gregorian_byString($warranty_start_date)  ,
                   'ssw_delivery_date' =>$pb->jalali_to_gregorian_byString($delevery_date)  ,
                   'ssw_duration_of_warranty' => $WarrantyPeriod ,
                   'ssw_duration_unit' => $WarrantyDuration ,
                   'ssw_request_flag' => $RequestStatus ,
               ));


           foreach ($allSerials AS $sn)
           {

               $count = sell_stockrequests_warranties_detail
                   ::where('sswd_warrantie_id', '=', $WarrantyId)
                   ->where ('sswd_faulty_serial','=',$sn['id'])
                   ->count();

               if ($count==0)
               {
                   $warranties_detail = new sell_stockrequests_warranties_detail;
                   $warranties_detail->sswd_warrantie_id=$WarrantyId;
                   $warranties_detail->sswd_faulty_serial=$sn['id'];
                   $warranties_detail->created_by=Auth::user()->id;
                   $warranties_detail->updated_by=Auth::user()->id;
                   $warranties_detail->read_status_flag=0;
                   $warranties_detail->deleted_flag=0;
                   $warranties_detail->archive_flag=0;
                   $warranties_detail->save();
               }
           }
         return 1;
       }
       catch (\Exception $e)
       {
           $e->getMessage();
       }

    }
//------------------------------------------------------
public function RemoveSerialFromList($request)
{
    $warrantyID= $request['warrantyID'];
    $SerialNumberID=$request['SerialNumberID'];

    $warranties_detail = sell_stockrequests_warranties_detail::
             where('sswd_warrantie_id', '=', $warrantyID)
            ->where('sswd_faulty_serial', '=', $SerialNumberID)
            ->delete();

}
//------------------------------------------------------


public function getSavedWarrantyDataByID($request)
    {
        $warrantyID=$request['warrantyID'];
         $val=
            \DB::table('sell_stockrequests_warranties AS warranty')
                ->join('sell_stockrequests            AS stockrequests'    ,   'stockrequests.id' , '=' ,'warranty.ssw_stockReqID')
                ->join('custommers                       AS custommer'          ,   'custommer.id'          , '=' ,'stockrequests.sel_sr_custommer_id')
                ->join('custommerorganizations           AS ORG'                ,   'ORG.id'                , '=' ,'custommer.cstmr_organization')

              // ->select('*')
               ->select( \DB::raw('

                              custommer.cstmr_name AS custommerName,
                              custommer.cstmr_family AS custommerFamily,
                              ORG.org_name AS   orgName ,

                              stockrequests.id AS  stockrequestsID ,
                              stockrequests.sel_sr_registration_date AS  stockreqRegistr_date ,
                              stockrequests.sel_sr_delivery_date AS     stockreqDelivery_date,
                              stockrequests.sel_sr_warranty_priod AS stockrequests_warranty_priod,
                              warranty.id AS warrantyID,

                              warranty.ssw_warranty_start_date AS warranty_start_date,
                              warranty.ssw_delivery_date       AS warranty_delivery_date,
                              warranty.ssw_duration_of_warranty AS WarrantyPeriod,
                              warranty.ssw_duration_unit        AS WarrantyDuration,
                              warranty.ssw_request_flag AS request_flag
                           '))
                ->where('warranty.id', '=', $warrantyID)

                ->get();

       try
       {

           $warranty_date = date('Y-m-d', strtotime("+".$val[0]->stockrequests_warranty_priod." months", strtotime($val[0]->stockreqDelivery_date)));
           $Vval = array(

               "custommerName"=>$val[0]->custommerName,
               "custommerFamily"=>$val[0]->custommerFamily,
               "orgName"=>$val[0]->orgName ,

               "stockrequestsID"=>$val[0]->stockrequestsID,
               "stockreqRegistr_date"=>$val[0]->stockreqRegistr_date,
               "stockreqDelivery_date"=>$val[0]->stockreqDelivery_date,
               "stockrequests_warranty_priod"=>$val[0]->stockrequests_warranty_priod ,
               "stockrequests_warranty_ExpiredDate"=>$warranty_date ,
               "warrantyID"=>$val[0]->warrantyID,

               "warranty_start_date"=>$val[0]->warranty_start_date,
               "warranty_delivery_date"=>$val[0]->warranty_delivery_date,
               "WarrantyPeriod"=>$val[0]->WarrantyPeriod,
               "WarrantyDuration"=>$val[0]->WarrantyDuration,
               "todayDate"=>date("Y-m-d"),
               "request_flag"=>$val[0]->request_flag ,
           );
           $ret=[];
           array_push($ret,$Vval);


           //-0-----------------

           //-------------------

           $serials= \DB::table('sell_stockrequests_warranties AS warranty')
               ->join('sell_stockrequests_warranties_details    AS warranties_details'  , 'warranties_details.sswd_warrantie_id'  , '=' ,'warranty.id')

               ->join('stockroom_serialnumbers           AS serialnumbers'                ,   'serialnumbers.id'                , '=' ,'warranties_details.sswd_faulty_serial')
               ->join('stockroom_stock_putting_products    AS putting_prod'                ,   'serialnumbers.stkr_srial_putting_product_id'                , '=' ,'putting_prod.id')

               ->join('stockroom_products               AS products'           ,   'products.id'           , '=' ,'putting_prod.stkr_stk_putng_prdct_product_id')
               ->join('stockroom_products_brands        AS brands'             ,   'brands.id'             , '=' ,'products.stkr_prodct_brand')
               ->join('stockroom_products_types         AS types'              ,   'types.id'              , '=' ,'products.stkr_prodct_type')

               ->where('warranties_details.sswd_warrantie_id', '=', $warrantyID)
//            ->select('*')
               ->select( \DB::raw('

                              serialnumbers.id                              AS SN_ID,
                              serialnumbers.stkr_srial_serial_numbers_a     AS  snA,
                              serialnumbers.stkr_srial_serial_numbers_b     AS  snB,
                              products.stkr_prodct_partnumber_commercial    AS  partnumber ,
                              products.stkr_prodct_title AS  prodctTitle,
                              warranties_details.sswd_alternative_serial AS alternative_serial_ID ,                              
                              brands.stkr_prodct_brand_title   AS  Brand,
                              types.stkr_prodct_type_title AS  Type                              
                              '))

               ->get();
           array_push($ret,$serials);

           $sn= \DB::table('sell_stockrequests_warranties_details AS warranties_details')
               ->join('stockroom_serialnumbers     AS serialnumbers'  , 'serialnumbers.id'  , '=' ,'warranties_details.sswd_alternative_serial')
               ->where('warranties_details.sswd_warrantie_id', '=', $warrantyID)
               ->select( \DB::raw('serialnumbers.stkr_srial_serial_numbers_a AS alternative_serial_sn ,
                                   serialnumbers.stkr_srial_serial_numbers_b AS alternative_serial_sn_b ,
                                   serialnumbers.id AS alternative_serial_id ,
                                   warranties_details.sswd_warrantie_id AS warrantie_id
                                   
               '))
               ->get();

           array_push($ret,$sn);

           return  $ret;

       }
       catch (\Exception $e)
       {
           $e->getMessage();
       }


    }
//------------------------------------------------------
    public function addAlternativeSerial($request)
    {

         $errorArra=array();
         $warrantyID=$request['warrantyID'];
         $faulty_serial_ID=$request['faulty_serialID'];
         $alternative_serial_String=$request['alternative_serial'];

         //--- what's faulty serial  >>>> get Product ID
          $takeoutproduct = sell_takeoutproduct::where('sl_top_product_serialnumber_id', '=', $faulty_serial_ID)->firstOrFail();
          $faulty_productid= $takeoutproduct->sl_top_productid;



       $checkSerial=stockroom_serialnumber::where('stkr_srial_serial_numbers_a', '=', $alternative_serial_String)->get();

       if (count($checkSerial))
       {
          if (!$checkSerial[0]['stkr_srial_status'])
          {

              $putting_product_id= $checkSerial[0]->stkr_srial_putting_product_id;
              $putting_product=stockroom_stock_putting_product::where('id', '=', $putting_product_id)->get();
              $product_id=$putting_product[0]->stkr_stk_putng_prdct_product_id;
               if ($product_id ==$faulty_productid)
               {


                   //add Alternative ...................................................................................
                   $AlternativeSerial_id= $checkSerial[0]['id'];
                   sell_stockrequests_warranties_detail::where ('sswd_warrantie_id','=',$warrantyID)
                                                       ->where ('sswd_faulty_serial','=',$faulty_serial_ID)
                                                       ->update(array('sswd_alternative_serial'=>$AlternativeSerial_id));

                   //Serial Number Status ...................................................................................
                   stockroom_serialnumber::where('id', '=', $faulty_serial_ID)
                                                           ->update(array('stkr_srial_status' => 2)); //AS warranty
                   stockroom_serialnumber::where('id', '=', $AlternativeSerial_id)
                                                           ->update(array('stkr_srial_status' => 1)); //AS warranty

                   //update takeoutproducts ............................................................................
                 $takeoutproduct=sell_takeoutproduct::where('sl_top_product_serialnumber_id', '=', $faulty_serial_ID)
                                                    ->firstOrFail();
                 $stockrequest_id= $takeoutproduct->sl_top_stockrequest_id;

                   sell_takeoutproduct::where('sl_top_product_serialnumber_id', '=', $faulty_serial_ID)
                    ->update(array('deleted_flag' => 1)); //AS warranty

                   $takeoutproductX =new sell_takeoutproduct;
                   $takeoutproductX->sl_top_stockrequest_id          =$stockrequest_id;
                   $takeoutproductX->sl_top_product_serialnumber_id  =$AlternativeSerial_id;
                   $takeoutproductX->sl_top_productid                =$takeoutproduct->sl_top_productid;
                   $takeoutproductX->sl_top_StockRequestRowID        =$takeoutproduct->sl_top_StockRequestRowID;
                   $takeoutproductX->deleted_flag =0;
                   $takeoutproductX->archive_flag =0;
                   $takeoutproductX->save();

                  //Product Status ......................................................................
                   $product_statu=stockroom_product_statu::where('sps_product_id', '=', $takeoutproduct->sl_top_productid)
                       ->firstOrFail();

                   $sps_available=$product_statu->sps_available;
                   $sps_warranty=$product_statu->sps_warranty;

                   stockroom_product_statu::where('sps_product_id', '=', $takeoutproduct->sl_top_productid)
                                            ->update(array('sps_available' => $sps_available-1 ,
                                                           'sps_warranty' =>   $sps_warranty+1
                                                ));
                   //---------------------

                   $msg= array("code"=>"110","error"=>"Ok","value"=>$checkSerial[0]['stkr_srial_serial_numbers_b'] ,"serialID"=>$checkSerial[0]['id']);
                   array_push($errorArra ,$msg);

                   
//                    return    array_push($errorArra ,'OK' ,$checkSerial[0]['stkr_srial_serial_numbers_b']);
               }
               else
               {
                   $msg= array("code"=>"102","error"=>"ProductIsNotValid");
                   array_push($errorArra ,$msg);
               }
          }
          else
          {
              $msg= array("code"=>"101","error"=>"SerialNotValid");
              array_push($errorArra ,$msg);
          }
       }
       else
       {
           $msg= array("code"=>"100","error"=>"serialMissMach");
           array_push($errorArra ,$msg);

       }
        return $errorArra;

    }

//-----------------------------------------
    public function delete_alternative_serial ($request)
    {

         $warrantyID= $request['warrantyID'];
         $faulty_serialID= $request['faulty_serialID'];
         $alternative_serialID= $request['alternative_serial'];

        if ($warrantyID ==null || $faulty_serialID==null || $alternative_serialID==null)
            return 'failed';
        else
        {

            sell_stockrequests_warranties_detail::where ('sswd_warrantie_id','=',$warrantyID)
                ->where ('sswd_faulty_serial','=',$faulty_serialID)
                ->update(array('sswd_alternative_serial'=>null));

//        //Serial Number Status ...................................................................................

            stockroom_serialnumber::where('id', '=', $faulty_serialID)
                ->update(array('stkr_srial_status' => 1)); //AS warranty


            stockroom_serialnumber::
            where('id', '=', $alternative_serialID)
                ->update(array('stkr_srial_status' => 0)); //AS warranty)

////        //update takeoutproducts ............................................................................
            $takeoutproduct=sell_takeoutproduct::where('sl_top_product_serialnumber_id', '=', $faulty_serialID)
                ->firstOrFail();
//
            $stockrequest_id= $takeoutproduct->sl_top_stockrequest_id;
            sell_takeoutproduct::where('sl_top_product_serialnumber_id', '=', $faulty_serialID)
                ->update(array('deleted_flag' => 0)); //AS warranty
//
            sell_takeoutproduct::where('sl_top_stockrequest_id', '=', $stockrequest_id)
                ->where('sl_top_product_serialnumber_id', '=', $alternative_serialID)
                ->delete();
//
////        //Product Status ......................................................................
            $product_statu=stockroom_product_statu::where('sps_product_id', '=', $takeoutproduct->sl_top_productid)
                ->firstOrFail();
            $sps_available=$product_statu->sps_available;
            $sps_warranty=$product_statu->sps_warranty;
//
            stockroom_product_statu::where('sps_product_id', '=', $takeoutproduct->sl_top_productid)
                ->update(array('sps_available' => $sps_available+1 ,
                    'sps_warranty' =>   $sps_warranty-1
                ));
        }
    }

//---------------------------------------------------
    public function backToWarrantyRequest ($request)
    {
        $warrantyID=$request['warrantyID'];
        sell_stockrequests_warrantie::where('id','=',$warrantyID)
                                    ->update(array('ssw_request_flag' => 2));

    }

//---------------------------------------------------
    public  function  get_alternativeSerialNumber ($sn_id)
    {
        $serialnumber = stockroom_serialnumber::find($sn_id);
        $retSN='';
        $sn1= $serialnumber->stkr_srial_serial_numbers_a;
        $sn2= $serialnumber->stkr_srial_serial_numbers_b;
        $retSN=$retSN.$sn1;
        if ($sn2 !=null)
            $retSN=$retSN.'<br/>'.$sn2;
        return $retSN;
    }
//---------------------------------------------------
    public function StockRequestIDGenerator($warrantyStockReqID ,$stockRqstRegistration_date)
    {
        $ddate=new PublicClass();
        $Jdate=$ddate->gregorian_to_jalali_byString($stockRqstRegistration_date);
        $year= $Jdate[0];
        return 'EP'.substr($year, 2, 2).'-'.$warrantyStockReqID;
    }
//---------------------------------------------------
    public function getWarrantyPdf($data)
    {
        $serials= \DB::table('sell_stockrequests_warranties AS warranty')
            ->join('sell_stockrequests_warranties_details    AS warranties_details'  , 'warranties_details.sswd_warrantie_id'  , '=' ,'warranty.id')

            ->join('sell_stockrequests    AS stockrequests'  , 'stockrequests.id'  , '=' ,'warranty.ssw_stockReqID')
            ->join('custommers            AS custommer'      , 'custommer.id'      , '=' ,'stockrequests.sel_sr_custommer_id')
            ->join('custommerorganizations      AS ORG'      , 'ORG.id'            , '=' ,'custommer.cstmr_organization')


            ->join('stockroom_serialnumbers           AS serialnumbers'                ,   'serialnumbers.id'                , '=' ,'warranties_details.sswd_faulty_serial')
            ->join('stockroom_stock_putting_products    AS putting_prod'                ,   'serialnumbers.stkr_srial_putting_product_id'                , '=' ,'putting_prod.id')

            ->join('stockroom_products               AS products'           ,   'products.id'           , '=' ,'putting_prod.stkr_stk_putng_prdct_product_id')
            ->join('stockroom_products_brands        AS brands'             ,   'brands.id'             , '=' ,'products.stkr_prodct_brand')
            ->join('stockroom_products_types         AS types'              ,   'types.id'              , '=' ,'products.stkr_prodct_type')

            ->where('warranties_details.sswd_warrantie_id', '=', $data)
//            ->select('*')
            ->select( \DB::raw('
                              warranty.id                                   AS  warrantyID,  
                              serialnumbers.id                              AS  SN_ID,
                              ORG.org_name                                  AS  orgName,
                              custommer.cstmr_name                          AS  cstmr_name,
                              custommer.cstmr_family                        AS  cstmr_family,
                              warranty.ssw_duration_of_warranty             AS  duration_of_warranty,
                              
                              warranty.ssw_stockReqID                       AS warrantyStockReqID,
                              warranty.ssw_delivery_date                    AS warrantyDelivery_date, 
                                                           
                              stockrequests.sel_sr_registration_date        AS stockRqstRegistration_date ,
                              stockrequests.sel_sr_delivery_date            AS stockRqstDelivery_date,
                              
                              serialnumbers.stkr_srial_serial_numbers_a     AS  snA,
                              serialnumbers.stkr_srial_serial_numbers_b     AS  snB,
                              products.stkr_prodct_partnumber_commercial    AS  partnumber ,
                              products.stkr_prodct_title AS  prodctTitle,
                              warranties_details.sswd_alternative_serial AS alternative_serial_ID ,                              
                              brands.stkr_prodct_brand_title   AS  Brand,
                              types.stkr_prodct_type_title AS  Type                              
                              '))

            ->get();

       $count= count($serials);
        ($serials[0]->orgName !='---')?$orgName= $serials[0]->orgName : $orgName= '';
        $cstmr_name=$serials[0]->cstmr_name;
        $cstmr_family=$serials[0]->cstmr_family;
        $duration_of_warranty=$serials[0]->duration_of_warranty;
        $StockRequestID=$this->StockRequestIDGenerator($serials[0]->warrantyStockReqID ,$serials[0]->stockRqstRegistration_date);
        //$stockRqstRegistration_date=PublicClass::gregorian_to_jalali_byString($serials[0]->stockRqstRegistration_date);

        $publicClass =new PublicClass();
        $stockRqstRegistration_date=$publicClass->gregorian_to_jalali_byString($serials[0]->stockRqstRegistration_date);
        $stockRqstDelivery_date= $publicClass->gregorian_to_jalali_byString($serials[0]->stockRqstDelivery_date);
        $warrantyDelivery_date =$publicClass->gregorian_to_jalali_byString($serials[0]->warrantyDelivery_date);
        $warrantyID =$serials[0]->warrantyID;
//-----------------------------------------
        $FaultySerial='';
        $i=0;
        foreach ($serials AS $s)
        {
            $i++;
            $FaultySerial=$FaultySerial.'<tr class=\'serialRow\'>';
            $FaultySerial=$FaultySerial.'<td style="text-align: center">'.$i.'</td>';
            $FaultySerial=$FaultySerial.'<td style="direction: ltr;text-align: left">'.$s->Brand .$s->Type .$s->prodctTitle. '</td>';
            $FaultySerial=$FaultySerial.'<td style="direction: ltr; text-align: center">'.$s->snA.'<br/>'.$s->snB.'</td>';
            $FaultySerial=$FaultySerial.'<td style="text-align: center">'.$s->partnumber.'</td>';
            $FaultySerial=$FaultySerial.'<td style="text-align: center">1</td>';
            $FaultySerial=$FaultySerial.'</tr>';
        }
//-----------------------------------------
        $AlterNativeSerials='';
        $i=0;
        foreach ($serials AS $s)
        {
            $i++;
            $AlterNativeSerials=$AlterNativeSerials.'<tr class=\'serialRow\'>';
            $AlterNativeSerials=$AlterNativeSerials.'<td style="text-align: center">'.$i.'</td>';
            $AlterNativeSerials=$AlterNativeSerials.'<td style="direction: ltr;text-align: left">'.$s->Brand .$s->Type .$s->prodctTitle. '</td>';
            $AlterNativeSerials=$AlterNativeSerials.'<td style="direction: ltr; text-align: center">'.$this->get_alternativeSerialNumber($s->alternative_serial_ID).'</td>';
            $AlterNativeSerials=$AlterNativeSerials.'<td style="text-align: center">'.$s->partnumber.'</td>';
            $AlterNativeSerials=$AlterNativeSerials.'<td style="text-align: center">1</td>';
            $AlterNativeSerials=$AlterNativeSerials.'</tr>';
        }
//-----------------------------------------


        $mpdf = new Mpdf('','A4',  0,  'vYekan',  15,  15,  60, 25,
            1,  9,   'P');
        //LANG

        //Header
        $header='<img src="img/sr_print_logo.png"  >
                 <div class="HeaderStyle  farsiFont" >
                     تاریخ :
                     <br>
                     شماره 
                     <br>
                     پیوست : ندارد
                     <br>                                  
                     صفحه  {PAGENO}از{nb}
                 </div>';
        //Footer
        $footer='<img style="margin-top: 10px " src="img/footer.png">';
        //Body
         $body="<table class='farsiFont' border='1' style='width: 100%;font-size: 16px;line-height: 25px;'>
                    <tr>
                        <td style='width: 30%'>
                            خريدار / كارفرما :
                        </td>
                        <td colspan='3' > <strong> $orgName $cstmr_name $cstmr_family </strong></td>
                    </tr>
                    
                    <tr>
                        <td>
                            شماره صورتجلسه تحويل اوليه :
                        </td>
                        <td>$StockRequestID</td>
                        <td>
                        تاريخ صورتجلسه :    
                        </td>
                        <td>$stockRqstRegistration_date[2] / $stockRqstRegistration_date[1] / $stockRqstRegistration_date[0]</td>                        
                    </tr>
                    
                     <tr>
                        <td>
                           تاريخ شروع گارانتي :
                        </td>
                        <td>$stockRqstDelivery_date[2] / $stockRqstDelivery_date[1] / $stockRqstDelivery_date[0]</td>
                        <td>
                        مدت گارانتي :    
                        </td>
                        <td>
                        $duration_of_warranty
                        ماه
                        </td>                        
                    </tr>
                    
                     <tr>
                        <td>
                          شماره صورتجلسه تحويل گارانتي :
                        </td>
                        <td>$warrantyID</td>
                        <td>
                        تاريخ تحويل :   
                        </td>
                        <td>$warrantyDelivery_date[2] / $warrantyDelivery_date[1] / $warrantyDelivery_date[0]</td>                        
                    </tr>
                    
                    <tr>
                        <td style='width: 30%;background: navy;color: white'>
                           مشخصات قطعه معيوب :
                        </td>
                        <td colspan='3' ></td>
                    </tr>                                      
                </table>
                
                <table class='farsiFont FaultySerial' border='1' style='width: 100%;font-size: 16px;line-height: 25px;'>
                    <tr style='background: navy;'>
                        <th style='width: 7%'>رديف</th>
                        <th style='width: 53%'>شرح</th>
                        <th>شماره سريال</th>
                        <th>Part Number</th>
                        <th>تعداد</th>                                                
                    </tr>                    
                        $FaultySerial                                                                 
                </table>  
                 <table class='farsiFont AlternativeSerial' border='1' style='width: 100%;font-size: 16px;line-height: 25px;'>
                    <tr>
                        <td style='width: 30%; background: navy;color: white'>
                         مشخصات قطعه جايگزين :
                        </td>
                        <td colspan='4' ></td>
                    </tr>
                 </table>
                 <table class='farsiFont AlternativeSerial' border='1' style='width: 100%;font-size: 16px;line-height: 25px;'>                  
                     <tr style='background: navy;'>
                        <th style='width: 7%'>رديف</th>
                        <th style='width: 53%'>شرح</th>
                        <th>شماره سريال</th>
                        <th>Part Number</th>
                        <th>تعداد</th>                                                
                     </tr>
                        $AlterNativeSerials                  
                </table>
                
                <br>
                
                <table border='1' class='farsiFont VerificationTable' style='width: 100%; font-size: 13px'>
                    <tr>
                        <td style='width: 50%;'>نماينده كارفرما : بدينوسيله دريافت اقلام فوق  تاييد ميگردد </td>
                        <td>نام و نام خانوادگي نماينده كارفرما:</td>                        
                    </tr>
                    <tr>
                        <td>واحد فني : عدم صحت عملكرد قطعه فوق تاييد ميگردد</td>
                        <td>نام و نام خانوادگي كارشناس فني :</td>                        
                    </tr>
                    <tr>
                        <td>واحد فروش : اعتبار گارانتي قطعه تاييد ميگردد</td>
                        <td>نام و نام خانوادگي كارشناس فروش :</td>                        
                    </tr>
                    <tr>
                        <td>واحد مالي : خروج اقلام از انبار اصلي و ثبت اسناد مالي تاييد ميگردد</td>
                        <td>نام و نام خانوادگي كارشناس مالي :</td>                        
                    </tr>
                    
                </table>
                
                
                ";



        $html =
            <<<EOT
        <!DOCTYPE>
        <html>
            <head>
             <style>
             .farsiFont
                {
                font-family: byekan !important; 
                }
             .farsiNumber
                {
                    font-family: Koodak !important;
                } 
              .HeaderStyle
              {
                text-align: right;
                padding-left: 60px;
                margin-top: 10px;                
                width: 100px;
                float: left;
              }  
              table 
               {
                border-collapse: collapse;
               } 
               .FaultySerial tr th 
               {
                    color: #fff !important; 
               }
               
               .FaultySerial tr td 
               {
                    font-size: 14px; 
               }
               
               .AlternativeSerial tr th 
               {
                    color: #fff !important;
               }               
                .AlternativeSerial tr td 
               {
                  font-size: 14px; 
               }
               
               .VerificationTable tr td
               {
                    line-height: 45px ;
               }
               .serialRow td
               {
                    height: 50px;
               }
             </style> 
            </head>
            <body style="direction: rtl">               
               <div style="font-family: byekan; text-align: center;"> 
                   <span style="font-size: 16px">
                      بسمه تعالی
                   </span>
                   <br/>
                   <span style="font-size: 20px">
                        صورتجلسه جايگزيني و تعويض دستگاه و قطعات معيوب
                   </span>                                            
               </div>  
               <br/> 
               $body
                   <br/>  
                                                                                                                                                                                                      
            </body>
        </html>
EOT;
          $mpdf->SetHTMLHeader($header);
         $mpdf->SetHTMLFooter($footer);
        //$mpdf->AddPage(); // force pagebreak
        try {
            $mpdf->WriteHTML($html);
        } catch (\MpdfException $e) {
            return $e->getMessage();
        }
        $file_name='www';
        $file_name =$file_name.$data.'.pdf';
        try {
             $mpdf->Output($file_name, 'D');
        } catch (\MpdfException $e) {
            return $e->getMessage();
        }
    }


}