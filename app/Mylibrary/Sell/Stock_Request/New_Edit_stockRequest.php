<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 22/05/2018
 * Time: 09:45 AM
 */

namespace App\Mylibrary\Sell\Stock_Request;
//>>>>>>>>>>>> Model
use App\sell_stockrequest;
use App\sell_stockrequests_detail;
use App\stockroom_product_statu;
use App\sell_takeoutproduct;
use App\stockroom_serialnumber;
use App\Stockroom_stock_putting_product;
use App\Mylibrary\PublicClass;
use Illuminate\Support\Facades\Auth;



class New_Edit_stockRequest
{

    public function Add_to_DB($request)
    {
        $val= new sell_stockrequest ($request->all());
        $val->sel_sr_type	=$request->sr_type;
        $val->sel_sr_custommer_id=$request->sr_custommer_id;
        $val->sel_sr_pre_contract_number =$request->sr_preFaktorNum;
        $val->sel_sr_delivery_date =$request->sr_deliveryDate;
        $val->sel_sr_registration_date=date("Y/m/d");
        $val->sel_sr_lock_status =0;
        $val->deleted_flag=0;
        $val->archive_flag=0;
        if ($val->save())
        {
            $LastID = \DB::table('sell_stockrequests')
                ->orderBy('sell_stockrequests.id', 'desc')
                ->select('id', \DB::raw('sell_stockrequests.id AS stockrequestsID '))
                ->limit(1)
                ->get();
            return  $stockrequestsID= $LastID[0]->id;

        }

    }


//-----------------------------------
//
    public function  addProductToStockRequest ($request)
    {
            $nextStep=false;
            $data = $request->all();
            $StockRequestType = $data['StockRequestType'];  //Ghatii=0  TaaHodi =1


            $val= new sell_stockrequests_detail ();
            $val->ssr_d_stockrequerst_id= $data["StockRequestID"];
            $val->ssr_d_product_id=$data["product_ID"];
            $val->ssr_d_qty=$data["product_QTY"];
            $val->ssr_d_ParentChasis =0;
            $val->ssr_d_status=0;
            $val->deleted_flag=0;
            $val->archive_flag=0;
            if ($val->save())

                $nextStep=true;
            //---------------------

            try
            {
                $QTYinDB = \DB::table('stockroom_product_status AS product_status')
                    ->where('product_status.sps_product_id', '=',  $data["product_ID"] )
                    ->select(  \DB::raw('product_status.sps_available AS  QTY_available ,
                                             product_status.sps_reserved AS   QTY_reserved,
                                             product_status.sps_Taahodi AS  QTY_taahodi
                                '))
                    ->get();
                $OldAvailable =$QTYinDB[0]->QTY_available ;
                $OldReserved =$QTYinDB[0]->QTY_reserved ;
                $OldTaahodi =$QTYinDB[0]->QTY_taahodi ;
            }
            catch (\Exception $e)
            {
                $OldAvailable=0;
                $OldReserved =0;
                $OldTaahodi =0;

                $stockrequest = new stockroom_product_statu;
                $stockrequest->sps_product_id = $data["product_ID"];
                $stockrequest->sps_available = 0;
                $stockrequest->sps_reserved = 0;
                $stockrequest->sps_sold=0;
                $stockrequest->sps_warranty=0;
                $stockrequest->sps_Taahodi=0;
                $stockrequest->sps_borrowed=0;
                $stockrequest->deleted_flag=0;
                $stockrequest->archive_flag=0;
                $stockrequest->save();
            }



            //---------------------
            if ($nextStep && $StockRequestType ==0) //Ghatii
            {
                $newAvailQty =$OldAvailable-$data["product_QTY"];
                $newReservQty= $OldReserved+$data["product_QTY"];
                //----------------------
                $val = stockroom_product_statu::where('sps_product_id', $data["product_ID"])->first();
                $val->sps_available =$newAvailQty;
                $val->sps_reserved = $newReservQty;
                if ($val->save())
                    return 'added';
            }
            else
            {
                $NewQTY_taahodi= $OldTaahodi+$data["product_QTY"];
                $val = stockroom_product_statu::where('sps_product_id', $data["product_ID"])->first();
                $val->sps_Taahodi =$NewQTY_taahodi;
                if ($val->save())
                return 'TaaHodi added';
            }
    }

    //-----------------------
//    public function insert_StockRequest_details_to_DB($formType,$data)
//    {
//        return 1;
//}



    public function insert_StockRequest_details_to_DB($formType,$data)
    {

        // Ghatii formType==0 /  Ta'ahodi  formType==1
        //1- Insert in  sell_stockrequests_detail Tabel
        return $this->Manage_stockrequests_detail(0,$formType,$data);
        //1- Update stockroom_product_status

//            $val1="";
//            $status=true;
//            //    $data = $request->all();
//
//            $n= count( $data)-1;
//            for ($i=0;$i<=$n;$i++)
//            {
//                $val= new sell_stockrequests_detail ($data[$i]);
//                $val->ssr_d_stockrequerst_id= $data[$i]["StockRequestID"];
//                $val->ssr_d_product_id=$data[$i]["productID"];
//                $val->ssr_d_qty=$data[$i]["product_QTY"];
//                $val->ssr_d_status=0;
//                $val->deleted_flag=0;
//                $val->archive_flag=0;
//                if ($val->save())
//                    $status=$status AND true;
//                // Update product_statu
//                // VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV
//                if ($status && $formType==0) // Ghatii
//                {
//                    $QTYinDB = \DB::table('stockroom_product_status AS product_status')
//                        ->where('product_status.sps_product_id', '=',  $data[$i]["productID"] )
//                        ->select(  \DB::raw('product_status.sps_available AS  QTY_available ,
//                                                 product_status.sps_reserved AS   QTY_reserved
//                                                    '))
//                        ->get();
//
//                    $OldAvailable =$QTYinDB[0]->QTY_available ;
//                    $OldReserved =$QTYinDB[0]->QTY_reserved ;
//                    //------------
//                    $val = stockroom_product_statu::where('sps_product_id',$data[$i]["productID"])->first();
//                    $val->sps_available= $OldAvailable-$data[$i]["product_QTY"];
//                    $val->sps_reserved= $OldReserved+$data[$i]["product_QTY"];
//                    if ($val->save())
//                        $status=$status AND true;
//                }
//// VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV
//            }
//        if ($status)  return 1;
    }

    public function RollBack_stockrequests($stockrequerst_id,$product_id)
    {
        $Pcount = \DB::table('sell_stockrequests_details')
            ->where('sell_stockrequests_details.ssr_d_stockrequerst_id', $stockrequerst_id)
            ->where('sell_stockrequests_details.ssr_d_product_id', $product_id)
            ->count();
        //-- Save  Error Log
        //-- make Rollback
        //-- Save Rollback Log
    }
//------------------------------
    public function Manage_stockrequests_detail($mode ,$formType,$data )
    {
        //$mode : 0   Insert
        //$mode : 1   Update
        //$mode : 2   RollBack
        $buffer=">>";
        $n=count($data)-1;
        for ($i=0;$i<=$n;$i++)
        {
            $step_1 =false;
            $step_2=false ;
            $StockRequestID=$data[$i]["StockRequestID"];
//            $Pcount = \DB::table('sell_stockrequests_details')
//                ->where('sell_stockrequests_details.ssr_d_stockrequerst_id', $data[$i]["StockRequestID"])
//                ->where('sell_stockrequests_details.ssr_d_product_id', $data[$i]["productID"])
//                ->count();
//            if ($Pcount)    //Update Needed
//            {}
//            else  //is a New Item
//            {
                //@#@#@#@#@#@#@#@#@#@#@#@#@#@#@
                try {
                    $val = new sell_stockrequests_detail ($data[$i]);
                    $val->ssr_d_stockrequerst_id = $data[$i]["StockRequestID"];
                    $val->ssr_d_product_id = $data[$i]["productID"];
                    $val->ssr_d_qty = $data[$i]["product_QTY"];
                    $val->ssr_d_status = 0;
                    $val->deleted_flag = 0;
                    $val->archive_flag = 0;
                    $val->save();
                    $step_1 = true;
                    //LOG ~~~~~~~~~~
                    $string="/sell/stockRequest|".
                        "edit_DB() | "."Step1>sell_stockrequests_detail ,".
                        "stockrequerst_id:".$val->ssr_d_stockrequerst_id.
                        '|product_id:'.$val->ssr_d_product_id .
                        '| qty;'.$val->ssr_d_qty;
                    $add_log= new PublicClass();
                    $add_log->add_user_log($string,"OK",Auth::user()->id);
                    //LOG ~~~~~~~~~~

                }
                catch (\Exception $e)
                {
                    $step_1 =false;
                    //LOG ~~~~~~~~~~
                    $string="/sell/stockRequest|"."edit_DB() | "."Step1>sell_stockrequests_detail ,".
                        "stockrequerst_id:".$val->ssr_d_stockrequerst_id.
                        '|product_id:'.$val->ssr_d_product_id .
                        '| qty;'.$val->ssr_d_qty.
                        'ERROR:'.$e->getMessage();
                    $add_log= new PublicClass();
                    $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
                    //LOG~~~~~~~~~~~~~~~~
                }
                //~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                if ($step_1 == true)
                {// STEP 2 >> Change Product Status
                    switch ($formType)
                    {
                        case 0: //Ghatiiii
                            try
                            {
                                $QTYinDB = \DB::table('stockroom_product_status AS product_status')
                                    ->where('product_status.sps_product_id', '=',  $data[$i]["productID"] )
                                    ->select(  \DB::raw('product_status.sps_available AS  QTY_available ,
                                        product_status.sps_reserved AS   QTY_reserved
                                        '))
                                    ->get();
                                $OldAvailable =$QTYinDB[0]->QTY_available ;
                                $OldReserved =$QTYinDB[0]->QTY_reserved ;
                                //------------
//                                if ($mode==0)  // insertion action
//                                {
//                                    $product_statu= new stockroom_product_statu();
//                                    $product_statu->sps_product_id =$data[$i]["productID"];
//                                    $product_statu->sps_available = $OldAvailable - $data[$i]["product_QTY"];
//                                    $product_statu->sps_reserved = $OldReserved + $data[$i]["product_QTY"];
//                                    $product_statu->deleted_flag=0;
//                                    $product_statu->archive_flag=0;
//                                    $product_statu->save();
//                                    $modeLabel="insertion";
//                                }
//                                else if ($mode==1) // Update action
//                                {
//                                    $val = stockroom_product_statu::where('sps_product_id', $data[$i]["productID"])->first();
//                                    $val->sps_available = $OldAvailable - $data[$i]["product_QTY"];
//                                    $val->sps_reserved = $OldReserved + $data[$i]["product_QTY"];
//                                    $val->save();
//                                    $step_2 = true;
//                                    $modeLabel="Update";
//                                }
                                $val = stockroom_product_statu::where('sps_product_id', $data[$i]["productID"])->first();
                                $val->sps_available = $OldAvailable - $data[$i]["product_QTY"];
                                $val->sps_reserved = $OldReserved + $data[$i]["product_QTY"];
                                $val->save();
                                $step_2 = true;

                                //LOG~~~~~~~~~~~~~~~~
                                $string="/sell/stockRequest|"."edit_DB() | ".
                                    "Step2>stockroom_product_statu ,".
                                    'Ghatiiii> '.$mode.
                                    " stockrequerst_id:".$StockRequestID.
                                    '|product_id:'.$data[$i]["productID"] .
                                    '|OldAvailable;'.$OldAvailable.
                                    '|OldReserved;'.$OldReserved.
                                    '|QTY;'.$data[$i]["product_QTY"];
                                $add_log= new PublicClass();
                                $add_log->add_user_log($string,"OK" ,Auth::user()->id );
                                //LOG~~~~~~~~~~~~~~~~
                            }
                            catch (\Exception $e)
                            {
                                $step_2 =false;
                                //LOG~~~~~~~~~~~~~~~~
                                $string="/sell/stockRequest|"."edit_DB() | ".
                                    "Step2>stockroom_product_statu ,".
                                    'Ghatiiii> '.
                                    " stockrequerst_id:".$StockRequestID.
                                    '|product_id:'.$data[$i]["productID"] .
                                    '|OldAvailable;'.$OldAvailable.
                                    '|OldReserved;'.$OldReserved.
                                    '|QTY;'.$data[$i]["product_QTY"].
                                    '|ERROR: '. $e->getMessage();
                                $add_log= new PublicClass();
                                $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
                                //LOG~~~~~~~~~~~~~~~~
                            }
                            break;

                        case 1:// Ta'ahodi
                            try
                            {
                                $OldTaahodiQTY=0;
                                $QTYinDB = \DB::table('stockroom_product_status AS product_status')
                                    ->where('product_status.sps_product_id', '=',  $data[$i]["productID"] )
                                    ->select(  \DB::raw('product_status.sps_Taahodi AS  QTY_Taahodi '))
                                    ->get();
                                $OldTaahodiQTY =$QTYinDB[0]->QTY_Taahodi ;
                                //------------
                                if ($mode==0)  // insertion action
                                {
                                    $product_statu= new stockroom_product_statu();
                                    $product_statu->sps_Taahodi= $OldTaahodiQTY+$data[$i]["product_QTY"];
                                    $product_statu->save();
                                }
                                else if ($mode==1)
                                {
                                    $val = stockroom_product_statu::where('sps_product_id',$data[$i]["productID"])->first();
                                    $val->sps_Taahodi= $OldTaahodiQTY+$data[$i]["product_QTY"];
                                    $val->save();
                                }
                                $step_2 =true;
                                //LOG~~~~~~~~~~~~~~~~
                                $string="/sell/stockRequest|"."edit_DB() | ".
                                    "Step2>stockroom_product_statu ,".
                                    'Taahodi>'.
                                    "stockrequerst_id:".$StockRequestID.
                                    '|product_id:'.$data[$i]["productID"] .
                                    '|OldTaahodiQTY;'.$OldTaahodiQTY.
                                    '|QTY:'.$data[$i]["product_QTY"];
                                $add_log= new PublicClass();
                                $add_log->add_user_log($string,"OK" ,Auth::user()->id );
                                //LOG~~~~~~~~~~~~~~~~
                            }
                            catch (\Exception $e)
                            {
                                $step_2 =false;
                                //LOG~~~~~~~~~~~~~~~~
                                $string="/sell/stockRequest|"."edit_DB() | ".
                                    "Step2>stockroom_product_statu ,".
                                    'Taahodi> '.
                                    "stockrequerst_id:".$StockRequestID.
                                    '|product_id:'.$data[$i]["productID"] .
                                    '|OldTaahodiQTY;'.$OldTaahodiQTY.
                                    '|QTY;'.$data[$i]["product_QTY"].
                                    '|ERROR: '. $e->getMessage();
                                $add_log= new PublicClass();
                                $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
                                //LOG~~~~~~~~~~~~~~~~
                            }
                            break;
                    }
                }
//            }//else
            if ($step_2 && $step_1 )
            {
                $buffer=$buffer.'_'.$i;
            }
            else  $i ; //RollBack
        } //End For
        return $buffer;
    }
//11111111111111111
    public function Update_Stockrequest_details_to_DB($formType,$data)
    {
        // Ghatii formType==0 /  Ta'ahodi  formType==1
        //1- Insert in  sell_stockrequests_detail Tabel
        return $this->Manage_stockrequests_detail(1,$formType,$data);
        //1- Update stockroom_product_status
    }


    public function DeleteProduct_From_StackRequest($request)
    {


        $State = "State::>";
        $argdata = $request->all();
        $index = $argdata['index'];
        $type = $argdata['type'];
        $StockRequestID = $argdata['StockRequestID'];
        $productID = $argdata['productID'];
         $StockReq_RowID = $argdata['StockRequest_RowID'];

//        $subChassis = \DB::table('sell_stockrequests_details AS stockrequests_details')
//            ->where('stockrequests_details.ssr_d_ParentChasis', '=', $StockReq_RowID)
//            ->get();

        $TakeOut=   sell_takeoutproduct::where('sl_top_StockRequestRowID','=',$StockReq_RowID)->count();

        //Step 1: Delete Or Delete Tag  From  "sell_stockrequests_details" Table
        try
        {
            $RowID = sell_stockrequests_detail::
            where('ssr_d_stockrequerst_id', '=', $StockRequestID)
                ->where('ssr_d_product_id', '=', $productID)
                ->firstOrFail();
            $recordIsInDB="Yes";
            //.........................
            $SerialFlagIsFree = \DB::table('sell_takeoutproducts AS takeoutproducts')
                ->where('takeoutproducts.sl_top_stockrequest_id', '=', $StockRequestID)
                ->where('takeoutproducts.sl_top_productid', '=', $productID)
                ->count();
        }
        catch (\Exception $e)
        {
            $recordIsInDB="No";
            return $e->getCode();
        }


        if ($recordIsInDB=="Yes" && $SerialFlagIsFree==0 && $TakeOut==0)
        {
            // Full Delete
            sell_stockrequests_detail::destroy($RowID['id']);
            //Step 2: Change QTY From "stockroom_product_status"  Table
            if ($type == 0) //Ghatiiiii
            {
                //..................
                $QTYinDB = \DB::table('stockroom_product_status AS product_status')
                    ->where('product_status.sps_product_id', '=', $productID)
                    ->select(\DB::raw('product_status.sps_available AS  QTY_available ,
                                   product_status.sps_reserved AS  QTY_reserved'))
                    ->get();
                $oldQTY_available = $QTYinDB[0]->QTY_available;
                $oldQTY_reserved = $QTYinDB[0]->QTY_reserved;
                //..................
                $val = stockroom_product_statu::where('sps_product_id', $productID)->first();
                $val->sps_available = $oldQTY_available + $RowID['ssr_d_qty'];
                $val->sps_reserved = $oldQTY_reserved - $RowID['ssr_d_qty'];
                $val->save();

                //++++++++++++++++++++++++++++++++++++++++++++++
                //Delete SubChassis~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                $subChassis = \DB::table('sell_stockrequests_details AS stockrequests_details')
                    ->where('stockrequests_details.ssr_d_ParentChasis', '=', $StockReq_RowID)
                    ->get();
                if (count($subChassis)!=0)
                {
                    foreach ($subChassis AS $subchsis)
                    {

                        $newQty =$subchsis->ssr_d_qty;
                        $productID =$subchsis->ssr_d_product_id;
                        $product_status = stockroom_product_statu::where('sps_product_id', '=', $productID)->firstOrFail();
                        $availableQty=  $product_status->sps_available +$newQty ;
                        $reservedQty=  $product_status->sps_reserved - $newQty ;

                        $affectedRows = stockroom_product_statu::where('sps_product_id', '=', $productID)
                            ->update(array('sps_available' => $availableQty ,'sps_reserved' => $reservedQty));
                        //full Delete ! destroy Record from DB
                        sell_stockrequests_detail::destroy($subchsis->id);
                    }
                }
            }
            else  //Taa'ahodi
            {
                //..................
                $QTYinDB = \DB::table('stockroom_product_status AS product_status')
                    ->where('product_status.sps_product_id', '=', $productID)
                    ->select(\DB::raw('product_status.sps_Taahodi AS   QTY_Taahodi'))
                    ->get();
                $old_QTY_Taahodi=$QTYinDB[0]->QTY_Taahodi;
                //..................
                $val = stockroom_product_statu::where('sps_product_id', $productID)->first();
                $val->sps_Taahodi = $old_QTY_Taahodi-$RowID['ssr_d_qty']  ;
                $val->save();
                //++++++++++++++++++++++++++++++++++++++++++++++
                //Delete SubChassis~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                $subChassis = \DB::table('sell_stockrequests_details AS stockrequests_details')
                    ->where('stockrequests_details.ssr_d_ParentChasis', '=', $StockReq_RowID)
                    ->get();
                if (count($subChassis)!=0)
                {
                    foreach ($subChassis AS $subchsis) {

                        $newQty = $subchsis->ssr_d_qty;
                        $productID = $subchsis->ssr_d_product_id;
                        $product_status = stockroom_product_statu::where('sps_product_id', '=', $productID)->firstOrFail();
                        $TaahodiQty = $product_status->sps_Taahodi - $newQty;
                        $affectedRows = stockroom_product_statu::where('sps_product_id', '=', $productID)
                            ->update(array('sps_Taahodi' => $TaahodiQty));
                        //full Delete ! destroy Record from DB
                        sell_stockrequests_detail::destroy($subchsis->id);
                    }
                }

            }

//            //Step 3 : free up the SerialNumber Flag  in>> stockroom_serialnumbers/stkr_srial_status
//            try {
//                $serialnumber_id = \DB::table('sell_takeoutproducts AS takeoutproducts')
//                    ->where('takeoutproducts.sl_top_stockrequest_id', '=', $StockRequestID)
//                    ->where('takeoutproducts.sl_top_productid', '=', $productID)
//                    ->get();
//
//                $val = stockroom_serialnumber::where('id',$serialnumber_id['sl_top_product_serialnumber_id'])->first();
//                $val->stkr_srial_status= 0;
//                $val->save();
//               }
//            catch (\Exception $e)
//               {
//                    return
//               }
        }
        else return 'SerialFlagError';
    }

    public function DeleteStockRequest_From_BaseList ($request)
    {
        $argdata = $request->all();
        $rowid = $argdata['rowid'];

        $countOfstockrequests_details = \DB::table('sell_stockrequests_details AS stockrequests_details')
            ->where('stockrequests_details.ssr_d_stockrequerst_id', '=', $rowid)
            ->count();
        if ($countOfstockrequests_details==0)
        {
            sell_stockrequest::destroy($rowid);
            return '1';
        }
        else
        {
            return '0';
        }

    }
//
//
//        public function Update_Stockrequest_details_to_DB($formType,$data)
//    {
//
//        try
//        {
//            $status=false;
//            $n=count($data)-1;
//            for ($i=0;$i<=$n;$i++)
//            {
//                $Pcount = \DB::table('sell_stockrequests_details')
//                ->where('sell_stockrequests_details.ssr_d_stockrequerst_id', $data[$i]["StockRequestID"])
//                ->where('sell_stockrequests_details.ssr_d_product_id', $data[$i]["productID"])
//                ->count();
//                //-----------------------
//                if ($Pcount)    //Update Needed
//                {
//
//                }
//                else  //is a New Item
//                {
//                 //1 :  New Item ,Must be Insert in  "sell_stockrequests_detail"
//                    try{
//                        $val= new sell_stockrequests_detail ($data[$i]);
//                        $val->ssr_d_stockrequerst_id= $data[$i]["StockRequestID"];
//                        $val->ssr_d_product_id=$data[$i]["productID"];
//                        $val->ssr_d_qty=$data[$i]["product_QTY"];
//                        $val->ssr_d_status=0;
//                        $val->deleted_flag=0;
//                        $val->archive_flag=0;
//                        $val->save();
//                        $status=true;
//                    }
//                    catch (\Exception $e)
//                    {
//                        $status=false;
//                    }
//                  //-------------------------------------
//                 //2 : change product Status State
//                    if ($status && $formType==0) //Ghatiiii
//                    {
//
//                    }
//                    else if ($status && $formType==1)   // Ta'ahodi
//                    {
//
//                    }
//                 //-------------------------------------
//                }
//            }//end For
//        }//end try
//        catch (\Exception $e)
//        {
//            return $e->getFile().''.$e->getLine();
//        }
//
//    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//        $s="";
//        $status=true;
//        //$data=$argdata['dataArray'];
//        $n= count( $data)-1;
//        for ($i=0;$i<=$n;$i++)
//        {
//            $Pcount = \DB::table('sell_stockrequests_details')
//                ->where('sell_stockrequests_details.ssr_d_stockrequerst_id', $data[$i]["StockRequestID"])
//                ->where('sell_stockrequests_details.ssr_d_product_id', $data[$i]["productID"])
//                ->count();
//
//            //**********
//            if ($Pcount)    //Update Needed
//            {
//
//            }
//            else  //is a New Item ,Must be Insert in DB
//            {
//
//                $val= new sell_stockrequests_detail ($data[$i]);
//                $val->ssr_d_stockrequerst_id= $data[$i]["StockRequestID"];
//                $val->ssr_d_product_id=$data[$i]["productID"];
//                $val->ssr_d_qty=$data[$i]["product_QTY"];
//                $val->ssr_d_status=0;
//                $val->deleted_flag=0;
//                $val->archive_flag=0;
//                if ($val->save())
//                    $status=$status AND true;
//
//                // Up date product_statu
//                // VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV
//                if ($status && $formType==0) //Ghatiiii
//                {
//                    $QTYinDB = \DB::table('stockroom_product_status AS product_status')
//                        ->where('product_status.sps_product_id', '=',  $data[$i]["productID"] )
//                        ->select(  \DB::raw('product_status.sps_available AS  QTY_available ,
//                                             product_status.sps_reserved AS   QTY_reserved
//                                             '))
//                        ->get();
//
//                    $OldAvailable =$QTYinDB[0]->QTY_available ;
//                    $OldReserved =$QTYinDB[0]->QTY_reserved ;
//                    //------------
//                    $val = stockroom_product_statu::where('sps_product_id',$data[$i]["productID"])->first();
//                    $val->sps_available= $OldAvailable-$data[$i]["product_QTY"];
//                    $val->sps_reserved= $OldReserved+$data[$i]["product_QTY"];
//                    if ($val->save())
//                        $status=$status AND true;
//                }
//
//                //*** Ta'ahodi
//                else if ($status && $formType==1)   // Ta'ahodi
//                {
//                    $OldTaahodiQTY=0;
//                    $QTYinDB = \DB::table('stockroom_product_status AS product_status')
//                        ->where('product_status.sps_product_id', '=',  $data[$i]["productID"] )
//                        ->select(  \DB::raw('product_status.sps_Taahodi AS  QTY_Taahodi '))
//                        ->get();
//                    $OldTaahodiQTY =$QTYinDB[0]->QTY_Taahodi ;
//                    //------------
//                    $val = stockroom_product_statu::where('sps_product_id',$data[$i]["productID"])->first();
//                    $val->sps_Taahodi= $OldTaahodiQTY+$data[$i]["product_QTY"];
//                    if ($val->save())
//                        $status=$status AND true;
//                }
//                // VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV
//            }
//            //**********
//        }
//        if ($status)
//            return 1;
//        else return 0;
//
//        //  ###########################################################
//
//        //   try
//        //   { $rrrr="";
//        //       $n= count( $data)-1;
//        //       $StockRequestID=$data[0]["StockRequestID"];
//        //       for ($i=0;$i<=$n;$i++)
//        //       {
//        //           $Pcount = sell_stockrequests_detail::
//        //                    where('ssr_d_stockrequerst_id', '=',$data[$i]["StockRequestID"] )
//        //                   ->where('ssr_d_product_id', '=', $data[$i]["productID"])
//        //                   ->count();
//        //           if ($Pcount==0) //is a New Item ,Must be Insert in DB
//        //           {
//        ////              $Sub_Chassis_Array= $data[$i]["Sub_Chassis"];
//        ////              $m= count($Sub_Chassis_Array)-1;
//        //              //**********************************
//        //                $val= new sell_stockrequests_detail ($data[$i]);
//        //                $val->ssr_d_stockrequerst_id=$StockRequestID;
//        //                $val->ssr_d_product_id=$data[$i]["productID"];
//        //                $val->ssr_d_qty=$data[$i]["product_QTY"];
//        //                $val->ssr_d_status=0;
//        //                $val->deleted_flag=0;
//        //                $val->archive_flag=0;
//        //                $val->save();
//        //              //**********************************
//        //
//        ////              for($j=0;$j<=$m ;$j++)
//        ////              {
//        ////                  $product_id=$Sub_Chassis_Array[$j]["product_id"];
//        ////                  $qty=$Sub_Chassis_Array[$j]["qty"];
//        ////              //********************************
//        ////                  $val= new sell_stockrequests_detail ($data[$i]);
//        ////                  $val->ssr_d_stockrequerst_id=$StockRequestID;
//        ////                  $val->ssr_d_product_id=$product_id;
//        ////                  $val->ssr_d_qty=$qty;
//        ////                  $val->ssr_d_status=0;
//        ////                  $val->deleted_flag=0;
//        ////                  $val->archive_flag=0;
//        ////                  $val->save();
//        ////              //********************************
//        ////              }
//        //
//        //           }
//        //           else
//        //           {
//        //               //Need Update
//        //           }
//        //       }
//        //       return $StockRequestID.') '.$rrrr;
//        //   }
//        //   catch (\Exception $ep)
//        //   {
//        //       return $ep->getFile().'  Line:'.$ep->getLine();
//        //
//        //
//        //
//        //   }
//
//
//    } //end Function




    //################# Service Methods ###################
//######################################################
    public function Get_Custommer_list($request)
    {
        $data = $request->all();
        $mode=$data['mode'];
        $valus = \DB::table('custommers')
            ->join('custommerorganizations AS  cusmrORG'   ,   'cusmrORG.id', '=','custommers.cstmr_organization')

            //->select('*', \DB::raw('stockrequests.id AS stockrequestsID '))

            ->select( \DB::raw('
             custommers.id AS id,
             custommers.cstmr_name AS cstmr_name,
             custommers.cstmr_family AS cstmr_family,
             cusmrORG.org_name AS org_name
              '))
            ->where('custommers.cstmr_detials', '=', $mode)
            //->where('custommers.deleted_flag', '=', $mode)
            ->orderBy('custommers.id', 'desc')
            ->get();
        return $valus;
    }
//-----------------------


    public function Get_SubChassisParts($request)
    {
        $data = $request->all();
        $product_ID=$data['chassisID'];
        $ParentChasisID=$data['StockRequestRowID'];
        $StockRequestID =$data['StockRequest_ID'];

        $stockrequest= sell_stockrequest::find($StockRequestID);
        $formType=$stockrequest->sel_sr_type;
        // if chassis then find Sub chassis List
        //1):
        $stock = \DB::table('Stockroom_stock_putting_products AS stock')
            ->join('stockroom_products AS  products'   ,   'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
            ->where('stock.stkr_stk_putng_prdct_product_id', '=', $product_ID)
            ->where('products.stkr_prodct_type_cat', '=', 3) // Just Chassis
            ->select( \DB::raw('stock.id'))
            ->get();
        //2):
        $Arry_SubChassisParts=array();
        $i=0;
        $c=0;
        $productArray = array();
        foreach ($stock AS $Stockid)
        {
            $stocks = \DB::table('Stockroom_stock_putting_products AS stock')
                ->join('stockroom_products AS  products'   ,   'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
                ->where('stock.stkr_stk_putng_prdct_partofchassis', '=', $Stockid->id)
                ->select('*', \DB::raw( 'stkr_stk_putng_prdct_product_id AS product_id 
                                    , stkr_stk_putng_prdct_order_id AS orderID'))
                ->get();

            foreach ($stocks AS $ProductRecord)
            {
                $productArray[]=$ProductRecord->id;
               }
        }
        $productArray= array_unique($productArray);

        //----------------------
          $sell_stockrequests_detail=sell_stockrequests_detail::
                                   where('ssr_d_ParentChasis', '=',$ParentChasisID)
                                   ->get();
        //----------------------
        $productA=array_values($productArray);
        $productB=array();

        for ($i=0;$i<=count($sell_stockrequests_detail)-1  ;$i++)
            {
                $productB[]= $sell_stockrequests_detail[$i]['ssr_d_product_id'];
            }

        $array_diff=array_diff($productA,$productB);

        foreach ($array_diff AS $array)
        {

            $subChasiss =
                \DB::table('stockroom_products AS  products')
                    ->join('stockroom_product_status AS  product_status','products.id', '=','product_status.sps_product_id')
                    ->where('products.id', '=', $array)
                    ->select('*', \DB::raw( 'products.id AS products_id ,
                                           product_status.id AS product_status_id  '))
                    ->get();

            if (count ($subChasiss) ==0 )
            {
                $stockrequest = new stockroom_product_statu;
                $stockrequest->sps_product_id =$array;
                $stockrequest->sps_available = 0;
                $stockrequest->sps_reserved = 0;
                $stockrequest->sps_sold=0;
                $stockrequest->sps_warranty=0;
                $stockrequest->sps_Taahodi=0;
                $stockrequest->sps_borrowed=0;
                $stockrequest->deleted_flag=0;
                $stockrequest->archive_flag=0;
                $stockrequest->save();

                $subChasiss =
                    \DB::table('stockroom_products AS  products')
                        ->join('stockroom_product_status AS  product_status','products.id', '=','product_status.sps_product_id')
                        ->where('products.id', '=', $array)
                        ->select('*', \DB::raw( 'products.id AS products_id ,
                                           product_status.id AS product_status_id  '))
                        ->get();

                array_push($Arry_SubChassisParts, $subChasiss);
            }

            else
            {
                array_push($Arry_SubChassisParts, $subChasiss);
            }
//            try
//            {
//
//                $subChasiss =
//                    \DB::table('stockroom_products AS  products')
//                        ->join('stockroom_product_status AS  product_status','products.id', '=','product_status.sps_product_id')
//                        ->where('products.id', '=', $array)
//                        ->select('*', \DB::raw( 'products.id AS products_id ,
//                                           product_status.id AS product_status_id  '))
//                        ->get();
//                if (count ($subChasiss) ==0 )
//                    return 'Null Array';
//                else
//                array_push($Arry_SubChassisParts, $subChasiss);
//            }
//            catch ( \Exception $e)
//            {
//
//                //........................
//                $stockrequest = new stockroom_product_statu;
//                $stockrequest->sps_product_id =$array;
//                $stockrequest->sps_available = 0;
//                $stockrequest->sps_reserved = 0;
//                $stockrequest->sps_sold=0;
//                $stockrequest->sps_warranty=0;
//                $stockrequest->sps_Taahodi=0;
//                $stockrequest->sps_borrowed=0;
//                $stockrequest->deleted_flag=0;
//                $stockrequest->archive_flag=0;
//                $stockrequest->save();
//                //........................
//                $subChasiss =
//                    \DB::table('stockroom_products AS  products')
//                        ->join('stockroom_product_status AS  product_status','products.id', '=','product_status.sps_product_id')
//                        ->where('products.id', '=', $array)
//                        ->select('*', \DB::raw( 'products.id AS products_id ,
//                                           product_status.id AS product_status_id  '))
//                        ->get();
//                array_push($Arry_SubChassisParts, $subChasiss);
//            }
        }
        $finalArray=array();
        array_push($finalArray, $Arry_SubChassisParts);
        array_push($finalArray, $formType);
        return $finalArray;


    }

//---------------------------------------------------------------
    public function AddSubChassisPartsToDB($request)
    {
        $nextStep=false;
        $data = $request->all();
        $formType=$data['formType'];

        $productStatu = stockroom_product_statu::where('sps_product_id', '=', $data['partID'])->firstOrFail();
        $availQty = $productStatu->sps_available;
        $reservedQty = $productStatu->sps_reserved;
        $TaahodiQty = $productStatu->sps_Taahodi;
        $newAvialQty = $availQty - $data['QTY'];
        $newReservedQty = $reservedQty + $data['QTY'];

    if ($formType==0) //Ghatii
        {
            if ($availQty >=$data['QTY'])
            {
                try
                {
                    stockroom_product_statu::where('id', '=', $productStatu->id)
                        ->update(array('sps_available' => $newAvialQty, 'sps_reserved' => $newReservedQty));
                    $nextStep=true;
                }
                catch (\Exception $e)
                {
                    $nextStep=false;
                }
                //------------------------------\
                if ($nextStep)
                {
                    try
                    {
                        $stockRequestDetail = new sell_stockrequests_detail;
                        $stockRequestDetail->ssr_d_stockrequerst_id=$data['stockRequestID'];
                        $stockRequestDetail->ssr_d_product_id=$data['partID'];
                        $stockRequestDetail->ssr_d_qty=$data['QTY'];
                        $stockRequestDetail->ssr_d_ParentChasis=$data['StockRequestRowID'];
                        $stockRequestDetail->ssr_d_status=0;
                        $stockRequestDetail->deleted_flag=0;
                        $stockRequestDetail->archive_flag=0;
                        $stockRequestDetail->save();
                    }
                    catch (\Exception $e)
                    {
                        //roleBack
                        stockroom_product_statu::where('id', '=', $productStatu->id)
                            ->update(array('sps_available' => $availQty, 'sps_reserved' => $reservedQty));
                    }
                }
            }
        }
    else  //Ta'ahodi
    {
        try {
            stockroom_product_statu::where('id', '=', $productStatu->id)
                ->update(array('sps_Taahodi' => $TaahodiQty+ $data['QTY'] ));
            $nextStep = true;
        } catch (\Exception $e) {
            $nextStep = false;
        }
        //------------------------------\
        if ($nextStep) {
            try {
                $stockRequestDetail = new sell_stockrequests_detail;
                $stockRequestDetail->ssr_d_stockrequerst_id = $data['stockRequestID'];
                $stockRequestDetail->ssr_d_product_id = $data['partID'];
                $stockRequestDetail->ssr_d_qty = $data['QTY'];
                $stockRequestDetail->ssr_d_ParentChasis = $data['StockRequestRowID'];
                $stockRequestDetail->ssr_d_status = 0;
                $stockRequestDetail->deleted_flag = 0;
                $stockRequestDetail->archive_flag = 0;
                $stockRequestDetail->save();
            } catch (\Exception $e) {
                //roleBack
                stockroom_product_statu::where('id', '=', $productStatu->id)
                    ->update(array('sps_Taahodi' => $TaahodiQty));
            }
        }
    }


    }

    public function get_saved_SubchassisParts($request)
    {
        $data = $request->all();

     //  return sell_stockrequests_detail::where('ssr_d_ParentChasis', '=', $data['ParentChasisID'])->get();
        return  \DB::table('sell_stockrequests_details AS stockrequests_detail')
            ->join('stockroom_products AS products', 'products.id', '=', 'stockrequests_detail.ssr_d_product_id')
            ->where('ssr_d_ParentChasis', '=', $data['ParentChasisID'])
            ->select('*', \DB::raw( 'stockrequests_detail.id AS stckreqstDtlRowID'))
            ->get();

    }

//--------------------
//
    public  function  delete_SubChassis_Item($request)
    {
        $data = $request->all();
        $formType=$data['formType'] ;
        $stckreqstDtlRowID= $data['stckreqstDtlRowID'] ;
        $productID= $data['productID']  ;
        $count = sell_takeoutproduct::where('sl_top_StockRequestRowID', '=', $stckreqstDtlRowID)->count();

        if ($count ==0)
        {
            $model = sell_stockrequests_detail::where('id', '=',  $stckreqstDtlRowID)->firstOrFail();
            $OldQty= $model->ssr_d_qty;
        //-------------------------------------------------------
            if ($formType==0) //Ghatiiii
            {
                try
                {
                    $product_status = stockroom_product_statu::where('sps_product_id', '=', $productID)->firstOrFail();
                    $availableQty   = $product_status->sps_available + $OldQty;
                    $reservedQty    = $product_status->sps_reserved - $OldQty;
                    stockroom_product_statu::where('sps_product_id', '=', $productID)
                        ->update(array('sps_available' => $availableQty ,'sps_reserved' => $reservedQty  ));
                    //full Delete ! destroy Record from DB
                    sell_stockrequests_detail::destroy($stckreqstDtlRowID);
                    return 'done';
                }
                catch (\Exception $e)
                {
                    return $e;
                }
            }
        //-------------------------------------------------------
            else
            {
                try
                {
                    $product_status = stockroom_product_statu::where('sps_product_id', '=', $productID)->firstOrFail();
                    $TaahodiQTY = $product_status->sps_Taahodi-$OldQty;
                    stockroom_product_statu::where('sps_product_id', '=', $productID)
                        ->update(array('sps_Taahodi' => $TaahodiQTY));
                    //full Delete ! destroy Record from DB
                    sell_stockrequests_detail::destroy($stckreqstDtlRowID);
                    return 'done';
                }
                catch (\Exception $e)
                {
                    return $e;
                }
            }
        }
        else
            return 'can not Delete';
    }

//----------------------------------------------------------------------------------
    public  function showConvertStockRequest($request)
    {
        $data=$request->all();
         $StockRequestID =$data['StockRequestid'];
         return $this->getStockRequestData($StockRequestID);

    }
//----------------------------------------------------------------------------------
public function  ConvertEngain($product_ID,$stckreqstDtlRowID,$StockRequestID_Valid,$justUpdate,$thisQTY,$availableQTY,$TaahodiQty,$reservedQTY,$ParentChasis)
{
    $newReserved=$reservedQTY+$thisQTY;
    $newTaahodiQty =$TaahodiQty-$thisQTY;
    $newAvailQTY=$availableQTY-$thisQTY;
    if ($ParentChasis ==null)
        $ParentChasisID =0;
    else
        $ParentChasisID=$ParentChasis;
     $can=0;
     $canNot=0;
    $currentID=0;
    //--- can Convert ?
    if ($availableQTY>=$thisQTY)
    {
        $can++;
        if ($justUpdate==false)  // move Old StockRequest Rows To New one
        {
            //___1___ADD product in new StockRequest____________________________
            $stockrequest = new  sell_stockrequests_detail;
            $stockrequest->ssr_d_stockrequerst_id = $StockRequestID_Valid;
            $stockrequest->ssr_d_product_id = $product_ID;
            $stockrequest->ssr_d_qty=$thisQTY;
            $stockrequest->ssr_d_ParentChasis=$ParentChasisID;
            $stockrequest->ssr_d_status=0;
            $stockrequest->deleted_flag=0;
            $stockrequest->archive_flag=0;
            $stockrequest->save();

            $LastID = \DB::table('sell_stockrequests_details')
                ->orderBy('sell_stockrequests_details.id', 'desc')
                ->select('id', \DB::raw('sell_stockrequests_details.id AS currentID '))
                ->limit(1)
                ->get();
               $currentID= $LastID[0]->currentID;

            //___2___Delete Old Item from StockRequest____________________________
            sell_stockrequests_detail::destroy($stckreqstDtlRowID);

            //___3___Change Product Status Data |__________________________________
            stockroom_product_statu::where('sps_product_id', '=', $product_ID)
                ->update(array('sps_available' => $newAvailQTY ,
                    'sps_reserved' => $newReserved ,
                    'sps_Taahodi' => $newTaahodiQty
                ));
        }
        else  // Just Update Current StockRequest
        {
            //______Change Product Status Data |__________________________________
            stockroom_product_statu::where('sps_product_id', '=', $product_ID)
                ->update(array('sps_available' => $newAvailQTY ,
                    'sps_reserved' => $newReserved ,
                    'sps_Taahodi' => $newTaahodiQty
                ));
        }
    }
    else
        $canNot++;
    return array("can"=>$can ,"canNot"=>$canNot,"currentID"=>$currentID);
}
//---------------------------------------------------
    public  function convertStockRequest($request)
    {

         $ischassis=3; //chassis ID
        $data=$request->all();
        $StockRequestID =$data['StockRequestid'];
        $status= $this->convertStockRequest_getStatus($StockRequestID);
        $can=0;
        $canNot=0;
    //-----------------------------------------
        //return 'AvailQTY'.$status['AvailQTY'] .' /  Total '.$status['TotalQTY'];
    //*(1) Stock Request Row
        if ($status['TotalQTY']!=$status['AvailQTY'] && $status['AvailQTY'] !=0 )
        {
            $convertType=1;
            //return sell_stockrequest::all()->last()->id;
            //Make a New StockRequest Record
            $stockrequestData = sell_stockrequest::where('id', '=',$StockRequestID )->firstOrFail();
            $stockrequest = new sell_stockrequest;
            $stockrequest->sel_sr_type = 0;
            $stockrequest->sel_sr_custommer_id =$stockrequestData['sel_sr_custommer_id'];
            $stockrequest->sel_sr_registration_date = $stockrequestData['sel_sr_registration_date'];
            $stockrequest->sel_sr_delivery_date=$stockrequestData['sel_sr_delivery_date'];
            $stockrequest->sel_sr_pre_contract_number=$stockrequestData['sel_sr_pre_contract_number'];
            $stockrequest->sel_sr_lock_status=0;
            $stockrequest->deleted_flag =0;
            $stockrequest->archive_flag=0;
            $stockrequest->save();
            $StockRequestID_Valid= sell_stockrequest::all()->last()->id;
            $justUpdate=false;

        }
        else if ($status['TotalQTY']!=$status['AvailQTY'] && $status['AvailQTY'] ==0)
        {
            $convertType=2;
            return 'cantConvert';
        }
        else{
            $convertType=3;
            $justUpdate=true;
            $StockRequestID_Valid=$StockRequestID;
        }

      //  return $StockRequestID_Valid;
    //-----------------------------------------
        $productList= $this->getStockRequestData($StockRequestID);

        foreach ($productList AS $prodct_list)
        {
            //----------------------------
            $product_ID=$prodct_list['productID'];
            $stckreqstDtlRowID=$prodct_list['stckreqstDtlRowID'];
            $model = stockroom_product_statu::where('sps_product_id', '=',$product_ID)->firstOrFail();
            $thisQTY=$prodct_list['ssr_d_qty'];
            $availableQTY = $prodct_list['sps_available'];
            $TaahodiQty= $model['sps_Taahodi'];
            $reservedQTY=$model['sps_reserved'];
            $ParentChasis=null;
            //----------------------------
             if ($prodct_list['stkr_prodct_type_cat']!=$ischassis)  // if Not a chassis then
             {
                 //Checking QTY , available Or Not
               $result= $this->ConvertEngain($product_ID,$stckreqstDtlRowID,$StockRequestID_Valid,$justUpdate,$thisQTY,$availableQTY,$TaahodiQty,$reservedQTY,$ParentChasis);
               $can=$can+$result['can'];
               $canNot=$canNot+$result['canNot'];
             }
            //----------------------------
            else //is a chassis
            {
                if ($prodct_list['sps_available'] >=$prodct_list['ssr_d_qty'])
                {
                    $totalSubChassisItems = count($prodct_list['subChassis']);
                    $ckeckForAvailItems = 0;
//                   return $prodct_list['subChassis'];
                    //__________________________________
                    foreach ($prodct_list['subChassis'] AS $subChassis) {
                        if ($subChassis->sps_available >= $subChassis->ssr_d_qty)
                            $ckeckForAvailItems++;//
                    }
                    //___________________________
                    if ($ckeckForAvailItems == $totalSubChassisItems) //  Chassis And All subChassis are Available
                    {
                        //Manage Chassis State
                        $ParentChasis=null;
                        $result=$this->ConvertEngain($product_ID,$stckreqstDtlRowID,$StockRequestID_Valid,$justUpdate,$thisQTY,$availableQTY,$TaahodiQty,$reservedQTY,$ParentChasis);
                        $can=$can+$result['can'];
                        $canNot=$canNot+$result['canNot'];
                        $currentID= $result['currentID'];
                        //...............................
                        //Manage SubChassis State
                        foreach ($prodct_list['subChassis'] AS $subChassis) {
                            $product_ID =  $subChassis->sps_product_id;
                            $stckreqstDtlRowID =  $subChassis->stckreqstDtlRowID;
                            $thisQTY =$subChassis->ssr_d_qty;
                            $availableQTY =$subChassis->sps_available;
                            $TaahodiQty=$subChassis->sps_Taahodi;
                            $reservedQTY =$subChassis->sps_reserved;
                            $ParentChasis =$subChassis->ssr_d_ParentChasis;

                            $result=$this->ConvertEngain($product_ID,$stckreqstDtlRowID,$StockRequestID_Valid,$justUpdate,$thisQTY,$availableQTY,$TaahodiQty,$reservedQTY,$currentID);
                            $can=$can+$result['can'];
                            $canNot=$canNot+$result['canNot'];
                        }
                        //...............................
                    }
                    else
                        $justUpdate=false;
                }
            }
            //----------------------------
        }
        if ($justUpdate)
        {
//            $StockRequestID_Valid=$StockRequestID;
            sell_stockrequest::where('id', '=', $StockRequestID)
                ->update(array('sel_sr_type' => 0   ));//Ghatiii
        }

    return array("convertType"=>$convertType, "can"=>$can ,"canNot"=>$canNot);
   //-----------------------------------------
    }


//----------------------------------------------------------------------------------
    public  function convertStockRequest_getStatus($StockRequestID)
    {
        $productList= $this->getStockRequestData($StockRequestID);
        $O="";
        $AvailQTY=0;$TotalQTY=0;
        foreach ($productList AS $prodct_list)
        {   $TotalQTY++;
            if ($prodct_list['ssr_d_qty'] <= $prodct_list['sps_available'] )
                {
                    $AvailQTY++;
                }
            $subChassisList= $prodct_list['subChassis'] ;
            foreach ($subChassisList AS $subCL)
            {
                $TotalQTY++;
                if ($subCL->ssr_d_qty <= $subCL->sps_available )
                {
                    $AvailQTY++;
                }
            }
        }
        return  array(
                "TotalQTY"=> $TotalQTY,
                "AvailQTY"=>$AvailQTY);
    }

//------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------

    public function getStockRequestData($StockRequestID)
    {
        $partList=  \DB::table('sell_stockrequests_details AS stockrequests_detail')
            ->join('stockroom_product_status AS product_status', 'product_status.sps_product_id', '=', 'stockrequests_detail.ssr_d_product_id')
            ->join('stockroom_products AS products', 'products.id', '=', 'stockrequests_detail.ssr_d_product_id')
            ->where('stockrequests_detail.ssr_d_stockrequerst_id', '=', $StockRequestID)
            ->where('stockrequests_detail.ssr_d_ParentChasis', '=', 0)
            ->select('*', \DB::raw( 'stockrequests_detail.id AS stckreqstDtlRowID'))
            ->get();

        $finalArray=array();
        foreach ($partList AS $plMain)
        {
            $subPartList = \DB::table('sell_stockrequests_details AS stockrequests_detail')
                ->join('stockroom_product_status AS product_status', 'product_status.sps_product_id', '=', 'stockrequests_detail.ssr_d_product_id')
                ->join('stockroom_products AS products', 'products.id', '=', 'stockrequests_detail.ssr_d_product_id')
                ->where('stockrequests_detail.ssr_d_stockrequerst_id', '=', $StockRequestID)
                ->where('stockrequests_detail.ssr_d_ParentChasis', '=', $plMain->stckreqstDtlRowID)
                ->select('*', \DB::raw( 'stockrequests_detail.id AS stckreqstDtlRowID'))
                ->get();

            $Parts = array(
                "stckreqstDtlRowID"=> $plMain->stckreqstDtlRowID,
                "productID"=> $plMain->ssr_d_product_id,
                "stkr_prodct_type_cat"=>$plMain->stkr_prodct_type_cat,
                "ssr_d_qty"=> $plMain->ssr_d_qty,
                "sps_available"=>$plMain->sps_available,
                "stkr_prodct_partnumber_commercial"=> $plMain->stkr_prodct_partnumber_commercial,
                "stkr_prodct_title"=>$plMain->stkr_prodct_title,
                "ParentChasis_id" => $plMain->ssr_d_ParentChasis,
                "subChassis"=>$subPartList
            );
            array_push($finalArray, $Parts);
        }
        return $finalArray;
    }
//----------------------------------------------------------------------------------
    public function editStackrequest_info($req){
        $data=$req->all();
        $stockrequestID=$data['$stockrequestID'];
        $field=$data['field'];
        $value=$data['value'];
        switch ($field)
        {
            case 'preFaktorNum':
                sell_stockrequest::where('id', '=', $stockrequestID) ->update(array('sel_sr_pre_contract_number' => $value));
            break;
            case 'custmrList':
                sell_stockrequest::where('id', '=', $stockrequestID) ->update(array('sel_sr_custommer_id' => $value));
            break;

            case 'DliverDate':
              sell_stockrequest::where('id', '=', $stockrequestID) ->update(array('sel_sr_delivery_date' => $value));
            break;

            case 'RegistrDate':
                sell_stockrequest::where('id', '=', $stockrequestID) ->update(array('sel_sr_registration_date' => $value));
                break;

        }


    }

//----------------------------------------------------------------------------------

}