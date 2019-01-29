<?php

namespace App\Http\Controllers\Stockroom;
//>>>>>>>>>>>> Model
use App\Stockroom_products_brands;
use App\Stockroom_products;
use App\Stockroom_products_type;
use App\Mylibrary\StockroomClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductBrandsController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }
    public function addNewBrand(Request $request)
    {
        $data = $request->all();
        $count = \App\Stockroom_products_brands::where(['stkr_prodct_brand_title' => $data['newBrand'] ])->count();
        if ($count>=1)
            return 'is_dublicate';
        else
         {
            $val= new Stockroom_products_brands ($request->all());
              $val->stkr_prodct_brand_title =$request->newBrand;
              $val->archive_flag=0;
              $val->deleted_flag=0;
              $val->save();
         }
      }

    public function get_Product_brandsx()
    {//$data['productID']
        return  $product = \DB::table('stockroom_products_brands')->get();
    }

}
