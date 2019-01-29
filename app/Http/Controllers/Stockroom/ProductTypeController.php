<?php
namespace App\Http\Controllers\Stockroom;

use App\Stockroom_products_types;
use App\Mylibrary\StockroomClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductTypeController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }

  public function addNewType(Request $request)
  {

      $data = $request->all();
      $count = \App\Stockroom_products_types::
      where(['stkr_prodct_type_title' => $data['product_Type_Name'] ] )
       ->where(['stkr_prodct_type_In_brands' => $data['parent_Brand_ID'] ])
      ->count();
      if ($count>=1)
          return 100; //duplicated
      else
       {
          $val= new Stockroom_products_types ($request->all());
          $val->stkr_prodct_type_title =$request->product_Type_Name;
          $val->stkr_prodct_type_In_brands=$request->parent_Brand_ID;
          $val->archive_flag=0;
          $val->deleted_flag=0;
          $val->save();
        }
  }


    public function get_Product_Types_ByBrandID($brandid)
    {
      if ($brandid =="null")
        {
          return  $product = \DB::table('stockroom_products_types')
          ->where('stockroom_products_types.deleted_flag', '=', 0)
          ->orderBy('stockroom_products_types.id', 'desc')
          ->get();
        }
        else
        {
          return  $product = \DB::table('stockroom_products_types')
          ->where('stockroom_products_types.deleted_flag', '=', 0)
          ->where('stockroom_products_types.stkr_prodct_type_In_brands', '=', $brandid)
          ->orderBy('stockroom_products_types.id', 'desc')
          ->get();
        }
    }

}
