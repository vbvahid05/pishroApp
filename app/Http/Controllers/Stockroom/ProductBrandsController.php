<?php

namespace App\Http\Controllers\Stockroom;
//>>>>>>>>>>>> Model
use App\Model_admin\cms_language;
use App\Model_admin\cms_shop_translate;
use App\Model_admin\cms_shop_translate_type;
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
              $latestId=$val->id;

             $brand= cms_shop_translate_type::where('cmsshptrst_type_title', '=', 'product_brand')->firstOrFail();
             $transTypeId= $brand['id'];

            $language= cms_language::where('lang_title', '=', 'fa')->firstOrFail();
            $languageId= $language['id'];

             $trans= new cms_shop_translate ();
             $trans->cmsshptransl_type = $transTypeId;
             $trans->cmsshptransl_target_id = $latestId;
             $trans->cmsshptransl_lang_id = $languageId;
             $trans->cmsshptransl_title = $request->newBrand;
             $trans->save();





         }
      }

    public function get_Product_brandsx()
    {//$data['productID']
        return  $product = \DB::table('stockroom_products_brands')->get();
    }

}
