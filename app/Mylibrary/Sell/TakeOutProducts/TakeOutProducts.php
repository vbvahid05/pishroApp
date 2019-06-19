<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 07/10/2018
 * Time: 10:09 AM
 */

namespace App\Mylibrary\Sell\TakeOutProducts;

use App\sell_stockrequests_detail;
use App\sell_takeoutproduct ;
use App\stockroom_order;
use App\Stockroom_products;
use App\stockroom_serialnumber;
use App\stockroom_product_statu;
use App\sell_stockrequest;
use App\Mylibrary\PublicClass;

class TakeOutProducts
{
    public function GetSubChassisParts($request)
    {
        $data = $request->all();
        return \DB::table('sell_stockrequests_details AS stockrequests_detail')
            ->join('stockroom_products AS products', 'products.id', '=', 'stockrequests_detail.ssr_d_product_id')
            ->where('stockrequests_detail.ssr_d_ParentChasis', '=',$data['RowID'])
            ->select('*', \DB::raw( 'stockrequests_detail.id AS stockrequests_id '))
            ->get();



    }
//------------------------------------------------------
    public function  getSerils ($request)
    {
        try
        {
            $re=$request->all();
            $row_id =$re['RowID'];
            $StockRequestID=$re['StockRequestID'];
            $productID=$re['productID'];

            $model = sell_takeoutproduct::where('sl_top_stockrequest_id', '=', $StockRequestID)
                ->where('sl_top_productid', '=', $productID)
                ->firstOrFail();
            $serialnumber_id=$model['sl_top_product_serialnumber_id'];
            // return $res=stockroom_serialnumber::where('id' ,'=',$serialnumber_id)->get();
            return   $val = \DB::table('sell_takeoutproducts AS Takeoutp')
                ->join('stockroom_serialnumbers AS serialnumbers', 'serialnumbers.id', '=','Takeoutp.sl_top_product_serialnumber_id')
                ->where('Takeoutp.sl_top_stockrequest_id', '=', $StockRequestID)
                ->where('Takeoutp.sl_top_productid', '=', $productID)
                ->where('Takeoutp.sl_top_StockRequestRowID', '=', $row_id)
                ->where('Takeoutp.deleted_flag', '=', 0)
                ->select('*')
                //->orderBy('stockroom_products.id', 'desc')
                ->get();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

//---------------------------------------------
    public function GetSerialToSubChassis($request)
    {
        $re=$request->all();
        $stockrequerst_Id =$re['stockrequerst_Id'];
        $product_Id=$re['product_Id'];
        $StockRequestRow_ID=$re['StockRequestRow_ID'];

         $products = Stockroom_products :: find($product_Id);
         $two_serial=  $products ['stkr_prodct_two_serial'];

         $Qty = \DB::table('sell_stockrequests_details AS stockrequests_details')
                ->where('stockrequests_details.id', '=', $StockRequestRow_ID)
                ->select('ssr_d_qty')
                ->get();

          $val = \DB::table('sell_stockrequests_details AS stockrequests_details')
            ->join('sell_takeoutproducts AS takeoutproducts', 'takeoutproducts.sl_top_StockRequestRowID', '=','stockrequests_details.id')
            ->join('stockroom_serialnumbers AS serialnumbers', 'serialnumbers.id', '=','takeoutproducts.sl_top_product_serialnumber_id')
            ->where('stockrequests_details.id', '=', $StockRequestRow_ID)
            ->select('*')
            //->orderBy('stockroom_products.id', 'desc')
            ->get();

            $TotalQty =$Qty[0]->ssr_d_qty ;
            $serialQty=count($val);
            $rermQty= $TotalQty-$serialQty;
//             $param=array($rermQty);
             $Arry=array();
            array_push($Arry, $rermQty);
            array_push($Arry, $two_serial);
            array_push($Arry, $val);

            return $Arry;
        //return $StockRequestRow_ID;
    }

//---------------------------------------
    public function TakeASerial($request)
    {

        $re=$request->all();
        $serial =$re['serial'];
        $serialA=$re['serialA'];
        $serialB=$re['serialB'];
        $stockRequestType =$re['stockRequestType'];

        $serialnumber = stockroom_serialnumber::
                 where('stkr_srial_status', '=', '0')
                 -> where('stkr_srial_serial_numbers_a', '=', $serialA)
                 -> where('stkr_srial_serial_numbers_b', '=', $serialB)
                 ->get();
        $count =count($serialnumber);
        if ($count==1)
        {
        //1) Take Out the Product
            $stockrequerstId=$re['stockrequerstId'];
            $serialnumberID= $serialnumber[0]->id;
            $productId=$re['productId'];
            $this_product_StockRequestRowID=$re['this_product_StockRequestRowID'];

            $stockrequest = new sell_takeoutproduct;
            $stockrequest->sl_top_stockrequest_id = $stockrequerstId;
            $stockrequest->sl_top_product_serialnumber_id = $serialnumberID;
            $stockrequest->sl_top_productid =$productId;
            $stockrequest->sl_top_StockRequestRowID=$this_product_StockRequestRowID;

            $stockrequest->deleted_flag='0';
            $stockrequest->archive_flag='0';
            $stockrequest->save();
        //2) the active SerialNumber
            //--------------------------------
            if ($stockRequestType==0)
                stockroom_serialnumber::where('id', '=', $serialnumberID) ->update(array('stkr_srial_status' => 1));
            if ($stockRequestType==2)
                stockroom_serialnumber::where('id', '=', $serialnumberID) ->update(array('stkr_srial_status' => 3));

            //--------------------------------
        //3) change reserve Status to sold Status

            if ($stockRequestType==0){
                $product_statu = stockroom_product_statu::where('sps_product_id', '=', $productId)->firstOrFail();
                $reservedQTY=$product_statu->sps_reserved; if ($reservedQTY==null) $reservedQTY =0;
                $sps_soldQTY=$product_statu->sps_sold; if ($sps_soldQTY==null) $sps_soldQTY=0;
                $reservedQTY --;
                $sps_soldQTY++;
                stockroom_product_statu::where('sps_product_id', '=', $productId)
                    ->update(array('sps_reserved' => $reservedQTY , 'sps_sold' => $sps_soldQTY));
                return 1;
            }
           else if ($stockRequestType==2){
                $product_statu = stockroom_product_statu::where('sps_product_id', '=', $productId)->firstOrFail();
                $reservedQTY=$product_statu->sps_reserved; if ($reservedQTY==null) $reservedQTY =0;
                $sps_borrowed=$product_statu->sps_borrowed; if ($sps_borrowed==null) $sps_borrowed=0;
                $reservedQTY --;
                $sps_borrowed++;
                stockroom_product_statu::where('sps_product_id', '=', $productId)
                    ->update(array('sps_reserved' => $reservedQTY , 'sps_borrowed' => $sps_borrowed));
               return 1;
            }
            //--------------------------------

        }
        else
        {
            return 0;
        }
    }
//--------------------------------
    public  function deleteSubChassisSerial ($request)
    {
            $data=$request->all();
            $StockRequestRow_ID =$data['StockRequestRow_ID'];
            $serialnumber_ID =$data['serialnumber_ID'];
            $product_ID =$data['product_ID'];
            $stockrequest_ID =$data['stockrequest_ID'];
            $stockRequestType = $data['stockRequestType'];

            $StepOne=false;
            $StepTwo=false;
            $StepThree=false;
            $exep="";
            if  ($stockRequestType==0) //ghatii
                $this->updateFieldsAfterDelete($product_ID,$exep,$serialnumber_ID,$stockrequest_ID,$StockRequestRow_ID);
            if ($stockRequestType==2) //Amani
                $this->updateFieldsAfterDelete_Amani($product_ID,$exep,$serialnumber_ID,$stockrequest_ID,$StockRequestRow_ID);
            //----------
   }

    public function updateFieldsAfterDelete($product_ID,$exep,$serialnumber_ID,$stockrequest_ID,$StockRequestRow_ID){
       $product_statu = stockroom_product_statu::where('sps_product_id', '=', $product_ID )->firstOrFail();
       $sold= $product_statu->sps_sold;
       $reserved=$product_statu->sps_reserved;
       // update new QTY in product Status Table     >>> soled State -> reserved Stated = soled-1
       try
       {
           $newReserved =$reserved+1;
           $newSold=$sold-1;
           stockroom_product_statu::where('sps_product_id', '=', $product_ID)
               ->update(array('sps_reserved' =>  $newReserved ,
                   'sps_sold'     => $newSold));
           $StepOne=true;
           $msg='$product_ID '.$product_ID.'  reserved ('.$reserved.') to ->'.'('.$newReserved.')'
               .'  sold ('.$sold.') to ->'.'('.$newSold.')';
       }
       catch (\Exception $e)
       {
           $StepOne=false;
           $exep=$exep.'First >>>'.$e->getMessage();

       }
       //Update SerialNumbers Table Status Flag
       if ($StepOne)
       {
           try{
               stockroom_serialnumber::where('id', '=', $serialnumber_ID)
                   ->update(array('stkr_srial_status' => 0  ));
               $StepTwo=true;

           }
           catch (\Exception $e)
           {
               //roleBack FirstStep
               stockroom_product_statu::where('sps_product_id', '=', $product_ID)
                   ->update(array('sps_reserved' => $reserved-1 ,
                       'sps_sold'     =>$sold+1 ));
               $StepTwo=false;
               $exep=$exep.'ONE >>>'.$e->getMessage();
           }
       }
       // delete From TakeOUT Table
       if ($StepTwo)
       {
           sell_stockrequest::where('id', '=', $stockrequest_ID)
               ->update(array('sel_sr_lock_status' => 0  ));
           $StepThree=true;
       }
       if ($StepThree)
       {
           try{
               $model = sell_takeoutproduct::
               where('sl_top_StockRequestRowID', '=', $StockRequestRow_ID )
                   ->where('sl_top_product_serialnumber_id', '=', $serialnumber_ID )
                   ->where('sl_top_productid', '=', $product_ID )
                   ->firstOrFail();
               sell_takeoutproduct::destroy($model->id);
           }
           catch (\Exception $e)
           {
               //role Back FirstStep
               stockroom_product_statu::where('sps_product_id', '=', $product_ID)
                   ->update(array('sps_reserved' => $reserved-1 ,
                       'sps_sold'     =>$sold+1 ));
               //role Back StepOne
               stockroom_serialnumber::where('id', '=', $serialnumber_ID)
                   ->update(array('stkr_srial_status' => 1  ));
               return $exep=$exep.'TWO >>>'.$e->getMessage();
           }
       }
       return 'delete Successfuly >>'.$msg;
   }
   //-----------------------------
    public function updateFieldsAfterDelete_Amani($product_ID,$exep,$serialnumber_ID,$stockrequest_ID,$StockRequestRow_ID){

        $product_statu = stockroom_product_statu::where('sps_product_id', '=', $product_ID )->firstOrFail();
        $borrowed= $product_statu->sps_borrowed;
        $reserved=$product_statu->sps_reserved;
        // update new QTY in product Status Table     >>> soled State -> reserved Stated = soled-1
        try
        {
            $newReserved =$reserved+1;
            $newBorrowed=$borrowed-1;
            stockroom_product_statu::where('sps_product_id', '=', $product_ID)
                ->update(array('sps_reserved' =>  $newReserved ,
                    'sps_borrowed'     => $newBorrowed));
            $StepOne=true;
            $msg='$product_ID '.$product_ID.'  reserved ('.$reserved.') to ->'.'('.$newReserved.')'
                .'  sold ('.$borrowed.') to ->'.'('.$newBorrowed.')';
        }
        catch (\Exception $e)
        {
            $StepOne=false;
            $exep=$exep.'First >>>'.$e->getMessage();

        }
//        //Update SerialNumbers Table Status Flag
        if ($StepOne)
        {
            try{
                stockroom_serialnumber::where('id', '=', $serialnumber_ID)
                    ->update(array('stkr_srial_status' =>0  ));
                $StepTwo=true;

            }
            catch (\Exception $e)
            {
                //roleBack FirstStep
                stockroom_product_statu::where('sps_product_id', '=', $product_ID)
                    ->update(array('sps_reserved' => $reserved-1 ,
                        'sps_borrowed'     =>$borrowed+1 ));
                $StepTwo=false;
                $exep=$exep.'ONE >>>'.$e->getMessage();
            }
        }
        // delete From TakeOUT Table
        if ($StepTwo)
        {
            sell_stockrequest::where('id', '=', $stockrequest_ID)
                ->update(array('sel_sr_lock_status' => 0  ));
            $StepThree=true;
        }
        if ($StepThree)
        {
            try{
                $model = sell_takeoutproduct::
                where('sl_top_StockRequestRowID', '=', $StockRequestRow_ID )
                    ->where('sl_top_product_serialnumber_id', '=', $serialnumber_ID )
                    ->where('sl_top_productid', '=', $product_ID )
                    ->firstOrFail();
                sell_takeoutproduct::destroy($model->id);
            }
            catch (\Exception $e)
            {
                //role Back FirstStep
                stockroom_product_statu::where('sps_product_id', '=', $product_ID)
                    ->update(array('sps_reserved' => $reserved-1 ,
                        'sps_borrowed'     =>$borrowed+1 ));
                //role Back StepOne
                stockroom_serialnumber::where('id', '=', $serialnumber_ID)
                    ->update(array('stkr_srial_status' => 3  ));
                return $exep=$exep.'TWO >>>'.$e->getMessage();
            }
        }
        return 'delete Successfuly >>'.$msg;
    }

    //-----------------------------

    public function showAllSerialNumbers()
    {
        $result=  \DB::table('stockroom_serialnumbers AS serialnumbers')
            ->join('stockroom_stock_putting_products AS putting_products', 'putting_products.id', '=','serialnumbers.stkr_srial_putting_product_id')
            ->join('stockroom_products AS products', 'products.id', '=','putting_products.stkr_stk_putng_prdct_product_id')
//           ->select('*')
            ->select('*',\DB::raw('serialnumbers.created_at AS serialCreatedAt ,
                                 serialnumbers.updated_at AS serialUpdatedAt     
                              
          
          '))
            //->orderBy('stockroom_products.id', 'desc')
            ->get();
        $ro='<html>
            <style>tr:hover {background: #c3e5ff !important;cursor: pointer;}</style>
            <body> <table style="width: 65%;display: block;margin: auto;font-family: sans-serif;"><tbody>';

        $ro=$ro.'<tr>';
        $ro=$ro .'<td style="width: 50px;" > #  </td>';
        $ro=$ro .'<th style="    text-align: left;"> PartNumber</th>';
        $ro=$ro.'<th style="text-align: left;">title </th> ';
        $ro=$ro.'<th>serial_numbers_a </th> ';
        $ro=$ro.'<th>serial_numbers_b  </th> ';
        $ro=$ro.'<th> srial_status  </th> ';
        $ro=$ro.'<th> Order ID  </th> ';
        $ro=$ro.'<th style="width: 100px;"> تاریخ ورود  </th> ';
        $ro=$ro.'<th style="width: 100px;"> تاریخ خروج  </th> ';
        $ro=$ro.'</tr>';


        $i=0;
        $oldTitle="";
        foreach ($result AS $r)
        {
//           if ($oldTitle !=$r->stkr_prodct_partnumber_commercial )
//           {
//               $partNumber=$r->stkr_prodct_partnumber_commercial;
//               $prodct_title=$r->stkr_prodct_title;
//
//           }
//           else
//           {
//               $partNumber='';
//               $prodct_title='';
//
//           }
            $partNumber=$r->stkr_prodct_partnumber_commercial;
            $prodct_title=$r->stkr_prodct_title;
            if ($i%2 ==0) $color='style="background: #d0d0d0; "';
            else  $color='style="background: #fff;"';

            if ($r->stkr_srial_status==1) $status='ناموجود';
            else if ($r->stkr_srial_status==2) $status='گارانتی';
            else $status='';
            $ro=$ro.'<tr '. $color.' >';
            $ro=$ro .'<td> '.$i++ .'   </td>';
            $ro=$ro .'<td>  '.$partNumber.'   </td>';
            $ro=$ro.'<td>'.$prodct_title.'  </td> ';
            $ro=$ro.'<td>'.$r->stkr_srial_serial_numbers_a .'  </td> ';
            $ro=$ro.'<td>'.$r->stkr_srial_serial_numbers_b.'  </td> ';
            $ro=$ro.'<td>'.$status.'  </td> ';
            $orderID= $r->stkr_stk_putng_prdct_order_id+1000;
            $ro=$ro.'<td>'.$orderID.'  </td> ';
            $date=new PublicClass();
            $de=$date->gregorian_to_jalali_byString($r->serialCreatedAt);
            $ro=$ro.'<td>'.$de[0].'-'.$de[1].'-'.$de[2] .'  </td> ';

            $de=$date->gregorian_to_jalali_byString($r->serialUpdatedAt);
            if ($r->serialUpdatedAt != $r->serialCreatedAt)
                $Udate=$de[0].'-'.$de[1].'-'.$de[2];
            else
                $Udate="";
            $ro=$ro.'<td>'. $Udate.'  </td> ';
            $ro=$ro.'</tr>';

            $oldTitle =$r->stkr_prodct_partnumber_commercial;
        }
        return  $rows=$ro."</tbody></table></body><p></p></html>";
    }




   //------------------------
   public function reservedQTY( $productsId)
   {
       $result=  \DB::table('sell_stockrequests AS stockrequests')
           ->join('sell_stockrequests_details AS stockrequests_details', 'stockrequests.id', '=','stockrequests_details.ssr_d_stockrequerst_id')
           ->where ('stockrequests_details.ssr_d_product_id','=',$productsId)
           ->where ('stockrequests.sel_sr_type','=',0) // ghatii
           ->select('*')
           ->get();

        $TotalCount=0;
        foreach ($result as $re)
        {
            $TotalCount=$TotalCount+$re->ssr_d_qty;
        }

        // jame  kharej shodeha
       $result2=  \DB::table('sell_stockrequests AS stockrequests')
           ->join('sell_takeoutproducts AS takeoutproducts', 'takeoutproducts.sl_top_stockrequest_id', '=','stockrequests.id')
           ->where ('takeoutproducts.sl_top_productid','=',$productsId)
           ->where ('stockrequests.sel_sr_type','=',0) // ghatii
           ->select('*')
           ->count();


       return  $TotalCount-$result2;
   }

   public function INandOutReport()
   {
       $result=  \DB::table('stockroom_serialnumbers AS serialnumbers')
           ->join('stockroom_stock_putting_products AS putting_products', 'putting_products.id', '=','serialnumbers.stkr_srial_putting_product_id')
           ->join('stockroom_products AS products', 'products.id', '=','putting_products.stkr_stk_putng_prdct_product_id')
//           ->select('*')
          ->select('*',\DB::raw('serialnumbers.created_at AS serialCreatedAt ,
                                 serialnumbers.updated_at AS serialUpdatedAt ,
                                 products.id AS productsId   
                              
          
          '))
           //->orderBy('stockroom_products.id', 'desc')
           ->get();
       $ro='<html>
            <style>tr:hover {background: #c3e5ff !important;cursor: pointer;}</style>
            <body> 
            
            
            
            
            <table style="width: 65%;display: block;margin: auto;font-family: sans-serif;"><tbody>';

       $ro=$ro.'<tr>';
       $ro=$ro .'<th style="width: 50px;" > PartNumber  </th>';
       $ro=$ro .'<th style="    text-align: left;">جمع کل ورودی </th>';
       $ro=$ro.'<th style="width: 100px;">  رزور  </th> ';
       $ro=$ro.'<th style="text-align: left;"> جمع خروجی </th> ';
       $ro=$ro.'<th style="width: 100px;">باقی مانده انبار </th> ';
       $ro=$ro.'<th>   </th> ';
       $ro=$ro.'<th>   </th> ';
       $ro=$ro.'<th>   </th> ';
       $ro=$ro.'<th style="width: 100px;">    </th> ';
       $ro=$ro.'<th style="width: 100px;">  </th> ';
       $ro=$ro.'</tr>';


       $i=0;
       $oldTitle="";
       $buffer="";
       $buf=array();
       foreach ($result AS $r)
       {
           if ( !in_array( $r->stkr_prodct_partnumber_commercial,$buf ) )
           {
               array_push($buf,$r->stkr_prodct_partnumber_commercial);

               $AllSerialInQTY=  \DB::table('stockroom_serialnumbers AS serialnumbers')
                   ->join('stockroom_stock_putting_products AS putting_products', 'putting_products.id', '=','serialnumbers.stkr_srial_putting_product_id')
                   ->join('stockroom_products AS products', 'products.id', '=','putting_products.stkr_stk_putng_prdct_product_id')
//           ->select('*')
                   ->where ( 'products.stkr_prodct_partnumber_commercial','=',$r->stkr_prodct_partnumber_commercial )
                   ->select('*' )
                   //->orderBy('stockroom_products.id', 'desc')
                   ->count();


               $takeoutQTY=  \DB::table('sell_takeoutproducts AS takeoutproducts')

                   ->where ( 'takeoutproducts.sl_top_productid','=',$r->productsId )
                   ->select('*',\DB::raw('serialnumbers.created_at AS serialCreatedAt ,
                                 serialnumbers.updated_at AS serialUpdatedAt '))
                   ->count();


               $reservedQTY =$this->reservedQTY($r->productsId);//
               $reminedQTY=($AllSerialInQTY-($takeoutQTY+$reservedQTY));

               $ro=$ro.'<tr>';
                  $ro=$ro.'<td>'.$r->stkr_prodct_partnumber_commercial.'</td>';
                  $ro=$ro.'<td style="text-align: center">'.$AllSerialInQTY.'</td>';
               $ro=$ro.'<td style="text-align: center">'.($reservedQTY).'</td>';
                  $ro=$ro.'<td style="text-align: center">'.$takeoutQTY.'</td>';
                  $ro=$ro.'<td style="text-align: center">'.$reminedQTY.'</td>';

               $ro=$ro.'</tr>';

           }
           }


       return  $rows=$ro."</tbody></table></body><p></p></html>";
   }




}