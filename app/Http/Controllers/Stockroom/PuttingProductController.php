<?php

namespace App\Http\Controllers\Stockroom;
//>>>>>>>>>>>> Model
use App\Stockroom_stock_putting_product;
use App\stockroom_order;
use App\stockroom_serialnumber;
use App\stockroom_product_statu;
use App\User;

//>>>>>>>>>>>> Model
use Gate;
//use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mylibrary\PublicClass
;
class PuttingProductController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }

  public function convert()
  {

    $jy=1396;
    $jm=12;
    $jd=06;
    $publicClass= new PublicClass;
    echo $a= $publicClass-> convert_jalali_to_gregorian($jy,$jm,$jd).'<br/>';

    $jy=2018;
    $jm=02;
    $jd=25;
    $publicClass= new PublicClass;
    echo $a= $publicClass-> convert_gregorian_to_jalali($jy,$jm,$jd);

  }

public function PuttingToStock(Request $request)
{
  $validatedData = $request->validate([
     'Quantity' => 'nullable|numeric',
      'Cdays' => 'required',
      'Cmonths' => 'required',
      'Cyears' => 'required',
        ]);
  if ($validatedData)
  {
       $publicClass= new PublicClass;
       $data=$request->all();
       $array_SerialNumbers= $data['SerialNumbers'];

       $Jdate= $publicClass-> convert_jalali_to_gregorian($data["Cyears"],$data["Cmonths"],$data["Cdays"]);

        $val= new Stockroom_stock_putting_product ($request->all());
        $val->stkr_stk_putng_prdct_product_id =$request->productId;
        $val->stkr_stk_putng_prdct_order_id =$request->orderId;
        $val->stkr_stk_putng_prdct_qty =$request->Quantity;
        $val->stkr_stk_putng_prdct_in_date =$Jdate;//$Jdate;
        $val->stkr_stk_putng_prdct_tech_part_numbers =$request->partNumber;
        $val->stkr_stk_putng_prdct_chassis_number =$request->Chassis_number;
        $val->stkr_stk_putng_prdct_SO_Number =$request->SO_number;
        $val->stkr_stk_putng_prdct_serial_Number_id=1;
        $val->stkr_stk_putng_prdct_More_info ="";
        $val->deleted_flag =0;
        $val->archive_flag=0; //Not defined
//--------------------------------------
        if ($val->save())
          {
            $LastID = \DB::table('stockroom_stock_putting_products')
            ->orderBy('stockroom_stock_putting_products.id', 'desc')
            ->select('id', \DB::raw('stockroom_stock_putting_products.id AS putting_productID '))
            ->limit(1)
            ->get();
            $Putting_productId= $LastID[0]->id;

             //----------------------------------
$serr="";
             foreach ($array_SerialNumbers as $serial)
             {
               $serr=$serr.$serial["serial_A"]."/".$serial["serial_B"];

                 $val= new stockroom_serialnumber ($request->all());
                 $val->stkr_srial_putting_product_id =$Putting_productId;
                 $val->stkr_srial_serial_numbers_a =$serial["serial_A"];
                 $val->stkr_srial_serial_numbers_b =$serial["serial_B"];
                 $val->stkr_srial_more="-";
                 $val->stkr_srial_status=0;
                 $val->deleted_flag=0;
                 $val->archive_flag=0;
                 $val->save();

             }
             return $Putting_productId;
          }
      //  else return 'validate Error';
      }
}


  public function showAllRecords($mode)
  {
//     return use App\stockroom_order;

//      Non-static method Illuminate\Auth\Access\Gate::denies() should not be called statically
    try{
        $userId = \Auth::id();
//        if(Gate::denies('editOrder',2 ))
//        {
            $val = \DB::table('stockroom_orders')
                ->join('stockroom_orders_sellers AS sellers'     ,   'sellers.id', '=','stockroom_orders.stk_ordrs_seller_id')
                ->where('stockroom_orders.stk_ordrs_status_id', '=', 4)
                ->where('stockroom_orders.deleted_flag', '=', $mode)
                ->select('*', \DB::raw('stockroom_orders.id AS OrderID '))
                ->orderBy('stockroom_orders.id', 'desc')
                ->get( );
            //return $val;
       $masterArray =array();

        foreach ($val AS  $v)
        {
            $retArray=  $this->getinQry($v->OrderID) ;
            $total_Qty=$retArray[1];
            $InsertedSerialQty=$this->getInsertedSerialQty($v->OrderID);
            //........
            if ($total_Qty == $InsertedSerialQty)
                $printLink= 'print' ;
            else
                $printLink= $InsertedSerialQty.'/'.$total_Qty;

            $ItemArray=array('OrderID'=> $v->OrderID  ,
                'stk_ordrs_id_code' =>$v->stk_ordrs_id_code ,
                'stk_ordrs_id_number'=>$v->stk_ordrs_id_number ,
                'stkr_ordrs_slr_name'        =>$v->stkr_ordrs_slr_name ,
                'stk_ordrs_putting_date' => $v->stk_ordrs_putting_date,
                'link' => $printLink
            );
            array_push($masterArray,$ItemArray);
        }

        return $masterArray;


//        }
//        else
//            return $userId;
    }
    catch (\Exception $e)
    {return $e->getMessage();
    }
  }

//------------------------------
  public function getInsertedSerialQty($orderID)
{
    $StockList = \DB::table('stockroom_stock_putting_products AS stock_putting')
        ->join('stockroom_serialnumbers AS serialnumbers', 'serialnumbers.stkr_srial_putting_product_id',
                                                       '=','stock_putting.id')
        ->where('stock_putting.stkr_stk_putng_prdct_order_id', '=', $orderID)
        ->select('*')
        ->count();
       return $StockList;

}
//------------------------------

  public function show_Record_by_id($id)
  {
    $val = \DB::table('stockroom_orders')
    ->join('stockroom_stock_putting_products AS stock'     ,   'stock.stkr_stk_putng_prdct_order_id', '=','stockroom_orders.id')
    ->join('stockroom_products AS products'     ,   'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
    ->join('stockroom_products_brands AS brands'     ,   'brands.id', '=','products.stkr_prodct_brand')
    ->join('stockroom_products_types AS types'     ,   'types.id', '=','products.stkr_prodct_type')
    ->join('stockroom_orders_sellers AS sellers'     ,   'sellers.id', '=','stockroom_orders.stk_ordrs_seller_id')
//    ->where('products.stkr_prodct_type_cat', '!=', 2)
    ->where('stock.stkr_stk_putng_prdct_partofchassis', '=', null)
    ->where('stockroom_orders.id', '=', $id)
    ->where('stockroom_orders.stk_ordrs_status_id', '=', 4)
    ->where('stockroom_orders.deleted_flag', '=', 0)
    //->select('*', \DB::raw('stockroom_orders.id AS OrderID '  ))
    ->select('*', \DB::raw('stockroom_orders.id AS OrderID  , stock.id AS putting_productsID '))
    ->orderBy('putting_productsID', 'desc')
     ->get( );
     return $val;
  }

  public function getProductTitleBrandType(Request $request)
    {
      $data = $request->all();
      $id=$data['productID'];
         $val = \DB::table('stockroom_products')
            ->join('stockroom_products_brands AS brands'   ,   'brands.id', '=','stockroom_products.stkr_prodct_brand')
            ->join('stockroom_products_types AS types'     ,   'types.id', '=','stockroom_products.stkr_prodct_type')
            ->select('*', \DB::raw('stockroom_products.id AS ProductsID  , brands.id AS BrandID ,types.id AS TypeID'))
            ->where('stockroom_products.id', '=', $id)
            ->where('stockroom_products.deleted_flag', '=', 0)
          ->get();
          return $val;
    }

    public function getAllOrderList (Request $request)
    {
      $data = $request->all();
      $val = \DB::table('stockroom_orders')
         ->join('stockroom_orders_sellers AS sellers'   ,   'sellers.id', '=','stockroom_orders.stk_ordrs_seller_id')
         ->join('stockroom_orders_status AS status'     ,   'status.id', '=','stockroom_orders.stk_ordrs_status_id')
         ->select('*', \DB::raw('stockroom_orders.id AS    orderID '))
         ->where('stockroom_orders.deleted_flag', '=', 0)
       ->get();
       return $val;

    }

    public function saveSerialNumbers(Request $request)
    {
        $data=$request->all();
        $array_SerialNumbers= $data['SerialNumbers'];
        $Putting_productId=$data['puttingProductsID'];
        $qty=$data['Quantity'];
        $ret=0;
        $real_QTY=0;
        //*****************
        foreach ($array_SerialNumbers as $serial)
        {
          if (array_key_exists("SerialA",$serial))
          {
            $real_QTY=$real_QTY+1;
            //$rb=$serial["SerialA"].'-'.$serial["SerialB"];
            //$ret=$rb.'<br/>'.$ret;
            $val= new stockroom_serialnumber ($request->all());
            $val->stkr_srial_putting_product_id=$Putting_productId;
            $val->stkr_srial_serial_numbers_a=$serial["SerialA"];
            if (array_key_exists("SerialB",$serial))
            {
                  $val->stkr_srial_serial_numbers_b=$serial["SerialB"];
            }

            $val->stkr_srial_more="";
            $val->stkr_srial_status=0;
            $val->deleted_flag=0;
            $val->archive_flag=0;
            $val->save();
          }
        }
        //*****************
          $prctID = \DB::table('stockroom_stock_putting_products AS stock')
                      ->join('stockroom_products AS products' , 'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
                      ->where('stock.id', '=', $Putting_productId)
                      ->select(  \DB::raw('products.id AS  productID'))
                      ->get();
          $product_id =$prctID[0]->productID ;
          //---------
      //if  $product_id is new / not in tabel
         $val= new stockroom_product_statu ($request->all());
         $val->sps_product_id =$product_id;
         $val->sps_available =$real_QTY;
         $val->deleted_flag=0;
         $val->archive_flag=0;
         $val->save();
       //-----
     }

//-------------------------------------------------

public function editSerialNumber(Request $request)
{ $Step1=false;$Step2=false;
  $data=$request->all();
  $array_SerialNumbers= $data['SerialNumbers'];

  $puttingProductsID=$data['puttingProductsID'];
  $real_QTY=0;
  $ret=" ";
  $ErrorMSG=array(\Lang::get('labels.SerialNumbers_duplicated'));

  foreach ($array_SerialNumbers as $serial)
    {
    if (array_key_exists("SerialA",$serial))
    {
        $SN1count = \DB::table('stockroom_serialnumbers')
                    ->where('stockroom_serialnumbers.stkr_srial_serial_numbers_a', $serial["SerialA"])
                    ->count();
      //.........
      if ($SN1count==0)
      {
          $real_QTY++;
          $val= new stockroom_serialnumber ($request->all());
          $val->stkr_srial_putting_product_id=$puttingProductsID;
          $val->stkr_srial_serial_numbers_a=$serial["SerialA"];
          if (array_key_exists("SerialB",$serial))
          {
              $SN2count = \DB::table('stockroom_serialnumbers')
                  ->where('stockroom_serialnumbers.stkr_srial_serial_numbers_b', $serial["SerialB"])
                  ->count();
              if ($SN2count==0)
                $val->stkr_srial_serial_numbers_b=$serial["SerialB"];
              else  array_push($ErrorMSG,\Lang::get('labels.serialNumber_last').'-'.': '.$serial["SerialB"]);  //$ErrorMSG= $ErrorMSG.'/ SerialB :'.$serial["SerialB"];
          }
          $val->stkr_srial_more="";
          $val->stkr_srial_status=0;
          $val->deleted_flag=0;
          $val->archive_flag=0;
          if ($val->save()) $Step1=true;
      }
      else
      {
          array_push($ErrorMSG,\Lang::get('labels.serialNumber_first').'-'.' : '.$serial["SerialA"]);
//         $ErrorMSG= $ErrorMSG.'/Serial A '.$serial["SerialA"];
      }
    }
    }
  //*****************
    $prctID = \DB::table('stockroom_stock_putting_products AS stock')
                ->join('stockroom_products AS products' , 'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
                ->where('stock.id', '=', $puttingProductsID)
                ->select(  \DB::raw('products.id AS  productID'))
                ->get();
    $product_id =$prctID[0]->productID ;
  //*****************
    $count = stockroom_product_statu::where('sps_product_id', '=', $product_id)->count();
    if ($count==0)
    {
        //Add a new Record to  stockroom_product_status Table
        $productStatus = new stockroom_product_statu;
        $productStatus->sps_product_id=$product_id;
        $productStatus->sps_available=0;
        $productStatus->deleted_flag =0;
        $productStatus->archive_flag=0;
        $productStatus->save();
    }
  //*****************
    try
    {
            $QTYavailable = \DB::table('stockroom_product_status AS product_status')
                ->where('product_status.sps_product_id', '=', $product_id)
                ->select(  \DB::raw('product_status.sps_available AS  QTY_available'))
                ->get();
            $OldQTY =$QTYavailable[0]->QTY_available ;
            $val = stockroom_product_statu::where('sps_product_id', $product_id)->first();
            $val->sps_available= $real_QTY+$OldQTY;
            if ($val->save()) $Step2=true;
            if (count($ErrorMSG)>1)
                return $ErrorMSG;
  //*****************

    }
    catch (Exception $exception)
    {
        return  '('.$exception->getCode().')'. $exception->getMessage();
    }
    //if ($Step1 && $Step2) return 1;
  //  else return 0;
}

/*
public function editSerialNumber(Request $request)
{
  $data=$request->all();
  $array_SerialNumbers= $data['SerialNumbers'];
  $puttingProductsID=$data['puttingProductsID'];
    $ret=" ";
  foreach ($array_SerialNumbers as $serial)
  {
      if (isset ($serial["rowId"]))
      {
        $rb=$serial["SerialA"].'-'.$serial["SerialB"];
        $ret=$rb.'<br/>'.$ret;

        $RowID=$serial['rowId'];
        $val = stockroom_serialnumber::where('id', $RowID)->first();
        $val->stkr_srial_serial_numbers_a=$serial["SerialA"];
        $val->stkr_srial_serial_numbers_b=$serial["SerialB"];
        $val->save();
      }
      else
      {
        if  (isset ($serial["SerialA"]) &&  isset($serial["SerialB"]))
          {
            $val= new stockroom_serialnumber ($request->all());
            $val->stkr_srial_putting_product_id=$puttingProductsID;
            $val->stkr_srial_serial_numbers_a=$serial["SerialA"];
            $val->stkr_srial_serial_numbers_b=$serial["SerialB"];
            $val->stkr_srial_more="";
            $val->stkr_srial_status=0;
            $val->deleted_flag=0;
            $val->archive_flag=0;
            $val->save();
          }
          //  $ret="no <br/>".$ret.$serial["SerialA"].'<br/> '.$serial["SerialB"];

      }
  }

  //++++ Changing stock inventory +++++++
    $prctID = \DB::table('stockroom_stock_putting_products AS stock')
                ->join('stockroom_products AS products'   ,   'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
                ->where('stock.id', '=', $puttingProductsID)
                ->select(  \DB::raw('products.id AS  productID'))
                ->get();
    $qty=5;
    $val= new stockroom_product_statu ($request->all());
    $val->sps_product_id =$prctID[0]->productID;
    $val->sps_available = $qty;
    $val->deleted_flag=0;
    $val->archive_flag=0;
    $val->save();
  //+++++++++++++++++++++++++++++++++++++
     return 1;
}
*/


public function add_ChassesPart_to_DB(Request $request)
{

    $Pcount = \DB::table('Stockroom_stock_putting_products')
                ->where('Stockroom_stock_putting_products.stkr_stk_putng_prdct_order_id', $request->orderid)
                ->where('Stockroom_stock_putting_products.stkr_stk_putng_prdct_product_id', $request->productid)
                ->where('Stockroom_stock_putting_products.stkr_stk_putng_prdct_partofchassis', $request->chassisid)
                ->count();
     if ($Pcount)
        return 0;
      else
      {
        $val= new Stockroom_stock_putting_product ($request->all());
        $val->stkr_stk_putng_prdct_order_id =$request->orderid;
        $val->stkr_stk_putng_prdct_product_id =$request->productid;
        $val->stkr_stk_putng_prdct_partofchassis=$request->chassisid;
        $val->stkr_stk_putng_prdct_qty =$request->QTYValue;
        $val->stkr_stk_putng_prdct_in_date ="";//$Jdate;
        $val->stkr_stk_putng_prdct_tech_part_numbers ="";
        $val->stkr_stk_putng_prdct_chassis_number ="";
        $val->stkr_stk_putng_prdct_SO_Number ="";
        $val->stkr_stk_putng_prdct_serial_Number_id=1;
        $val->stkr_stk_putng_prdct_More_info ="";
        $val->deleted_flag =0;
        $val->archive_flag=0; //Not defined
    //--------------------------------------
        if ($val->save())
        return 1;
      }

}


public  function Get_subChassis_Parts (Request $request)
  {
    $data = $request->all();
    $serial_Parent=$data['serial_Parent'];
    $Product_Parent=$data['Product_Parent'];

       $val = \DB::table('stockroom_stock_putting_products')
        //  ->join('stockroom_serialnumbers AS serialnumbers'   ,   'serialnumbers.stkr_srial_putting_product_id', '=','stockroom_stock_putting_products.id')
          ->join('stockroom_products AS products'   ,   'products.id', '=','stockroom_stock_putting_products.stkr_stk_putng_prdct_product_id')
          ->join('stockroom_orders AS orders'   ,   'orders.id', '=','stockroom_stock_putting_products.stkr_stk_putng_prdct_order_id')
           ->select('*')
          //->select('*', \DB::raw('stockroom_products.id AS ProductsID  , brands.id AS BrandID ,types.id AS TypeID'))
          ->where('stockroom_stock_putting_products.stkr_stk_putng_prdct_partofchassis', '=', $Product_Parent)
          ->where('stockroom_stock_putting_products.deleted_flag', '=', 0)


        ->get();
        return $val;
  }

  //-------------------

    public function SaveSubSerialFields (Request $request)
    {
        $data = $request->all();
        $product_id=$data["product_id"];
        $SerialparentID =$data["SerialParent"];
        $puttingProductsID =$data["puttingProductsID"];
        $serialNumbers=$data["SerialNumbers"];
        $real_QTY=0;
        $ErrorMSG=array(\Lang::get('labels.SerialNumbers_duplicated'));

//*******************************
        $ValStockID = \DB::table('stockroom_stock_putting_products AS stock')
            ->where('stock.stkr_stk_putng_prdct_partofchassis', '=', $puttingProductsID)
            ->where('stock.stkr_stk_putng_prdct_product_id', '=', $product_id)
            ->select(  \DB::raw('stock.id AS  Stock_id'))
            ->get();
        $StockID =$ValStockID[0]->Stock_id ;

//*******************************
        $NextDoor=true;

        if ($NextDoor)
        {
            foreach ($serialNumbers as $serial)
            {
                if (array_key_exists("SerialA",$serial))
                {
                    $SN1count = \DB::table('stockroom_serialnumbers')
                        ->where('stockroom_serialnumbers.stkr_srial_serial_numbers_a', $serial["SerialA"])
                        ->count();
                    //.........
                    if ($SN1count==0)
                    {
                        $real_QTY=$real_QTY+1;
                        $val= new stockroom_serialnumber ($request->all());
                        $val->stkr_srial_putting_product_id=$StockID;
                        $val->stkr_srial_serial_numbers_a=$serial["SerialA"];
                        if (array_key_exists("SerialB",$serial))
                        {
                            $SN2count = \DB::table('stockroom_serialnumbers')
                                ->where('stockroom_serialnumbers.stkr_srial_serial_numbers_b', $serial["SerialB"])
                                ->count();
                            if ($SN2count==0)
                                $val->stkr_srial_serial_numbers_b=$serial["SerialB"];
                            else  array_push($ErrorMSG,\Lang::get('labels.serialNumber_last').' : '.$serial["SerialB"]);
                        }
                        $val->stkr_srial_parent=$SerialparentID;
                        $val->stkr_srial_more="";
                        $val->stkr_srial_status=0;
                        $val->deleted_flag=0;
                        $val->archive_flag=0;
                        if ($val->save()) $Step1=true;
                    }
                    else
                    {
                        array_push($ErrorMSG,\Lang::get('labels.serialNumber_first').' : '.$serial["SerialA"]);
                    }
                }

            }

        }

//*******************************
        $QTYavailable = \DB::table('stockroom_product_status AS product_status')
            ->where('product_status.sps_product_id', '=', $product_id)
            ->select(  \DB::raw('product_status.sps_available AS  QTY_available'))
            ->get();
        try {
            if (count($QTYavailable ))
            { //it's in DB -> need Update
                $OldQTY =$QTYavailable[0]->QTY_available ;
                $val = stockroom_product_statu::where('sps_product_id', $product_id)->first();
                $availableQty=$real_QTY+$OldQTY;
                $val->sps_available= $availableQty;
                $val->deleted_flag =0;
                $val->archive_flag=0;
                if ($val->save()) return 'Updated ...'.$real_QTY;
                else return 'Error ';
            }
            else
            { // It's New
                $val= new stockroom_product_statu ($request->all());
                $val->sps_product_id=$product_id;
                $val->sps_available=$real_QTY;
                $val->deleted_flag=0;
                $val->archive_flag=0;
                $val->save();
                return 'New';
            }

//            $NextDoor=true;
//            if (count($ErrorMSG)>1)
//                return $ErrorMSG;
           // return $real_QTY;

        }

        catch (\Exception $exception) {
            $NextDoor=false;
          return  array_push ($ErrorMSG,'('.$exception->getCode().')'. $exception->getMessage());

        }

//*******************************



        //*****************



    }

public function getSubSerialNumbers (Request $request)
{
    $data = $request->all();
    $PuttingProduct_ID=$data["PuttingProduct_ID"];
    $product_ID =$data["productID"];
    $serialParent_ID=$data ["serialParent_ID"];

    $SubSerials = \DB::table('stockroom_stock_putting_products AS stock')
                  ->join('stockroom_serialnumbers AS serialnumbers'   ,   'serialnumbers.stkr_srial_putting_product_id', '=','stock.id')
                  ->where('stock.stkr_stk_putng_prdct_partofchassis', '=', $PuttingProduct_ID)
                  ->where('stock.stkr_stk_putng_prdct_product_id', '=', $product_ID)
                  ->where('serialnumbers.stkr_srial_parent', '=', $serialParent_ID)
                  ->select(  \DB::raw('serialnumbers.stkr_srial_serial_numbers_a AS  serialA ,
                                       serialnumbers.stkr_srial_serial_numbers_b AS  serialB ,
                                       serialnumbers.id AS  serialID
                  '))
                  ->get();
                return    $SubSerials ;


}

public function countOf_SubChassis (Request $request)
{
    $data = $request->all();
    $putting_product_id=$data["putting_product_id"];
    $ordrs_Id=$data["ordrs_id"];

    $Serials = \DB::table('stockroom_serialnumbers AS serialnumbers')
          ->where('serialnumbers.stkr_srial_putting_product_id', '=', $putting_product_id)
          ->get();
//-----------------
    $SumQTY = \DB::table('stockroom_stock_putting_products AS stock')
        ->where('stock.stkr_stk_putng_prdct_partofchassis', '=', $putting_product_id)
        ->sum('stock.stkr_stk_putng_prdct_qty');
//-----------------
    $i=0;
    $outArray=array();
    foreach ($Serials AS $sn)
    {
        $i++;
        $countSubSerials = \DB::table('stockroom_serialnumbers AS serialnumbers')
            ->where('serialnumbers.stkr_srial_parent', '=', $sn->id)
            ->orderBy('serialnumbers.id', 'DESC')
            ->count();
        //-----------
        $soldSerials = \DB::table('stockroom_serialnumbers AS serialnumbers')
            ->join('sell_takeoutproducts AS takeoutproducts', 'takeoutproducts.sl_top_product_serialnumber_id', '=','serialnumbers.id')
            ->where('serialnumbers.id', '=', $sn->id)
            ->count();
        //-----------

        $chiledArray = array("id"=>$sn->id, "count"=>$countSubSerials ,"totalQTY"=>$SumQTY  ,"SrialStatus"=>$soldSerials,"S1"=>$sn->stkr_srial_serial_numbers_a , "S2"=>$sn->stkr_srial_serial_numbers_b );
        array_push($outArray,$chiledArray);
    }
    return $outArray;


}
//------------------
public function delete_Serial_Number(Request $request)
    {
        $data = $request->all();
        $putting_productsID=$data["putting_productsID"];
        $serialID=$data["serialID"];
        $typeCat=$data["typeCat"];
            try
            {
                $access=false;
                if ($typeCat ==3)
                {
                    $count = stockroom_serialnumber::where('stkr_srial_parent', '=', $serialID)->count();
                    if ($count==0) {$access=true;}
                    else return 'serialInChassis';
                }
                else
                {
                    $access=true;
                }

                if ($access)
                {
                    $model = stockroom_serialnumber::where('id', '=', $serialID)->firstOrFail();
                    $srial_status= $model['stkr_srial_status'];
                    if ($srial_status==0)
                    {

                        if (isset( $data["product_id"] )) //In SubChassis Serial Number  product_id directly sent
                            $productID =$data["product_id"];
                        else
                        {
                            $model = Stockroom_stock_putting_product::where('id', '=', $putting_productsID)->firstOrFail();
                            $productID= $model['stkr_stk_putng_prdct_product_id'];
                        }
                        $modelB = stockroom_product_statu::where('sps_product_id', '=', $productID)->firstOrFail();
                         '$productID :'.$productID.' $available :'. $available= $modelB['sps_available'];

                        $val = stockroom_product_statu::where('sps_product_id', $productID)->first();
                        $val->sps_available= $available-1;

                        if ($val->save())
                        {
                            stockroom_serialnumber::destroy($serialID);
                        }
                        else
                        {
                            $val = stockroom_product_statu::where('sps_product_id', $productID)->first();
                            $val->sps_available= $available+1;
                        }
                    }
                }
            }
            catch (\Exception $e)
            {
                return $e->getMessage();
            }
    }

//-----------------
    public function RemoveSubChassisSerial(Request $request)
    {
        $data=$request->all();
        $serialNumberA=$data['serialNumberA'];
        return $PuttingProductID=$data['PuttingProductID'];
          $product_id =$data['product_id'];


//        $model = stockroom_serialnumber::where('stkr_srial_serial_numbers_a', '=', $serialNumberA)->firstOrFail();
//        $srial_status= $model['stkr_srial_status'];
//        $availableQTY= $model['sps_available'];
//        $srial_ID= $model['id'];
//
//        if ($srial_status==0)
//        {
//
//            $modelB = stockroom_product_statu::where('sps_product_id', '=', $productID)->firstOrFail();
//            $available= $modelB['sps_available'];
//
//            $val = stockroom_product_statu::where('sps_product_id', $productID)->first();
//            $val->sps_available= $available-1;
//
//            if ($val->save())
//            {
//                stockroom_serialnumber::destroy($serialID);
//            }
//
//
//
//        }

    }
//-----------------

    public function Get_qty($id)
    {
         $model = stockroom_stock_putting_product::where('id', '=',$id )->firstOrFail();
         return  $model['stkr_stk_putng_prdct_qty'];
    }

    public function reports( Request $request ,$orderID)
    {
      $retArray=  $this->getinQry($orderID) ;
      $outArray=$retArray[0];
      $total_Qty=$retArray[1];
     return view('stockroom/view_puttingProducts_ToStock/reports/page' , compact('outArray','total_Qty'));
    }

    public function getinQry ($orderID)
    {
        $StockList = \DB::table('stockroom_stock_putting_products AS stock_putting')
            ->join('stockroom_products AS products', 'products.id', '=','stock_putting.stkr_stk_putng_prdct_product_id')
            ->join('stockroom_products_brands AS brands', 'brands.id', '=','products.stkr_prodct_brand')
            ->join('stockroom_products_types  AS types',   'types.id', '=','products.stkr_prodct_type')

            ->where('stock_putting.stkr_stk_putng_prdct_order_id', '=', $orderID)
            ->select('*', \DB::raw('
                                    stock_putting.id AS stockID,
                                    products.stkr_prodct_partnumber_commercial AS partnumber ,
                                    products.stkr_prodct_title AS  prodct_title ,
                                    stock_putting.stkr_stk_putng_prdct_qty AS Qty,                                    
                                    stock_putting.stkr_stk_putng_prdct_partofchassis  
                                    '))
            ->get();

        $outArray =array();
        $total_Qty=0;
        foreach ($StockList AS  $SL)
        {
            if ( $SL->stkr_stk_putng_prdct_partofchassis ==null )
            {
                $total_Qty= $total_Qty+$SL->Qty;
                $itemQty=$SL->Qty;
            }
            else
            {
                $parentID= $SL->stkr_stk_putng_prdct_partofchassis;
                $parentQty=$this->Get_qty($parentID);
                $total_Qty= $total_Qty+($SL->Qty*$parentQty);
                $itemQty=$parentQty.'x'.$SL->Qty;
            }

            $typeCatTitle="";
               switch ($SL->stkr_prodct_type_cat )
                {
                    case 1: $typeCatTitle= \Lang::get('labels.Product_type_part') ;break;
                    case 2: $typeCatTitle= \Lang::get('labels.Product_type_partOfChassiss');break;
                    case 3: $typeCatTitle= \Lang::get('labels.Product_type_chassis');break;
                }

            $currentDate=  PublicClass::convert_gregorian_to_jalali(date("Y"),date("m"),date("d"));
            $ItemArray=array('stockID'=> $SL->stockID  ,
                'partNumber' =>$SL->partnumber ,
                'prodctTitle'=>$SL->prodct_title ,
                'brand'=>$SL->stkr_prodct_brand_title ,
                'type'=>$SL->stkr_prodct_type_title ,
                'typeCat'=> $typeCatTitle ,
                'Qty'        =>$itemQty ,
                "currentDate"=>$currentDate,
                'tadbirID' => $SL->stkr_tadbir_stock_id,
                'parentChassis' => $SL->stkr_stk_putng_prdct_partofchassis


            );
            array_push($outArray,$ItemArray);
        }

        return array($outArray,$total_Qty);
    }
}
