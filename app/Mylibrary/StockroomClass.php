<?php
namespace App\Mylibrary;
use App\Stockroom_products;
use App\Mylibrary\PublicClass;
use Illuminate\Support\Facades\Auth;

use App\Stockroom_stock_putting_product;
use App\sell_stockrequests_detail;
use App\sell_invoice_detail;
use App\sell_takeoutproduct;
class StockroomClass
{

    public function insert_form($request)
    {
        $data = $request->all();

        $String=$data['PartNumber_comersial'] ;
        $IsolatedPartNum=new PublicClass();
        $NewPartNumber=  $IsolatedPartNum->checkAscii($String);

        // DataBase Validation
        $count = \App\Stockroom_products::where(['stkr_prodct_partnumber_commercial' => $data['PartNumber_comersial'] ])->count();
        $count2= \App\Stockroom_products::where(['stkr_prodct_partnumber_commercial' => $NewPartNumber ])->count();
        if ($count>=1 || $count2>=1 )
            return 'partNumbetCommercial_is_dublicate';
        //------------ DataBase Validation
        else
        {
            $val= new Stockroom_products ($request->all());
            $val->stkr_prodct_partnumber_commercial =$NewPartNumber;
            $val->stkr_prodct_title =$request->Product_title;
            $val->stkr_prodct_brand=$request->Product_brand;
            $val->stkr_prodct_type=$request->org_Product_type;
            $val->stkr_prodct_type_cat=$request->Product_type_cat;
            $val->stkr_prodct_price =$request->org_Product_price;
            $val->stkr_prodct_two_serial=$request->prodct_two_serial;
            $val->stkr_tadbir_stock_id =$request->product_inpt_tadbir_stock_id;
            $val->archive_flag =0;
            $val->deleted_flag =0;

            try {
                $val->save();
                $string="/stock/product/new |"."addProductToDB() | "."new-Product:".$val->stkr_prodct_title.'|'.$val->stkr_prodct_partnumber_commercial;
                $add_log= new PublicClass();
                $add_log->add_user_log($string,"OK",Auth::user()->id);
                return 1;
                // Closures include ->first(), ->get(), ->pluck(), etc.
            } catch(\Illuminate\Database\QueryException $ex){
                $string="/stock/product/new |"."addProductToDB() | "."new-Product ".$ex->getMessage();
                $add_log= new PublicClass();
                $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
                return 0;
                // Note any method of class PDOException can be called on $ex.
            }
            //--------LOG---------------
        }
    }

  public static function moveProducttoTrash ($request)
  {

    $data = $request->all(); // This will get all the request data.
    $productId=  $data['productIdSelect'];
    $count_stock = Stockroom_stock_putting_product::where('stkr_stk_putng_prdct_product_id', '=', $productId)->count();
    $count_stockrequests =  sell_stockrequests_detail::where('ssr_d_product_id', '=', $productId)->count();
    $count_invoice =  sell_invoice_detail::where('sid_product_id', '=', $productId)->count();
    $count_takeout =  sell_takeoutproduct::where('sl_top_productid', '=', $productId)->count();
//      \DB::table('stockroom_products')
//          ->where('id', $data['productIdSelect'])
//          ->update(['deleted_flag' => 1]); //delete Flag

      if ($count_stock ==0 && $count_stockrequests ==0 && $count_invoice ==0 && $count_takeout ==0  )
      {
          try {
              $data = $request->all(); // This will get all the request data.
              \DB::table('stockroom_products')
                  ->where('id', $data['productIdSelect'])
                  ->update(['deleted_flag' => 1]); //delete Flag
              //LOG
              $string="/stock/product/new |"."moveToTrash(product.productID) | "."deleteFlag for ID :".$data['productIdSelect'];
              $add_log= new PublicClass();
              $add_log->add_user_log($string,"OK",Auth::user()->id);
              return 1;
          } catch(\Illuminate\Database\QueryException $ex){
              $string="/stock/product/new |"."moveToTrash(product.productID) | "."new-Product ".$ex->getMessage();
              $add_log= new PublicClass();
              $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
              return 0;
          }
      }
      else
          return 'InUse';

  }
  public static function RestoreProductFromTrash ($request)
    {
        try {
            $data = $request->all(); // This will get all the request data.
            \DB::table('stockroom_products')
                ->where('id', $data['productIdSelect'])
                ->update(['deleted_flag' => 0]); //delete Flag

            //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
            $string="/stock/product/new |"."RestoreFromTrash(product.productID) | "."deleteFlag for ID :".$data['productIdSelect'];
            $add_log= new PublicClass();
            $add_log->add_user_log($string,"OK",Auth::user()->id);
            return 1;
        } catch(\Illuminate\Database\QueryException $ex){
            $string="/stock/product/new |"."RestoreFromTrash(product.productID) | "."new-Product ".$ex->getMessage();
            $add_log= new PublicClass();
            $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
            return 0;
        }
        //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<

    }

  public static function move_Selected_Products_to_Trash($request)
  {
      try {
          $data = $request->all();
          foreach ($data as $id )
          {
              \DB::table('stockroom_products')
                  ->where('id', $id)
                  ->update(['deleted_flag' => 1]); //delete Flag
              //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
              $string="/stock/product/new |"."moveGroupToTrash() | "."deleteFlag for ID :".$id;
              $add_log= new PublicClass();
              $add_log->add_user_log($string,"OK",Auth::user()->id);
              //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
          }

      } catch(\Illuminate\Database\QueryException $ex){
          $string="/stock/product/new |"."moveGroupToTrash(product.productID) | "."new-Product ".$ex->getMessage();
          $add_log= new PublicClass();
          $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
          return 0;
      }

  }

  public static function Restore_Selected_Products_From_Trash($request)
  {

      try {
          $data = $request->all();
          foreach ($data as $id )
          {
              \DB::table('stockroom_products')
                  ->where('id', $id)
                  ->update(['deleted_flag' => 0]); //delete Flag
              //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
              $string="/stock/product/new |"."RestoreGroupFromTrash()  | "."deleteFlag for ID :".$id;
              $add_log= new PublicClass();
              $add_log->add_user_log($string,"OK",Auth::user()->id);
              //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
          }
      } catch(\Illuminate\Database\QueryException $ex){
          //FAILD_LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
          $string="/stock/product/new |"."RestoreGroupFromTrash() | "."new-Product ".$ex->getMessage();
          $add_log= new PublicClass();
          $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
          return 0;
          //FAILD_LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
      }
  }

  public static function delete_Product_From_DataBase($request)
  {


      try {
              $data = $request->all();
              \DB::table('stockroom_products')
              ->where('id', '=', $data['productIdSelect'])->delete();
              //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
              $string="/stock/product/new |"."DeleteFromDataBase(product.productID)| "."deleteFrom_DataBase for ID :".$data['productIdSelect'] ;
              $add_log= new PublicClass();
          $add_log->add_user_log($string,"OK",Auth::user()->id);
              //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<

      } catch(\Illuminate\Database\QueryException $ex){
          //FAILD_LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
          $string="/stock/product/new |"."DeleteFromDataBase(product.productID) | "."deleteFrom_DataBase for ID: ".$data['productIdSelect'].$ex->getMessage();
          $add_log= new PublicClass();
          $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
          return 0;
          //FAILD_LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
      }

  }

  public static function Delete_Selected_Products_From_Database($request)
  {
      try {

      $data = $request->all();
      foreach ($data as $id )
      {
          \DB::table('stockroom_products')
              ->where('id', '=', $id )->delete();
          //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
          $string="/stock/product/new |"."delete_selected_products() | "."deleteFrom_DataBase for ID :".$id  ;
          $add_log= new PublicClass();
          $add_log->add_user_log($string,"OK",Auth::user()->id);
      }

          //LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
      } catch(\Illuminate\Database\QueryException $ex){
          //FAILD_LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
          $string="/stock/product/new |"."delete_selected_products() | "."deleteFrom_DataBase for ID: ".$id .$ex->getMessage();
          $add_log= new PublicClass();
          $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
          return 0;
          //FAILD_LOG<<<<<<<<<<<<<<<<<<<<<<<<<<<<
      }

  }

  public static function Update_product_in_Edit_Dimmer ($request)
  {
      $data = $request->all();
      // DataBase Validation
      $Product_id= $data['Product_id'];
       $result = \App\Stockroom_products::
                where(['stkr_prodct_partnumber_commercial' => $data['PartNumber_comersial'] ])
//                ->where(['id' => $Product_id ])
                ->get();
       $flag=false;
       if (count($result)<1)
       {
           $flag=true;
//           return 'its new PartNumber';
       }
       else if ( count($result)==1)
       {

           if ($result[0]['id']==$Product_id)
               $flag=true;
           else
               return 'partNumbetCommercial_is_dublicate';
//               return 'Just Update';
       }
      else
      {
          return 'partNumbetCommercial_is_dublicate';
      }

      //------------ DataBase Validation
//      else
   if($flag)   {
//=================================
          $String=$request->PartNumber_comersial;
          $NewString="";
          for ($i=0; $i<=strlen($String)-1 ; $i++)
          {
              $char= ord($String[$i]);
              if ($char<=126 && $char>=0 )
                  $NewString=$NewString.chr($char);
              else
              {
                  if (ord($String[$i]) ==226 && ord($String[$i+1])==128 && ord($String[$i+2])==144 )
                      $NewString=$NewString.'-';
              }
          }
//=================================
          try {
              $PID=  $request->Product_id;
              $val = Stockroom_products ::where('id', $PID)->first();
              $val->stkr_prodct_partnumber_commercial =$NewString;
              $val->stkr_prodct_title =$request->Product_title;
              $val->stkr_prodct_brand=$request->Product_brand;
              $val->stkr_prodct_type=$request->org_Product_type;
              $val->stkr_prodct_type_cat=$request->Product_type_cat;
              $val->stkr_prodct_price =$request->org_Product_price;
              $val->stkr_prodct_two_serial=$request->prodct_two_serial;
              $val->stkr_tadbir_stock_id =$request->tadbir_stock_id;
              $val->archive_flag =0;
              $val->deleted_flag =0;
              $val->save();
              //--------LOG---------------
              $string="/stock/allproducts |"." Dimmer |"."editProduct_save() | "."for ID :".$PID."/".$request->Product_title;
              $add_log= new PublicClass();
              $add_log->add_user_log($string,"OK",Auth::user()->id);
              return 1;
          } catch(\Illuminate\Database\QueryException $ex){
              $string="/stock/allproducts |"." Dimmer |"."editProduct_save() | "."for ID :".$PID."/".$request->Product_title.$ex->getMessage();
              $add_log= new PublicClass();
              $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
              return 0;
              //--------LOG---------------
          }
      }
  }





}
