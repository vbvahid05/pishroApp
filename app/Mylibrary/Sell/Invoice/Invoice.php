<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 28/05/2018
 * Time: 10:27 AM
 */

namespace App\Mylibrary\Sell\Invoice;

use App\sell_invoice;
use App\User;
use App\sell_invoice_detail ;
use App\sell_invoice_currency;
use App\Mylibrary\PublicClass;
use App\Mylibrary\NumberToString;
use App\Stockroom_products;
use App\Stockroom_products_brands;
use \App\Http\Controllers\PublicController;
use mPDF;
use Auth;

class stng_object {
    var $task;
    var $value;
}

class Invoice
{


    public function Get_all_records($request)
    {
        $data = $request->all();
        $mode=$data['mode'];
        $val = \DB::table('sell_invoices AS invoices')
             ->join('users'   ,   'users.id' , '=' ,'invoices.si_created_by')
            ->join('sell_invoice_currencies AS currency'   ,   'currency.id' , '=' ,'invoices.si_Currency')
            ->join('custommers AS custommer'              ,   'custommer.id', '=' ,'invoices.si_custommer_id')
            ->join('custommerorganizations AS org'   ,   'org.id' , '=' ,'custommer.cstmr_organization')
            ->select( \DB::raw('
                            invoices.id            AS  id,
                            invoices.si_Alias_id   AS  invoices_Alias,
                            invoices.si_date       AS  invoices_Date ,
                            invoices.si_VerifiedBy AS  VerifiedBy,
                            custommer.cstmr_name   AS  custommer_name,
                            custommer.cstmr_family AS  custommer_family,
                            org.org_name           AS  orgName,
                            users.name             AS  createdBy
                            
                                '))
            ->where('invoices.deleted_flag', '=', $mode)

            ->orderBy('id', 'Desc')
            ->get();
        return $val;
    }
    //-------------------------

    public function Get_all_curency()
    {
        return sell_invoice_currency::all();
    }
    //-------------------------
    public static function Get_all_Custommers()
    {
        $val= \DB::table('custommers AS custommer')
             ->join('custommerorganizations AS org'   ,   'org.id' , '=' ,'custommer.cstmr_organization')
              ->select( \DB::raw('
                            custommer.id   AS id,                   
                            custommer.cstmr_name   AS  custommer_name,
                            custommer.cstmr_family AS  custommer_family,
                            org.org_name           AS  orgName
                            '))

            // ->where('custommer.deleted_flag', '=', 0)
             ->where('custommer.cstmr_detials', '=', 0)
             ->get();

            $str_return='';
            foreach ( $val AS  $rr  )
            {
                $str_return=$str_return.'<option value="'.$rr->id.'">'.$rr->orgName.'('.$rr->custommer_name.' '.$rr->custommer_family.')</option>';
            }
          return $str_return;
//        return $val;
    }

    //-----------------------
    public function Generate_Invoice_id()
    {
//        $num=rand(1000,9999);
//        $num2=rand(10,100);
//        return 'INVC'.'-'.$num.'-'.$num2;
        $jy=idate("Y");$jm=idate("m");$jd=idate("d");$publicClass= new PublicClass;$date= $publicClass->convert_gregorian_to_jalali($jy,$jm,$jd);
        $PartO='EP';
        $PartI=substr($date,2,2);
        //return $PartO.$PartI;
        $tableStatus = \DB::select("show table status from  pishro_data_service where Name = 'sell_invoices'");
        if (empty($tableStatus)) {
            throw new \Exception("Table not found");
        }
        $newId= $tableStatus[0]->Auto_increment;
        $partII=$newId +10000;
        return $productCode=$PartO.$PartI.'-'.$partII;
    }


   //-----------------------
    public static function All_PartNumbers()
    {
         $val= \DB::table('stockroom_products AS products')
            ->select( \DB::raw('
                                products.id   AS id,                   
                                products.stkr_prodct_partnumber_commercial   AS  partnumber                          
                            '))
            ->where('products.deleted_flag', '=', 0)
            ->get();

        $str_return='';
        foreach ( $val AS  $rr  )
        {
            $str_return=$str_return.'<option value="'.$rr->id.'">'.$rr->partnumber.'</option>';
        }
        return $str_return;

//        return $val;
    }


    //-----------------------
    public function All_Brands()
    {
        return Stockroom_products_brands::all();
    }
    //-----------------------
    public function All_Product_Types($request)
    {
        $argdata = $request->all();
        $BrandID=$argdata['BrandID'];

        return $val= \DB::table('stockroom_products_types AS types')
            ->where('types.stkr_prodct_type_In_brands', '=', $BrandID)
            ->select( \DB::raw('
                            types.id   AS id,
                            types.stkr_prodct_type_title   AS  type_title
                            '))
            ->get();

    }
    //--------------------------------------

    public function All_Related_Products($request)
    {
        $argdata = $request->all();
        $BrandID=$argdata['BrandID'];
        $TypeID=$argdata['TypeID'];
        $TypCatID=$argdata['TypCatID'];

        return $val= \DB::table('stockroom_products AS products')
            ->where('products.stkr_prodct_brand'   , '=', $BrandID)
            ->where('products.stkr_prodct_type'    , '=', $TypeID)
            ->where('products.stkr_prodct_type_cat', '=', $TypCatID)
            ->select( \DB::raw('
                            products.id   AS id,
                            products.stkr_prodct_partnumber_commercial   AS  partnumber,
                            products.stkr_prodct_title   AS  prodct_title                          
                            '))
            ->get();
    }

    //----------------------------------
    public function select_product_by_partNum($request)
    {
        $argdata = $request->all();
        $Product_id=$argdata['Product_id'];

        return $val= \DB::table('stockroom_products AS products')
            ->join('stockroom_products_brands AS brands'   ,   'brands.id' , '=' ,'products.stkr_prodct_brand')
            ->join('stockroom_products_types  AS  types'   ,   'types.id' , '=' ,'products.stkr_prodct_type')
            ->where('products.id'   , '=', $Product_id)
            ->select( \DB::raw('
                            products.id   AS id,
                            products.stkr_prodct_partnumber_commercial   AS  partnumber,
                            products.stkr_prodct_title                   AS  prodct_title,
                            products.stkr_prodct_type_cat                AS  TypeCat,
                            products.stkr_prodct_price                   AS  price,
                            brands.stkr_prodct_brand_title               AS  brand,
                            types.stkr_prodct_type_title                 AS  type                                                            
                            '))
            ->get();

    }



    //########## ACTIONS ###############
    //########## ####### ###############
    //----------------------------------
    public function SaveInvoice_Base($request)
    {
        try{
        $data=$request->all();
        $AliasID =$data['invoice_AliasID'];
        $date =$data['invoice_date'];
        $Currency =$data['invoice_Currency'];
        $custommer =$data['invoice_custommerID'];
        $createdBy=\Auth::user()->id;

            $arDate= explode(",",$date);
            $y=$arDate[0];$yr=explode("{\"Year\":",$y); $year=$yr[1];
            $m=$arDate[1]; $mn=explode("\"Month\":",$m); $month=$mn[1];
            $d=$arDate[2];$dy=explode("\"Day\":",$d);  $day=$dy[1];
            $jconvert= new PublicClass;
            $date= $jconvert->convert_jalali_to_gregorian($year,$month,$day,$mod='');

            $invoice = new sell_invoice;
            $invoice->si_Alias_id = $AliasID;
            $invoice->si_Currency = $Currency;
            $invoice->si_custommer_id = $custommer;
            $invoice->si_date = $date;
            $invoice->si_created_by = $createdBy;
            $invoice->si_tax_setting_status =true;
            $invoice->deleted_flag=0;
            $invoice->archive_flag=0;
            $invoice->save();
            //----------------
            $LastID = \DB::table('sell_invoices')
                ->orderBy('sell_invoices.id', 'desc')
                ->select('id', \DB::raw('sell_invoices.id AS invoicesID '))
                ->limit(1)
                ->get();

            return $LastID;
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

//----------------------------
    public function add_product_to_invoice_DB($request)
    {
        $data=$request->all();
        $invoicesID =$data['invoicesID'];
        $productArray=$data['productArray'];
        $invoice_details_Array= $data['invoice_detilas_Array'];
        try{

            foreach ($productArray as $pdary)
            {
                $pdary['TotalPrice'];
                $invoiceDetiles= new sell_invoice_detail();
                $invoiceDetiles->sid_invoice_id=$invoicesID;
                $invoiceDetiles->sid_product_id= $pdary['product_id'];
                $invoiceDetiles->sid_qty=$pdary['qty'];
                $invoiceDetiles->sid_Unit_price=$pdary['Unit_price'];
                if ($pdary['EPL_price']=='--')
                    $invoiceDetiles->sid_EPL_price=1;
                else
                    $invoiceDetiles->sid_EPL_price=$pdary['EPL_price'];
                $invoiceDetiles->deleted_flag=0;
                $invoiceDetiles->archive_flag=0;
                $invoiceDetiles->save();
            }
            //--------------
            $i=0;
            foreach ($invoice_details_Array as $invc_dtls_ary)
            {
                if ($invc_dtls_ary['key']=="warranty")
                  sell_invoice::where('id', '=', $invoicesID)->update(array('si_warranty' => $invc_dtls_ary['value']));
                if ($invc_dtls_ary['key']=="Payment")
                  sell_invoice::where('id', '=', $invoicesID)->update(array('si_Payment' => $invc_dtls_ary['value']));
                if ($invc_dtls_ary['key']=="deliveryDate")
                   sell_invoice::where('id', '=', $invoicesID)->update(array('si_deliveryDate' => $invc_dtls_ary['value']));
                if ($invc_dtls_ary['key']=="Discount")
                    sell_invoice::where('id', '=', $invoicesID)->update(array('si_Discount' => $invc_dtls_ary['value']));
                if ($invc_dtls_ary['key']=="Description")
                    sell_invoice::where('id', '=', $invoicesID)->update(array('si_Description' => $invc_dtls_ary['value']));
                $i++;
            }
            return $i;
         }
        catch (\Exception $ex)
        {
            return $ex->getMessage();
        }
    }

//-----------------//-----------------//-----------------
//-----------------//-----------------//-----------------
    public function Get_Selected_invoice_Data ($request)
    {
        $master_array=[];
        $data=$request->all();
        $invoicesID =$data['invoicesID'];
        $invoiceInfo=\DB::table ('sell_invoices AS invoice')
            ->join('sell_invoice_currencies AS currency','currency.id','=','invoice.si_Currency')
            ->join('custommers' ,'custommers.id','=','invoice.si_custommer_id')
            ->join('custommerorganizations AS org' ,'org.id','=','custommers.cstmr_organization')
            ->where('invoice.id','=',$invoicesID)
            ->select('*', \DB::raw('invoice.id AS invoiceId'))
            ->get();
        array_push($master_array,$invoiceInfo);

        $created_by=$invoiceInfo[0]->si_created_by;
        if ($invoiceInfo[0]->si_VerifiedBy !=null)
             $verified_By= $invoiceInfo[0]->si_VerifiedBy;
        else $verified_By= null;
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $invoiceDate=\DB::table ('sell_invoice_details AS invoice_detail')
            ->join('stockroom_products AS products','products.id','=','invoice_detail.sid_product_id')
            ->join('stockroom_products_brands AS brands','brands.id','=','products.stkr_prodct_brand')
            ->join('stockroom_products_types  AS types', 'types.id','=','products.stkr_prodct_type')
            ->where('invoice_detail.sid_invoice_id','=',$invoicesID)
            ->where('invoice_detail.sid_parent','=',null)

            //->select('*')
            ->select( \DB::raw('
                            products.id                      AS id ,
                            products.stkr_prodct_partnumber_commercial    AS partNumber ,
                            products.stkr_prodct_type_cat    AS typeCat ,
                            brands.stkr_prodct_brand_title   AS  product_brand,
                            types.stkr_prodct_type_title     AS  product_Type,
                            products.stkr_prodct_title       AS  product_Title,
                            invoice_detail.id                AS  invoiceDetail_Id,
                            invoice_detail.sid_qty           AS  qty,
                            invoice_detail.sid_Unit_price    AS  Unit_price,
                            invoice_detail.sid_EPL_price     AS  EPL_price,   
                            invoice_detail.sid_parent        AS  parent_id                                                                                                                   
                            '))
            ->get();

        $Data_array=array();
        $TotalPrice=0;
        $Total_EPL_price=0;
        $total_SubChassis_EPL_price=0;
        $TotalQty=0;
        $ArrayCount=0;
        foreach ($invoiceDate as $inv_data)
        {
            $ArrayCount++;
            $invoiceDetail_Id =$inv_data->invoiceDetail_Id;
             $invoiceSubProductDate=\DB::table ('sell_invoice_details AS invoice_detail')
                         ->join('stockroom_products AS products','products.id','=','invoice_detail.sid_product_id')
                         ->where('invoice_detail.sid_parent','=',$invoiceDetail_Id)
                        ->select('*', \DB::raw('products.stkr_prodct_title AS product_Title ,
                                                products.stkr_prodct_partnumber_commercial AS partNumber ,
                                                invoice_detail.sid_qty           AS  qty,
                                                products.stkr_prodct_price       AS  EPL_price                                                                                                
                                                '))
                         ->orderBy('sid_position', 'ASC')
                         ->orderBy('invoice_detail.id', 'ASC')
                         ->get();
            $ArrayCount=$ArrayCount+count($invoiceSubProductDate);

            foreach ($invoiceSubProductDate as   $invoSubProDate  )
            {
                if ($invoSubProDate->stkr_prodct_price !=null)
                    $total_SubChassis_EPL_price=$total_SubChassis_EPL_price+ ($invoSubProDate->stkr_prodct_price*$invoSubProDate->qty);
            }



            if ($inv_data->EPL_price=='--') $epl=0; else $epl=$inv_data->EPL_price;
            $temArray=array(
                         'invoice_id' =>$invoicesID,
                         'invoiceDetail_Id' =>$inv_data->invoiceDetail_Id,
                         'product_id'=>$inv_data->id,
                         'partNumber' => $inv_data->partNumber,
                         'product_typeCat'=>$inv_data->id,
                         'product_brand' =>$inv_data->product_brand,
                         'product_Type' =>$inv_data->product_Type,
                         'product_Title' =>$inv_data->product_Title,
                         'qty' =>$inv_data->qty,
                         'Unit_price' =>$inv_data->Unit_price,
                         'TotalPrice'=> $inv_data->qty*$inv_data->Unit_price,
                         'EPL_price' =>$epl,
                         'Total_EPL_price' =>  $epl *$inv_data->qty ,
                         'SubProductData' =>$invoiceSubProductDate
                        );
            array_push($Data_array,$temArray);
            $TotalPrice =$TotalPrice +($inv_data->Unit_price*$inv_data->qty);
            $Total_EPL_price=$Total_EPL_price+($epl*$inv_data->qty);
            $TotalQty=$TotalQty+$inv_data->qty;
        }
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        array_push($master_array,$Data_array);
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
       $user= User::findOrFail($created_by);

       if ($verified_By !=null)
       {
           $verified_By_User =User::findOrFail($verified_By);
           $verified_By_User_Name=$verified_By_User['name'];
       }
       else $verified_By_User_Name='';

        $ToalArray=array(
                        'TotalPrice'=>$TotalPrice,
                        'Total_EPL_price'=>$Total_EPL_price+$total_SubChassis_EPL_price,
//                        'Total_SubChassis_EPL_price'=>$total_SubChassis_EPL_price ,
                        'TotalQty'=>$TotalQty,
                        'CreatedBy'=>$user['name'] ,
                        'verified_By'=>$verified_By_User_Name ,
                        'ArrayCount' => $ArrayCount ,
        );

        array_push($master_array,$ToalArray);
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        return $master_array;
    }

//(((((((((((((((((((((((((((((((
    public function  Edit_Invoice($request)
    {

         $data=$request->all();
         $invcData= $data['ProductArray'];
         $invoice_desc= $data['desc'];
         $invID = $invcData['invoice_id'];
        try
            {
//                foreach ($InvoiceData as $invcData)
//                {
                    $prodctID= $invcData ['product_id'] ;
                    $count =  sell_invoice_detail:: where('sid_invoice_id', '=', $invID)->where('sid_product_id', '=', $prodctID)->count();
                    if ($count) //*** Must Be Edit
                    {
                        return 'duplicated';
                        //return '';
                    }
                    else        //*** Its New ,Insert to DB
                    {
                        $invoice_detail = new sell_invoice_detail;
                        $invoice_detail->sid_invoice_id = $invID;
                        $invoice_detail->sid_product_id = $invcData['product_id'];
                        $invoice_detail->sid_qty = $invcData['qty'];
                        $invoice_detail->sid_Unit_price=$invcData['Unit_price'];
                        $invoice_detail->sid_EPL_price=$invcData['EPL_price'];
                        $invoice_detail->deleted_flag=0;
                        $invoice_detail->archive_flag=0;
                        $invoice_detail->save();
                    }
               // }

                sell_invoice::where('id', '=', $invID) ->update(array('si_Description' => $invoice_desc));
                return 'Saved';
            }
        catch (\Exception $ed)
        {
            return $ed->getMessage();
        }
    }
//-------------------
    public function save_invoice_Desc ($request)
    {

        $data=$request->all();
        $Description_input= $data['Description_input'];
        $invoicesID= $data['invoicesID'];
return  sell_invoice::where('id', '=', $invoicesID) ->update(array('si_Description' => $Description_input));
    }

//-------------------

    public  function Confirm_Invoice( $request)
    {
        $data=$request->all();
        $InvoiceID= $data['invoice_ID'];
        $currentUserID=\Auth::user()->id;
        sell_invoice::where('id', '=', $InvoiceID) ->update(array('si_VerifiedBy' => $currentUserID));
        return 1 ;
    }
//-------------------
    public function  delete_selected_invoice($request)
    {
        $data=$request->all();
        $InvoiceID= $data['selectesRowId'];
        $deleteMode=$data['Delete_mode'];

        try
        {
            $rr= \DB::table ('sell_invoice_details AS invoice_detail')
            ->where('invoice_detail.sid_invoice_id','=',$InvoiceID)
            ->get();

            foreach ($rr as $r)
            {

             if ($deleteMode==0) //
             {
                 \DB::table('sell_invoice_details')
                     ->where('id', $r->id)
                     ->update(['deleted_flag' => 1]);
             }
             else if ($deleteMode==1)  //full Delete
                 sell_invoice_detail::destroy($r->id);
             else if ($deleteMode==2)  //Restore
             {
                 \DB::table('sell_invoice_details')
                     ->where('id', $r->id)
                     ->update(['deleted_flag' => 0]);
             }
            }

            if ($deleteMode==0) {
                \DB::table('sell_invoices')
                    ->where('id', $InvoiceID)
                    ->update(['deleted_flag' => 1]);
            }
            else if ($deleteMode==1)  //full Delete
                sell_invoice::destroy($InvoiceID);
            else if ($deleteMode==2)  //Restore
            {
                \DB::table('sell_invoices')
                    ->where('id', $InvoiceID)
                    ->update(['deleted_flag' => 0]);
            }

            return $InvoiceID;
        }
        catch (\Exception $ex)
        {
             $ex->getMessage();
        }
    }
//-------------------
    public function Update_invoice_qrt($request)
    {
        try {
            $data = $request->all();
            $InvoiceID = $data['invoiceID'];
            $producID = $data['producID'];
            $newQTY = $data['NewQTY'];

            $updateStep1 = \DB::table('sell_invoice_details')
                ->where('sid_invoice_id', $InvoiceID)
                ->where('sid_product_id', $producID)
                ->update(['sid_qty' => $newQTY]);
        }
        catch(\Exception $exception)
        {
            return $exception->getMessage();
        }

    }

//-------------------
    public function Update_invoice_price($request)
    {
       try{
        $data=$request->all();
        $InvoiceID= $data['invoiceID'];
        $producID= $data['producID'];
        $NewPrice = $data['NewPrice'];

        $updateStep2 = \DB::table('sell_invoice_details')
            ->where('sid_invoice_id', $InvoiceID)
            ->where('sid_product_id', $producID)
            ->update(['sid_Unit_price' => $NewPrice]);
       }
       catch(\Exception $exception)
       {
           return $exception->getMessage();
       }

    }
  //-------------
   public function update_invoice_description($request)
   {
      try
      {
          $data=$request->all();
          $InvoiceID= $data['invoicesID'];
          $task= $data['task'];
          $NewValue= $data['NewValue'];

          switch ($task)
          {
              case 'warranty':
                  sell_invoice::where('id', '=', $InvoiceID) ->update(array('si_warranty' => $NewValue));
                    return 1;
                  break;
              case 'Payment':
                  sell_invoice::where('id', '=', $InvoiceID) ->update(array('si_Payment' => $NewValue));
                  return 1;
                  break;
              case 'Discount':
                  sell_invoice::where('id', '=', $InvoiceID) ->update(array('si_Discount' => $NewValue));
                  return 1;
                  break;

              case 'deliveryDate':
                  sell_invoice::where('id', '=', $InvoiceID) ->update(array('si_deliveryDate' => $NewValue));
                  return 1;
                  break;

              case 'invoice_delivery_Type':
                  sell_invoice::where('id', '=', $InvoiceID) ->update(array('si_delivery_type' => $NewValue));
                  return 1;
                  break;


              case 'Description':
                  sell_invoice::where('id', '=', $InvoiceID) ->update(array('si_Description' => $NewValue));
                  return 1;
                  break;

              case 'validityDuration':
                  sell_invoice::where('id', '=', $InvoiceID) ->update(array('si_validityDuration' => $NewValue));
                  return 1;
                  break;
          }
      }
      catch (\Exception $e) {return $e->getMessage();}
   }
//-------------

    public function delete_item_From_Invoice_List($request)
    {
        $data=$request->all();
        $invoice_id= $data['invoiceID'];
        $product_id= $data['producID'];
            try
            {
                $rowID = sell_invoice_detail::where('sid_invoice_id', '=', $invoice_id)
                ->where('sid_product_id', '=', $product_id)
                ->select('id')
                ->firstOrFail();



                //..........
                try
                {
                $parent=$rowID->id;
                 sell_invoice_detail::where('sid_parent', '=', $parent)
                        ->delete();
                sell_invoice_detail::destroy($rowID->id);
                return 1;
                }
                catch (\Exception $e)
                {  return 400 ;}



            }

            catch (\Exception $e)
            {
                return 404 ;
            }
        //----------------



    }
//-------------------
    public function Copy_Invoice($request)
    {
        $data=$request->all();
        $invoiceTargetID= $data['invoiceTargetID'];
        $InvoiceHaveDetails=false;
        //1- get invoice Data by  invoiceTargetID
         $CheckInvoiceDetailsCount = sell_invoice_detail::where('sid_invoice_id', '=', $invoiceTargetID)->count();
        if ($CheckInvoiceDetailsCount)
        {
             $val = \DB::table('sell_invoices AS invoices')
                ->join('sell_invoice_details AS invoice_details'   ,   'invoice_details.sid_invoice_id' , '=' ,'invoices.id')
                ->select('*')
                ->where('invoices.id', '=', $invoiceTargetID)
                ->get();

            $InvoiceHaveDetails=true;
        }
        else
        {
             $val = sell_invoice ::where('id', '=', $invoiceTargetID) ->get();
        }

        //2- in a Loop ->  Insert new Item In sell_invoices And sell_invoice_details Tables
            if ($val)
            {
                //$Alias_id='copy-'.$val[0]->si_Alias_id;
                $Alias_id=$this->Generate_Invoice_id();
                $Currency=$val[0]->si_Currency;
                $custommerID=$val[0]->si_custommer_id;
                $date=$val[0]->si_date;
                $Discount=$val[0]->si_Discount;
                $warranty=$val[0]->si_warranty;
                $Payment=$val[0]->si_Payment;
                $deliveryDate=$val[0]->si_deliveryDate;
                $Description=$val[0]->si_Description;
                $pdf_settings=$val[0]->si_pdf_settings;
                $delivery_type =$val[0]->si_delivery_type;
                $validityDuration =$val[0]->si_validityDuration;
                $deleted_flag=$val[0]->deleted_flag;
                $archive_flag=$val[0]->archive_flag;
                $createdBy=\Auth::user()->id;

                //--------------------
                try {
                    $new_invoice = new sell_invoice;
                    $new_invoice->si_Alias_id = $Alias_id;
                    $new_invoice->si_Currency = $Currency;
                    $new_invoice->si_custommer_id = $custommerID;
                    $new_invoice->si_date = $date;
                    $new_invoice->si_Discount = $Discount;
                    $new_invoice->si_warranty = $warranty;
                    $new_invoice->si_Payment = $Payment;
                    $new_invoice->si_deliveryDate = $deliveryDate;
                    $new_invoice->si_delivery_type = $delivery_type;
                    $new_invoice->si_validityDuration = $validityDuration;
                    $new_invoice->si_pdf_settings = $pdf_settings;
                    $new_invoice->si_Description = $Description;
                    $new_invoice->si_created_by=   $createdBy;
                    $new_invoice->deleted_flag = $deleted_flag;
                    $new_invoice->archive_flag = $archive_flag;
                    $new_invoice->save();
                        //$baseCopyStatue=true;
                    $lastInvoiceInsertId=\DB::getPdo('sell_invoices')->lastInsertId();
                    }
                    catch (\Exception $e)
                    {
                        $e->getMessage();
                    }
                $lastPatent=null;
                if ($lastInvoiceInsertId && $InvoiceHaveDetails)
                {
                    foreach ($val AS $v)
                    {

                        if($v->sid_parent==null) //it's Parent
                        {
                            $new_invoice_details = new  sell_invoice_detail;
                            $new_invoice_details->sid_invoice_id = $lastInvoiceInsertId;
                            $new_invoice_details->sid_product_id = $v->sid_product_id;
                            $new_invoice_details->sid_qty        = $v->sid_qty;
                            $new_invoice_details->sid_Unit_price = $v->sid_Unit_price;
                            $new_invoice_details->sid_EPL_price  = $v->sid_EPL_price;
                            $new_invoice_details->sid_parent     = null;
                            $new_invoice_details->deleted_flag   = $v->deleted_flag;
                            $new_invoice_details->archive_flag   = $v->archive_flag;
                            $new_invoice_details->save();
                            //----------
                            $sid= sell_invoice_detail::orderBy('id', 'desc')->first();
                            $lastPatent=$sid->id;
                            //----------

                            $valStep2 = \DB::table('sell_invoice_details AS invoice_details')
                                ->select('*')
                                ->where('invoice_details.sid_parent', '=',  $v->id)
                                ->where('invoice_details.sid_invoice_id', '=', $invoiceTargetID)
                                ->get();

                            //----------
                            if ($valStep2!=null)
                            {
//                                 $lastPatent = \DB::getPdo()->lastInsertId();


                                foreach ($valStep2 AS $vsII)
                                {
                                    $new_invoice_details = new  sell_invoice_detail;
                                    $new_invoice_details->sid_invoice_id = $lastInvoiceInsertId;
                                    $new_invoice_details->sid_product_id = $vsII->sid_product_id;
                                    $new_invoice_details->sid_qty        = $vsII->sid_qty;
                                    $new_invoice_details->sid_Unit_price = $vsII->sid_Unit_price;
                                    $new_invoice_details->sid_EPL_price  = $vsII->sid_EPL_price;
                                    $new_invoice_details->sid_parent     = $lastPatent;
                                    $new_invoice_details->deleted_flag   = $vsII->deleted_flag;
                                    $new_invoice_details->archive_flag   = $vsII->archive_flag;
                                    $new_invoice_details->save();
                                }
                            }
                            //----------
                        }





//                        if($v->sid_parent==null)
//                        {
//                            $parentID =null;
//                        }
//                        else
//                        {
//                            $parentID= $lastPatent;
//                        }
//
//                        $new_invoice_details = new  sell_invoice_detail;
//                        $new_invoice_details->sid_invoice_id = $lastInvoiceInsertId;
//                        $new_invoice_details->sid_product_id = $v->sid_product_id;
//                        $new_invoice_details->sid_qty        = $v->sid_qty;
//                        $new_invoice_details->sid_Unit_price = $v->sid_Unit_price;
//                        $new_invoice_details->sid_EPL_price  = $v->sid_EPL_price;
//                        $new_invoice_details->sid_parent     = $parentID;
//                        $new_invoice_details->deleted_flag   = $v->deleted_flag;
//                        $new_invoice_details->archive_flag   = $v->archive_flag;
//                        $new_invoice_details->save();
//                        if ($v->sid_parent==null)
//                        {
//                            $lastPatent = \DB::getPdo()->lastInsertId();
//                        }

                    }
                    return "AllSaveed";
                }
                else return 'Error:: invoiceBase Saved But invoice_details Faild';
            }
            return $val;

        //3-return ->reload Invoice List

    }

    //-----------------
    public function edit_invoice_Base_data($request)
    {
        $data=$request->all();
        $invoiceTargetID= $data['invoicesID'];

       $new_date= $data['new_date'];
        $arDate= explode("/",$new_date);
        $y=$arDate[0] ;$m=$arDate[1] ;$d=$arDate[2] ;
        $jconvert= new PublicClass;
        $new_date= $jconvert->convert_jalali_to_gregorian($y,$m,$d);
        $new_Currency= $data['new_Currency'];
        $new_custommerID= $data['new_custommerID'];

        try{
            sell_invoice::where('id', '=', $invoiceTargetID)
                ->update(array('si_Currency' => $new_Currency ,
                    'si_custommer_id' =>$new_custommerID,
                    'si_date' => $new_date
                ) );
            return 1;
        }
        catch (\Exception $exception)
        {
            return $exception->getMessage();
        }
    }
//-------------------------------

public function add_subProduct_in_Invoice   ($request)
{

    $data=$request->all();
    $invoiceID= $data['invoiceID'];
    $parentProduct_id= $data['parentProduct_id'];
    $SubproductID= $data['SubproductID'];
    $Qty= $data['Qty'];
    //----------------------
    $count = sell_invoice_detail::where('sid_invoice_id', '=',$invoiceID )
                                ->where('sid_parent', '=',$parentProduct_id )
                                ->count();



       try{
         $check=sell_invoice_detail::where('sid_invoice_id', '=',$invoiceID )
        ->where('sid_parent', '=',$parentProduct_id )
        ->orderBy('sid_position','DESC')
        ->firstOrFail();
        $last=$check['sid_position'];
       }catch (\Exception $exception){
           $last =0; $count=0;
       }
        if ( ($last == $count) || $count==0 )
            $count++;
        else if ($count < $last)
            $count=$last+1;


    $stockrequest = new  sell_invoice_detail;
    $stockrequest->sid_invoice_id = $invoiceID;
    $stockrequest->sid_product_id = $SubproductID;
    $stockrequest->sid_qty = $Qty;
    $stockrequest->sid_Unit_price=0;
    $stockrequest->sid_parent=$parentProduct_id;
    $stockrequest->sid_position=$count;
    $stockrequest->deleted_flag=0;
    $stockrequest->archive_flag=0;
    $stockrequest->save();
}
//-------------------------------

    public function get_subProduct_list_invoice   ($request)
    {
        $data=$request->all();
        $invoiceID=$data['invoiceID'];
        $parentProduct_id= $data['parentProduct_id'];

      return \DB::table('sell_invoice_details AS invoice_details')
            ->join('stockroom_products AS products'   ,   'products.id' , '=' ,'invoice_details.sid_product_id')
            ->select('*', \DB::raw('invoice_details.id as  invoice_detailsID'))

            ->where('invoice_details.sid_invoice_id', '=', $invoiceID)
            ->where('invoice_details.sid_parent', '=', $parentProduct_id)
            ->orderBy('sid_position', 'ASC')
            ->orderBy('invoice_details.id', 'ASC')

            ->get();

    }
//-------------------------------
    public function delete_subProduct_from_list_invoice($request)
    {
        $data=$request->all();
        $invoiceDetialsID=$data['invoiceDetialsID'];
        sell_invoice_detail::destroy($invoiceDetialsID);
        return 1;
    }


//-------------------------------
//
    public function delete_restore_Invoice($request)
    {
        $data=$request->all();
        $InvoiceIDArray= $data['InvoiceIDArray'];
        $mode=$data['mode'];

        if ($mode==0) //Move Group To Trash
        {
            foreach ($InvoiceIDArray as $inva)
            {
                \DB::table('sell_invoices')
                    ->where('id', $inva)
                    ->update(['deleted_flag' => 1]);
            }
        }
        else if ($mode==1) //Resore Group From Trash
        {
            foreach ($InvoiceIDArray as $inva)
            {
                \DB::table('sell_invoices')
                    ->where('id', $inva)
                    ->update(['deleted_flag' => 0]);
            }
        }

        else if ($mode==2) //Full Delete From DB
        {
            foreach ($InvoiceIDArray as $invaID)
            {

                 $SubInvoiceList = sell_invoice_detail::
                              where('sid_invoice_id', '=', $invaID)
                              ->get();
                //-----
                foreach ($SubInvoiceList AS $SIVL)
                {
                    sell_invoice_detail::destroy($SIVL->id);
                }
                //----------
                sell_invoice::destroy($invaID);
            }
        }
    }
//--------------------
    public function setTaxStatus($request)
    {
        $data=$request->all();
        if ($data['TaxStatus'])
        {
            sell_invoice::where('id', '=', $data['invoicesID']) ->update(array('si_tax_setting_status' => true ));
        }
        else sell_invoice::where('id', '=', $data['invoicesID']) ->update(array('si_tax_setting_status' => false ));
        // return $InvoiceIDArray= $data['TaxStatus'];
    }
//--------------------


    public function  setPDFStingAction($req)
    {
        $invoiceID= $req['invoiceIDs'];
        $task= $req['task'];
        $value=$req['value'];
        //-------------------------------
        $count=0;
        $model = sell_invoice::find($invoiceID);
        $si_pdf_settings= $model['si_pdf_settings'];
        $st="";
        if ($si_pdf_settings !=null)
        {
            $oldArray= json_decode($si_pdf_settings,'true');
            foreach ($oldArray as $oa)
            {
                try{
                        if ($oa[$task]  ||  $oa[$task]==null )
                    {
                        $count++;
                        //return   $st=$task.$oa[$task].$count;
                    }
                }
                catch (\Exception $e)
                {
                    // return $e->getMessage();
                }
            }
            //-------------------------------
            if($count ==0)
            {
                $oArrayd=  array(
                    $task => $value ,
                );
                array_push($oldArray ,$oArrayd);
                $myJSON=    json_encode($oldArray);
                sell_invoice::where('id', '=', $invoiceID) ->update(array('si_pdf_settings' => $myJSON));
                return 'New Added';
            }
            else
            {
                // rewrite array
               try
               {
                   $newArray=[];
                   $ary_count=count($oldArray) ;
//------------Remove Old item from list
                   for($i=0;$i<=$ary_count-1;$i++ )
                   {
                      try{
                          if ($oldArray[$i][$task])
                              $q=0;

                      }
                      catch (\Exception $e)
                      {
                          $singleArray=$oldArray[$i];
                          array_push($newArray ,$singleArray);

                      }
                   }
//---------------add  Numeral Or text value to list Array
                   $oArrayd=  array(
                       $task => $value ,
                   );
                   if ($value !='boolean')
                       array_push($newArray ,$oArrayd);

//-----------Update DB
                   $myJSON=json_encode($newArray);
                   sell_invoice::where('id', '=', $invoiceID) ->update(array('si_pdf_settings' => $myJSON));
                   return 'Updated ;)';
               }
                catch (\Exception $e)
                {
                    return $e->getMessage();
                }
            }
        }
        else
        {
            $oldArray=[];
            $oArrayd=  array(
                $task => $value ,
            );
            array_push($oldArray ,$oArrayd);
            $myJSON=    json_encode($oldArray);
            try{
                sell_invoice::where('id', '=', $invoiceID) ->update(array('si_pdf_settings' => $myJSON));
                return 'New Added';
            }
            catch (\Exception $e)
            {  return $e->getMessage();}
        }
    }
//--------------------
    public function updateNewSubProduct_Qty ($req)
    {
         $Qty= (int)$req['new_Qty'];
        $invoiceID= $req['invoiceID'];
        $parentProduct_id=$req['parentProduct_id'];
        $producID =$req['producID'];

         try{
             sell_invoice_detail::
             where('sid_invoice_id', '=', $invoiceID)
                 ->where('sid_parent', '=', $parentProduct_id)
                 ->where('sid_product_id', '=', $producID)
                 ->update(array('sid_qty' => $Qty));
             return 1;
         }
         catch (\Exception $e)
         {
             return $e->getMessage();}
    }
//--------------------
    public function SearchInvoice($req)
    {
         $keyWord=$req['SearchForKey'];
     return   $AllProducts = \DB::table('sell_invoice_details')
            ->join('sell_invoices AS invoices', 'invoices.id', '=', 'sell_invoice_details.sid_invoice_id')
            ->join('stockroom_products AS products', 'products.id', '=', 'sell_invoice_details.sid_product_id')
            ->where('products.stkr_prodct_partnumber_commercial', 'LIKE', "%$keyWord%" )
            ->orWhere('products.stkr_prodct_title', 'LIKE', "%$keyWord%")
//            ->where('products.stkr_prodct_title', 'LIKE', "%$keyWord%")
            ->select('*','invoices.id as rowID')
            ->orderBy('invoices.si_date', 'desc')
//           ->orderBy('sell_invoice_details.sid_product_id', 'desc')
            ->get();
    }

      private function find_Position ($invoiceID ,$position ,$action){
            $items = sell_invoice_detail::where('sid_invoice_id', '=',$invoiceID)
            ->where('sid_parent', '!=', null)
             ->orderBy('sid_position' ,'ASC')
            ->get();

          for($i=0; $i<=count($items) ;$i++)
          {
              if ($items[$i]['sid_position']== $position) {
                  if ($action =='up')
                    return $items[$i-1]['sid_position'];
                  else
                      return $items[$i+1]['sid_position'];
              }
          }
    }
//--------------------
   public function changePosition ($req)
   {
        $doing =$req['doing'];
        $position = $req['position'];
        $invoiceID= $req['invoiceID'];
        $currentRecord = sell_invoice_detail::where('sid_invoice_id', '=',$invoiceID)
                                                  ->where('sid_position', '=',$position)
                                                  ->firstOrFail();
        $currentRecordID=$currentRecord['id'];
        switch ($doing){
            case 'up' :
               //find Last record ID
               try{
                     $lastPosition= $this->find_Position($invoiceID ,$position ,'up');
                     $lastRecord = sell_invoice_detail::where('sid_invoice_id', '=',$invoiceID)
                                                      ->where('sid_position', '=',$lastPosition)->firstOrFail();
                 echo   $lastRecordID=$lastRecord['id'];

                    sell_invoice_detail::where('id', '=', $currentRecordID)
                       ->update(array('sid_position' => $lastPosition));

                    sell_invoice_detail::where('id', '=', $lastRecordID)
                       ->update(array('sid_position' => $position));
                  // return 1;
               }
               catch (\Exception $exception) { return $exception->getCode(); }
               // change position


            break;
            case 'down' :
                try{

                    $NextPosition= $this->find_Position($invoiceID ,$position ,'down');
                    $NextRecord = sell_invoice_detail::where('sid_invoice_id', '=',$invoiceID)
                                                     ->where('sid_position', '=',$NextPosition)->firstOrFail();
                    $NextRecordID=$NextRecord->id;
                    sell_invoice_detail::where('id', '=', $currentRecordID)
                        ->update(array('sid_position' => $NextPosition));
                    sell_invoice_detail::where('id', '=', $NextRecordID)
                        ->update(array('sid_position' => $position));
                    return 1;
                }
                catch (\Exception $exception) { return $exception->getCode(); }
                // change position

            break;
        }
   }
//--------------------
    public  function  getPDFStings($req)
    {
        $invoiceID= $req['invoiceIDs'];
        $model = sell_invoice::find($invoiceID);
      return  $si_pdf_settings= $model['si_pdf_settings'];
    }
//--------------------
    public function getPdf($data)
    {

        $InvoiceInfo=$data[0][0];
        $productList=$data[1];
        $invoiceTolalInfo=$data[2];
        $invoice_Setting=json_decode($InvoiceInfo->si_pdf_settings,'true');
         $dateConvert=new PublicClass();
        //--------------------------------
        $ee="";
     // Defult Value
        $stng_customerName=false;
        $stng_changeDirection=false;
        $stng_header_To_InvoiceBody=0;
        $space_date_To_sellerInfo=0;
        $space_seller_To_InvoiceTable=0;
        $space_InvoiceTable_To_DescriptionTable=0;
        $stng_signature_Table_height=90;
        $stng_mainTableFontSize=12;
        $stng_Desc_fontSize=12;


        if (count($invoice_Setting))
        {
            foreach ($invoice_Setting as $IVsetting)
            {
                foreach ($IVsetting AS $key=>$value)
                {
                    switch ($key)
                    {
                        case 'stng_customerName':
                            $stng_customerName=true;
                            break;
                        case 'stng_changeDirection':
                            $stng_changeDirection=true;
                            break;
                        case 'stng_header_To_InvoiceBody':
                            $stng_header_To_InvoiceBody=$value;
                            break;

                        case 'stng_date_To_sellerInfo':
                             $space_date_To_sellerInfo=$value;
                            break;
                        case 'stng_seller_To_InvoiceTable':
                             $space_seller_To_InvoiceTable=$value;
                        break;
                        case 'stng_InvoiceTable_To_DescriptionTable':
                             $space_InvoiceTable_To_DescriptionTable=$value;
                        break;

                        case 'stng_signature_Table_height':
                            $stng_signature_Table_height=$value;
                            break;
                        case 'stng_mainTableFontSize':
                            $stng_mainTableFontSize=$value;
                            break;
                        case 'stng_Desc_fontSize':
                            $stng_Desc_fontSize=$value;
                            break;



                    }
                }
            }
        }

   $custommerName=($stng_customerName ?  '-'.$InvoiceInfo->cstmr_name.' '.$InvoiceInfo->cstmr_family : "");
   $direction=($stng_changeDirection ? 'rtldir' : 'ltrdir');
   $space=0; //Separator Spacing in pixel
   $marginTop = ($stng_header_To_InvoiceBody ? $stng_header_To_InvoiceBody : 30);




        //--------------------------------

        $CreatedBy= $invoiceTolalInfo['CreatedBy'];
        $verified_By="";
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....
        $pageNum= '<div style="text-align: left; margin-top: -50px">'.'   صفحه  {PAGENO}از{nb}'.'</div>';
        $header='<img src="img/sr_print_logo.png"> '.$pageNum;

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....
        $officeAddress=\Lang::get('labels.officeAddress'); $webSiteURL=\Lang::get('labels.webSiteURL'); $Tel=\Lang::get('labels.Tel');
        $invoiceSeller=\Lang::get('labels.invoiceSeller');  $invoiceSalesExpert=\Lang::get('labels.invoiceSalesExpert');$invoiceVerifiedBy=\Lang::get('labels.invoiceVerifiedBy');

     $footer='<table style="width: 100% ;   border: 1px solid gray;"  >
                <tr >
                    <td class="invoice_Creator_Cells" style="vertical-align:top ;border-left: 1px solid gray" height="'.$stng_signature_Table_height.'">'.$invoiceSalesExpert.' : '.$CreatedBy.'</td>
                    <td class="invoice_Creator_Cells" style="vertical-align:top;border-left: 1px solid gray" height="'.$stng_signature_Table_height.'">'.$invoiceVerifiedBy.':'.$verified_By.'</td>
                    <td class="invoice_Creator_Cells" style="vertical-align:top;border-left: 1px solid gray" height="'.$stng_signature_Table_height.'">'.$invoiceSeller.':</td>
                </tr>                      
               </table>                                                                     
               <img style="margin-top: 10px " src="img/footer.png">';
        $mpdf = new Mpdf('','A4',  0,  'vYekan',  15,  15,  $marginTop, 45,
            1,  9,   'P');
        //        $mpdf->SetFont('garuda');
        //LANG
       $codeghtesadi=\Lang::get('labels.codeghtesadi'); $codeEghtesadiPishro= \Lang::get('labels.codeEghtesadiPishro');$date= \Lang::get('labels.date'); $Number=\Lang::get('labels.Number');$invoiceSalesExpert=\Lang::get('labels.invoiceSalesExpert');$invoice_seller=\Lang::get('labels.invoice_seller');$address2=\Lang::get('labels.address2');$Orders_row=\Lang::get('labels.Orders_row');$Product_title=\Lang::get('labels.Product_title');$QTY=\Lang::get('labels.QTY');$invoice_Unit_price=\Lang::get('labels.invoice_Unit_price');$invoice_Total_Price=\Lang::get('labels.invoice_Total_Price');$invoice_Info=\Lang::get('labels.invoice_Info');$tel=\Lang::get('labels.tel');
       $Totalsummery=\lang::get('labels.Totalsummery');$invoice_Discount= \lang::get('labels.invoice_Discount');$invoice_tax=\lang::get('labels.invoice_tax');$invoice_Total=\lang::get('labels.invoice_Total');$invoice_Description	=\Lang::get('labels.invoice_Description');$invoice_warranty	=\Lang::get('labels.invoice_warranty');$invoice_Payment 	=\Lang::get('labels.invoice_Payment');$invoice_deliveryDate 	=\Lang::get('labels.invoice_deliveryDate');$invoice_Info 		=\Lang::get('labels.invoice_Info');
        $TaxTitle=\lang::get('labels.TaxTitle');$validityDuration=\lang::get('labels.validityDuration');$invoice_delivery_Type=\Lang::get('labels.invoice_delivery_Type');
       //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....
        $rowID=1;
        $mainTable='';
        $BGcolor='#f4f4f4';
        $r='';
  $mainTable=$mainTable.'<tr colspan="6" style="background:black"> s</tr>';
        for ($i = 0; $i <= count($productList)-1; $i++)
        {
            $SubProductData=$productList[$i]['SubProductData'];
//            $rowID=$i+1;
            $mainTable=$mainTable.'<tr colspan="6" style="background:black"> s</tr>';
            if ($BGcolor=='#f4f4f4') $BGcolor='#fff'  ;  else $BGcolor='#fff';
            $mainTable=$mainTable.'<tr class="" style="background:'.$BGcolor.'">';
            $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center; !important;">'.$rowID++.'</td>';
            $mainTable=$mainTable.'<td class="cellBorder fontSizre '.$direction.'">'.$productList[$i]['product_Title'].'</td>';
            $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center; !important;">'.$productList[$i]['qty'].'</td>';

            $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="border-top: 1px solid #000;  text-align: center; !important;" >'.PublicController::CurencySeprator($productList[$i]['Unit_price']).'</td>';
            $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="border-top: 1px solid #000; text-align: center; !important;">'.PublicController::CurencySeprator($productList[$i]['Unit_price'] * $productList[$i]['qty'] ).'</td>';

            $mainTable=$mainTable.'<td class="cellBorder fontSizre ltrdir" style="text-align: center; !important;">'.$productList[$i]['partNumber'].'</td>';
            $mainTable=$mainTable.'</tr>';

            if (count($SubProductData)>0 )
            {
                for ($G = 0; $G <= count($SubProductData)-1; $G++)
                {

                    $mainTable=$mainTable.'<tr style="background:'.$BGcolor.'">';
                        $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center; !important;">'.$rowID++.'</td>';
                        $mainTable=$mainTable.'<td class="cellBorder fontSizre '.$direction.'" >'.$SubProductData[$G]->product_Title.'</td>';
                        $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber"  style="text-align: center; !important;">'.$SubProductData[$G]->qty.'</td>';
                        $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center;"> 0 </td>';
                        $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center;"> 0 </td>';
                        $mainTable=$mainTable.'<td class="cellBorder fontSizre   ltrdir" style="text-align: center; !important;">'.$SubProductData[$G]->partNumber.'</td>';
                    $mainTable=$mainTable.'</tr>';
                }

            }

//            for ($i = 0; $i <= count($SubProductData); $i++)
//            {
//                $mainTable=$mainTable.'<tr>';
//                $mainTable=$mainTable.'<td>'.$SubProductData[$i]->partNumber.'</td>';
//                $mainTable=$mainTable.' </tr>';
//            }

        }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....
        $n2s=new NumberToString();
        if ($InvoiceInfo->si_tax_setting_status) // Add TAX
        {
            $tax_val=($invoiceTolalInfo['TotalPrice']-$InvoiceInfo->si_Discount)*0.09;
            $totalwithtax=$invoiceTolalInfo['TotalPrice']+$tax_val;
        }
        else
        {
            $tax_val=0;
            $totalwithtax=$invoiceTolalInfo['TotalPrice']-$InvoiceInfo->si_Discount;
        }

        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....
        if ($InvoiceInfo->si_warranty != NULL)
        {
            $show_invoice_warranty= $invoice_warranty.$InvoiceInfo->si_warranty.'<br/>';
        }

        if ($InvoiceInfo->si_Payment != NULL)
        {
            $show_invoice_Payment=$invoice_Payment.$InvoiceInfo->si_Payment.'<br/>';
        }

        if ($InvoiceInfo->si_deliveryDate != NULL)
        {
            $show_invoice_si_deliveryDate=$invoice_deliveryDate.$InvoiceInfo->si_deliveryDate.'<br/>';
        }

        if ($InvoiceInfo->si_delivery_type != NULL)
        {
            $show_invoice_si_delivery_type=$invoice_delivery_Type.':'.$InvoiceInfo->si_delivery_type.'<br/>';
        }

        if ($InvoiceInfo->si_validityDuration != NULL)
        {
            $show_invoice_validityDuration=$validityDuration.':'.$InvoiceInfo->si_validityDuration.'<br/>';
        }


        if ($InvoiceInfo->si_warranty != NULL ||
            $InvoiceInfo->si_Payment != NULL ||
            $InvoiceInfo->si_deliveryDate != NULL  ||
            $InvoiceInfo->si_delivery_type != NULL  ||
            $InvoiceInfo->si_validityDuration != NULL)
            $show_invoice_Description ='<span style="padding-bottom: 20px;font-weight: bold; text-decoration: underline ;">'.$invoice_Description.'</span><br/>';

        if ($InvoiceInfo->si_Description !=null)
        {
            $show_Description='
                <hr/>
             <div style="font-weight: bold;width: 20% ;text-decoration: underline">'.$invoice_Info.': </div>
                <div style="width: 100% ;text-align: justify ;font-size: '.$stng_Desc_fontSize.'px ">'.$InvoiceInfo->si_Description.'</div>
            ';
        }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....


        $invoice_Result='
 
     <tr>
        <td colspan="6" style="height: 3px;">  </td>
      </tr>
     <tr>
                        <td  style="vertical-align:top" colspan="3" rowspan="5">'.
                            $show_invoice_Description.
                            '<div style="height: 3mm !important;color: #fff;font-size: 5px">.</div>'.
                            $show_invoice_warranty.
                            $show_invoice_Payment.
                            $show_invoice_si_deliveryDate.
                            $show_invoice_si_delivery_type.
                            $show_invoice_validityDuration.
                        '</td>
                        <td class="cellBorder">'.$Totalsummery.'</td>
                        <td class="cellBorder farsiNumber txt_center">'.PublicController::CurencySeprator($invoiceTolalInfo['TotalPrice']).' </td><td></td>
                    </tr>
                    <tr>
                        
                        <td class="cellBorder">'.$invoice_Discount.'</td>
                        <td class="cellBorder farsiNumber txt_center">'.PublicController::CurencySeprator($InvoiceInfo->si_Discount) .'</td><td></td>
                    </tr>
                    <tr>                        
                        <td class="cellBorder">'.$TaxTitle .'  </td>
                        <td class="cellBorder farsiNumber txt_center" >'.
                            PublicController::CurencySeprator($tax_val ).

                        ' </td><td></td>
                    </tr>
                    <tr>                        
                        <td class="cellBorder" style="background: black  !important;color: #fff !important;">'.$invoice_Total.' </td>
                        <td class="cellBorder farsiNumber txt_center" >'.PublicController::CurencySeprator($totalwithtax) .'</td>
                        <td></td>
                    </tr>
                     <tr>                        
                        <td colspan="4" > '.  $n2s->digit_to_persain_letters($totalwithtax).' '.$InvoiceInfo->sic_Currency.''.' </td>
                        
                        
                    </tr>
   
    ';


     $invoice_information_Descriptions='
    
     <table  style=" width: 100%;">
                         '.$show_invoice_Description.'   
                         '.$show_invoice_warranty.'                    
                         '.$show_invoice_Payment.' 
                         '.$show_invoice_si_deliveryDate.' 
                         '.$show_invoice_validityDuration.'                                                                               
                </table>
               
                '.$show_Description.'
               
     ';
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....
        $Separator='<div  style="height: '.$space.'cm " > </div>';
        $Seprator_date_To_sellerInfo ='<div  style="height: '. $space_date_To_sellerInfo.'cm " > </div>';
        $Seprator_seller_To_InvoiceTable='<div  style="height: '.  $space_seller_To_InvoiceTable.'cm " > </div>';
        $Seprator_InvoiceTable_To_DescriptionTable='<div  style="height: '.  $space_InvoiceTable_To_DescriptionTable.'cm " ></div>';
        $Jdate=$dateConvert->gregorian_to_jalali_byString($InvoiceInfo->si_date);
        $html =
<<<EOT
        <!DOCTYPE>
        <html>
            <head>
                <style>
                body {
                direction: rtl;                
                font-family: byekan !important;            
                } 
                .font12
                {
                 font-size: 12px !important;
                }
                
                .fontSizre
                {
                font-size: $stng_mainTableFontSize px !important;
                }
                
                .font13
                {
                font-size: 13px !important;
                }
                .farsiNumber
                {
                font-family: Koodak !important;
                }
                
                .ltrdir
                {
                    direction: ltr !important;
                    padding-left:5px;
                }
                .rtldir
                {
                    direction: rtl !important;
                    padding-left:5px;
                    text-align: right!important;
                } 
                
                .officeAddress
                {
                    font-size: 13.5px;
                    text-align: center;
                    padding-top: 5px;
                    padding-bottom: 5px;                    
                }
                .invoice_Creator
                {
                
                    display: block;
                    margin:auto;
                    font-size: 13px;
                    font-weight: bold;  
                    text-align: right;
                    border-top: 1px dotted lightgrey;
                    border-bottom: 1px dotted lightgrey;
                    padding-top: 10px;
                    padding-bottom: 10px;    
                    color: gray;
                }
                .invoice_Creator_Cells{
                    width:33.33% !important;
                    font-size: 13px;
                    font-weight: bold;  
                    color: gray;
                }
                
                table {
                border-collapse: collapse;
                }
                
                .trMain {
                border: 1px solid black !important;
                }
                
                .cellBorder
                {
                 border: 1px solid black ;
                }
                .sepratBordr
                {
                    border: 1px solid red;
                    left: 0; 
                    position: absolute;
                    display: block;
                }    
                .txt_center
                {
                text-align: center;
                }   
                </style>
            </head>
            <body>  
            $s     
            $Separator 
           <h4 style="font-family: byekan; text-align: center ;font-size: 20px"> 
            پیش فاکتور فروش
            </h4>
            $Separator
                <div style="margin-top: -30px" class="row">
                    <div style="width: 60%; float: right;"> </div>
                    <div style="width: 20%; float: left;" >  
                        <div> </div>                      
                        <div> $date  : <span  class="farsiNumber"> $Jdate[0]/$Jdate[1]/$Jdate[2] </span> </div>
                        <div > $Number  :  $InvoiceInfo->si_Alias_id </div>                      
                    </div>                
                </div>  
                <hr/>  
                 $Seprator_date_To_sellerInfo
                    <table class="table" style="width: 100%;font-family: vYekan">
                    <tr  style="border-bottom: 1px solid">
                        <td style="font-weight: bold">$invoice_seller  : </td>
                        <td>$InvoiceInfo->org_name    $custommerName  </td>
                        <td style="font-weight: bold">$codeghtesadi : </td>
                        <td class="farsiNumber">$InvoiceInfo->org_codeeghtesadi </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">$address2 : </td>
                        <td>$InvoiceInfo->org_address </td>
                        <td style="font-weight: bold" >$tel : </td>
                        <td class="farsiNumber">$InvoiceInfo->org_tel</td>
                    </tr>
                </table>                                
                 <hr/> 
                  $Seprator_seller_To_InvoiceTable
                 <table class="table" border="0.2" style="width: 100%;">
                    <tr style="background:lightgray;color:white !important;">
                        <th width="5%">$Orders_row</th>
                        <th width="38%">$Product_title</th>
                        <th width="5%">$QTY</th>
                        <th  width="16%"  style="text-align: center">$invoice_Unit_price ($InvoiceInfo->sic_Currency)</th>
                        <th width="19%"  style="text-align: center" >$invoice_Total_Price ($InvoiceInfo->sic_Currency)</th>
                        <th width="17%">$invoice_Info</th>
                    </tr>
                   
                    $mainTable                    
                    $invoice_Result                                        
                    </table>
                    $Seprator_InvoiceTable_To_DescriptionTable
                    $invoice_information_Descriptions  
                     $Separator                                                    
                  </table>                                                                                                             
            </body>
        </html>
EOT;
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->AddPage(); // force pagebreak
        $mpdf->WriteHTML($html);

        $file_name=$InvoiceInfo->si_Alias_id ;
        if ($InvoiceInfo->org_name !=null) $file_name =$file_name.'_'.$InvoiceInfo->org_name.'.pdf';
        $mpdf->Output($file_name, 'D');

    }

}