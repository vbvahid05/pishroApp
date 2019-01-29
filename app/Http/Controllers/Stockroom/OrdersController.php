<?php

namespace App\Http\Controllers\Stockroom;
//Model
use App\stockroom_order;
use App\stockroom_orders_status;
use App\stockroom_orders_seller;
use App\Stockroom_stock_putting_product;
use App\stockroom_serialnumber;
//Model

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mylibrary\PublicClass;
use App\Mylibrary\stock\Orders;
use Illuminate\Support\Facades\Auth;
use Gate;




class OrdersController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth'))
            return "OK";
        else return view('/login');
    }


    //,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
    public  function  get_Order_filter_Data(request $request  )
    {
        return $request;
    }
//,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
    public function ManageStockRoutes (request $request ,$controller ,$function)
    {
        $data=$request->all();
        switch ($controller)
        {
            case 'orders':
                    switch ($function)
                    {
                        case 'updateStackrequest_info' :
                            $order=new Orders();
                             return $order->updateStackrequest_info($data);
                        break;
                    }
                break;
        }
    }

//,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
    public function showAllOrders($mode)
    {
       $Arry_Main = array();
       $stockroom_orders_status = \App\stockroom_orders_status::all();
       $stockroom_orders_sellers = \App\stockroom_orders_seller::all();
       $Users = \DB::table('users')
                ->select( \DB::raw('users.id AS userID ,users.name AS userName'))
                ->get();

       $val = \DB::table('stockroom_orders')
       ->join('stockroom_orders_status', 'stockroom_orders.stk_ordrs_status_id', '=','stockroom_orders_status.id')
       ->join('stockroom_orders_sellers', 'stockroom_orders.stk_ordrs_seller_id', '=','stockroom_orders_sellers.id')
       ->join('users', 'users.id', '=','stockroom_orders.stk_ordrs_user_id')

       ->where('stockroom_orders.deleted_flag', '=', $mode)
       ->select('*', \DB::raw('stockroom_orders.id AS orderID '))
       ->orderBy('stockroom_orders.id', 'desc')
       ->get();

        array_push($Arry_Main, $val);
        array_push($Arry_Main, $stockroom_orders_status);
        array_push($Arry_Main, $stockroom_orders_sellers);
        array_push($Arry_Main, $Users);

       return $Arry_Main;


    }
    //------------
    public function addNewOrder(request $request)
    {

      $validatedData = $request->validate([
          'order_seller' => 'required',
          'order_status' => 'required',
          'order_comment' => 'max:500',

      ]);
      try
      {
          $val= new stockroom_order ($request->all());
          $val->stk_ordrs_id_code	=$request->Order_code;
          $val->stk_ordrs_id_number=$request->Order_Number;
          $val->stk_ordrs_seller_id =$request->order_seller;
          $val->stk_ordrs_status_id =$request->order_status;
          $val->stk_ordrs_putting_date=date("Y/m/d");
          $val->stk_ordrs_comment =$request->order_comment;
          $val->stk_ordrs_user_id =Auth::id();
          $val->deleted_flag=0;
          $val->archive_flag=0;
          $val->save();
          //** Log **
          $string="/stock/AllOrders |"."add_new()>addNewOrderTo_DB()| "." orderID:".$val->stk_ordrs_id_code.'|'.$val->stk_ordrs_id_number;
          $add_log= new PublicClass();
          $add_log->add_user_log($string,"OK",Auth::user()->id );
      }
      catch (\Exception $e)
      {
          $string="/stock/AllOrders |"."add_new()>addNewOrderTo_DB() | ".$e->getMessage();
          $add_log= new PublicClass();
          $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
      }

    }
    //--------------

    public function updateOrder(request $request)
    {
        $data = $request->all();
        $order_ID=$data['ord_id'];
        $val = stockroom_order::where('id', $order_ID)->first();
        $val->stk_ordrs_id_number       =$request->ord_id_number;
        $val->stk_ordrs_seller_id       =$request->ord_seller_id;
        $val->stk_ordrs_status_id       =$request->ord_status;
        $val->stk_ordrs_comment         =$request->ord_MoreInfo;
        $val->stk_ordrs_putting_date    =date("Y/m/d");
        $val->deleted_flag              =0;
        $val->deleted_flag              =0;
        if ( $val->save())
          return 1;
    }
    //--------------
    public function showAllSellers()
    {
      return  $product = \DB::table('stockroom_orders_sellers')
      ->where('stockroom_orders_sellers.deleted_flag', '=', 0)
      ->orderBy('stockroom_orders_sellers.id', 'desc')
      ->get();
    }

    public function showAllStatus()
    {
      return  $product = \DB::table('stockroom_orders_status')
      ->where('stockroom_orders_status.deleted_flag', '=', 0)
      ->orderBy('stockroom_orders_status.id', 'desc')
      ->get();
    }

    public function getOrderData (request $request)
    {
        $data = $request->all();
        $row_ID=  $data['Selected_id'];
        return   $Order = \DB::table('stockroom_orders')
          ->join ('stockroom_stock_putting_products AS stock', 'stock.stkr_stk_putng_prdct_order_id', '=','stockroom_orders.id')
          ->join ('stockroom_products AS products', 'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
          ->join ('stockroom_products_brands AS brands', 'brands.id', '=','products.stkr_prodct_brand')
          ->join ('stockroom_products_types AS types', 'types.id', '=','products.stkr_prodct_type')
          ->join ('stockroom_orders_sellers AS seller', 'seller.id', '=','stockroom_orders.stk_ordrs_seller_id')
          ->where('stockroom_orders.id', '=', $row_ID)
         //  ->where('products.stkr_prodct_type_cat', '!=', 2) // hide DePart Products
          ->where('stock.stkr_stk_putng_prdct_partofchassis', '=', null)
          ->where('stockroom_orders.deleted_flag', '=', 0)
          ->select( \DB::raw('stockroom_orders.id AS Order_id  ,
                                  stock.id AS rowID  ,
                                  stock.stkr_stk_putng_prdct_product_id AS product_id,
                                  stock.id            AS putting_productsID ,
                                  stock.stkr_stk_putng_prdct_partofchassis AS partofchassis,
                                  stock.stkr_stk_putng_prdct_qty AS QTY,
                                  stockroom_orders.stk_ordrs_id_code AS ordrs_code,
                                  stockroom_orders.stk_ordrs_id_number AS ordrs_number,
                                  stockroom_orders.stk_ordrs_status_id AS ordr_statu,
                                  stockroom_orders.stk_ordrs_putting_date AS ordrs_date,
                                  stockroom_orders.stk_ordrs_comment AS orderComment,
                                  seller.stkr_ordrs_slr_name AS sellerName,
                                  products.id         AS productId,
                                  products.stkr_prodct_partnumber_commercial AS partNumber,
                                  products.stkr_prodct_title AS ProductTitle,
                                  brands.stkr_prodct_brand_title AS Brand,
                                  types.stkr_prodct_type_title AS Type,
                                  products.stkr_prodct_type_cat AS type_cat

                                  '))
          ->orderBy('rowID', 'asc')
          ->get();
    }

//----------------
      public function getJustOrderData (request $request)
      {
        $data = $request->all();
        $row_ID=  $data['Selected_id'];

        return   $Order = \DB::table('stockroom_orders')
        ->join ('stockroom_orders_sellers AS seller', 'seller.id', '=','stockroom_orders.stk_ordrs_seller_id')
        ->where('stockroom_orders.id', '=', $row_ID)
        ->where('stockroom_orders.deleted_flag', '=', 0)
        ->select( \DB::raw('stockroom_orders.id AS Order_id ,
                            stockroom_orders.stk_ordrs_id_code AS ordrs_code ,
                            stockroom_orders.stk_ordrs_id_number AS ordrs_number,
                            stockroom_orders.stk_ordrs_status_id AS ordr_statu,
                            stockroom_orders.stk_ordrs_putting_date AS ordrs_date ,
                            stockroom_orders.stk_ordrs_comment AS orderComment,
                            seller.stkr_ordrs_slr_name AS  sellerName
         '))
        ->get();
      }
//----------------

public function GetpartNumberList ()
{
  return  \DB::table('stockroom_products')
  ->where('deleted_flag', '=',0)
//  ->where('stkr_prodct_type_cat', '!=', 2 )
  ->orderBy('id', 'desc')
  ->get();
}
    public function getOrderData_partsInChassis (request $request)
    {
      $data = $request->all();
      $order_ID=   $data['order_ID'];
      $Product_ID=  $data['Product_ID'];
      $puttingStock_ID= $data['puttingStock_ID'];


      return   $Order = \DB::table('stockroom_orders')
        ->join ('stockroom_stock_putting_products AS stock', 'stock.stkr_stk_putng_prdct_order_id', '=','stockroom_orders.id')
        ->join ('stockroom_products AS products', 'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
        ->join ('stockroom_products_brands AS brands', 'brands.id', '=','products.stkr_prodct_brand')
        ->join ('stockroom_products_types AS types', 'types.id', '=','products.stkr_prodct_type')

        ->where('stock.stkr_stk_putng_prdct_order_id', '=',$order_ID)
        ->where('stock.stkr_stk_putng_prdct_partofchassis', '=',$puttingStock_ID)
        ->where('products.stkr_prodct_type_cat', '=', 2) // hide DePart Products
        ->where('stockroom_orders.deleted_flag', '=', 0)
        ->select( \DB::raw('stockroom_orders.id AS Order_id  ,
                                stock.id AS rowID  ,
                                stock.stkr_stk_putng_prdct_product_id AS product_id,
                                stock.id            AS putting_productsID ,
                                stock.stkr_stk_putng_prdct_partofchassis AS partofchassis,
                                stock.stkr_stk_putng_prdct_qty AS QTY,
                                stockroom_orders.stk_ordrs_id_code AS ordrs_code,
                                stockroom_orders.stk_ordrs_status_id AS ordr_statu,
                                stockroom_orders.stk_ordrs_putting_date AS ordrs_date,
                                products.id         AS productId,
                                products.stkr_prodct_partnumber_commercial AS partNumber,
                                products.stkr_prodct_title AS ProductTitle,
                                brands.stkr_prodct_brand_title AS Brand,
                                types.stkr_prodct_type_title AS Type,
                                products.stkr_prodct_type_cat AS type_cat

                                '))
        ->get();
    }

    public function generateNewOrderCode ()
    {
      $jy=idate("Y");$jm=idate("m");$jd=idate("d");$publicClass= new PublicClass;$date= $publicClass->convert_gregorian_to_jalali($jy,$jm,$jd);
      $PartI=  substr($date,2,2);
      //--------------------
      $LastID = \DB::table('stockroom_orders')
      ->orderBy('stockroom_orders.id', 'desc')
      ->select('id', \DB::raw('stockroom_orders.id AS orderID '))
      ->limit(1)
      ->get();
      //__________________________________

      $tableStatus = \DB::select("show table status from  pishro_data_service where Name = 'stockroom_orders'");
      if (empty($tableStatus)) {
          throw new \Exception("Table not found");
      }
      // Get first table result, get its next auto incrementing value
        $newId= $tableStatus[0]->Auto_increment;
       //$newId= $LastID[0]->id+1;
       $partII=$newId +1000;
       //--------------------
       $productCode=$PartI.'-'.$partII;
       return $values = array($newId,$productCode);
    }

    public function   Update_ProductOrders_DB(request $request)
    { $i=0;
      $Order_id=0;
      $Array = $request->all();
      $ordStatus=$Array['ordStatus'];
      $Arraydata=$Array['OrdersProducts'];
      foreach ($Arraydata as $ary)
      {
        if (isset ($ary["putting_productsID"])) //edit Record
          {
            $Order_id =$ary["Order_id"];
            $val = Stockroom_stock_putting_product::where('id', $ary['putting_productsID'])->first();
            $val->stkr_stk_putng_prdct_product_id=$ary["productId"];
            $val->stkr_stk_putng_prdct_qty=$ary["QTY"];
            $val->save();
            //-----------------
          }
        else // is a new Record
          {
            $val= new Stockroom_stock_putting_product ($ary);
            $val->stkr_stk_putng_prdct_order_id= $Order_id;
            $val->stkr_stk_putng_prdct_product_id=$ary["productId"];
            $val->stkr_stk_putng_prdct_tech_part_numbers="-";
            $val->stkr_stk_putng_prdct_qty=$ary["QTY"];
            $val->stkr_stk_putng_prdct_serial_Number_id=1;
            $val->stkr_stk_putng_prdct_in_date =date("Y/m/d");
            $val->stkr_stk_putng_prdct_chassis_number="-";
            $val->deleted_flag=0;
            $val->archive_flag=0;
            if ($val->save())
            $i=$i."Ok";
          }
      }
      //++++++++++++++
            $val = stockroom_order::where('id', $Order_id)->first();
            $val->stk_ordrs_status_id=$ordStatus;
            $val->save();
      //++++++++++++++
      return $i;
    }

    public function   Insert_ProductOrders_To_DB(request $request)
    {
     $val1="";
     $data = $request->all();
     $n= count( $data)-1;
     for ($i=0;$i<=$n;$i++)
     {
//       $val1=$val1."/".$data[$i]["partNumber"];
       $val= new Stockroom_stock_putting_product ($data[$i]);
       $val->stkr_stk_putng_prdct_order_id= $data[$i]["Order_id"];
       $val->stkr_stk_putng_prdct_product_id=$data[$i]["productId"];
       $val->stkr_stk_putng_prdct_tech_part_numbers="-";
       $val->stkr_stk_putng_prdct_qty=$data[$i]["QTY"];
       $val->stkr_stk_putng_prdct_serial_Number_id=1;
       $val->stkr_stk_putng_prdct_in_date =date("Y/m/d");
       $val->stkr_stk_putng_prdct_chassis_number="-";
       $val->deleted_flag=0;
       $val->archive_flag=0;
       if ($val->save())
       $val1=$val1."Ok";


     }
     return $val1;
     //return count( $data);


     //return $data[1]["partNumber"];

      $r="";
       //return count($request);
       $cunt=count($request);
       for ($i=0;$i<=$cunt;$i++)
       {
           $val= new stockroom_stock_putting_products ($request);
           $r=$r.$request[$i]["partNumber"];
          // return $r;
       }
       //$r=$r.$request[$i]["partNumber"];return $r;
      /*
      $val= new stockroom_order ($request->all());
      $val->stk_ordrs_id_code	=$request->Order_code;
      $val->stk_ordrs_id_number=$request->Order_Number;
      $val->stk_ordrs_seller_id =$request->order_seller;
      $val->stk_ordrs_status_id =$request->order_status;
      $val->stk_ordrs_putting_date=date("Y/m/d");
      $val->stk_ordrs_comment =$request->order_comment;
      $val->deleted_flag=0;
      $val->archive_flag=0;
      $val->save();
      */
    }

    ////-----------
    public function getRelatedProducts_ByType( request $request)
    {
        $data = $request->all();
         $brands_ID=   $data['brandsID'];
        $Type_ID=   $data['TypeID'];
         $type_Cat=   $data['typeCat'];


          $reult=    \DB::table('stockroom_products')
                    ->where('stkr_prodct_brand', '=', $brands_ID )
                    ->where('stkr_prodct_type', '=', $Type_ID )
                    ->where('stkr_prodct_type_cat', '=', 2 )
                    ->where('deleted_flag', '=', 0 )
                    ->orderBy('id', 'desc')
                    ->get();
            return $reult;

    }
//-----------------
    public function Delete_order_From_list( request $request)
    {
        $data = $request->all();
        $row_id=$data['selectesRowId'];
         $count = Stockroom_stock_putting_product::where('stkr_stk_putng_prdct_order_id', '=', $row_id)->count();
        if ($count==0)
        {
            stockroom_order::where('id', '=', $row_id) ->update(array('deleted_flag' => 1));
            return $count;
        }
        else
        {
            return $count;
        }

    }
//---------------------
    public function Order_check_SingleItemToDelete(request $request)
    {
        $data = $request->all();
        $OrderId=$data['OrderId'];
        try{
            $puttingProductsID=$data['puttingProductsID'];
            // 1: Item in stockroom_stock_putting_products ? 1->yes
            $Stock_count = stockroom_stock_putting_product::where('id', '=', $puttingProductsID)->count();
            // 2: count of serialnumber ==0
            $Serial_count = stockroom_serialnumber::
                            where('stkr_srial_putting_product_id', '=', $puttingProductsID)
                            ->count();
            //3: if Item is a Chassis And Have SubParts ...

              $partofchassis_count = stockroom_stock_putting_product::
                                   where('stkr_stk_putng_prdct_partofchassis', '=', $puttingProductsID)
                                   ->count();
            // 4: count==0 -> Update DeleteFlag
            if ($Stock_count && $Serial_count ==0 && $partofchassis_count==0)
            {
                stockroom_stock_putting_product::destroy($puttingProductsID);
                return 'deleted';
            }

            else if ($Stock_count && $Serial_count )
            {
                return 'deleteSerial';
            }
            else if ($Stock_count && $partofchassis_count)
            {
                return 'deletePartofchassis';
            }


        }
        catch (\Exception $ex)
        {
            return $ex->getMessage();
        }


    }

}
