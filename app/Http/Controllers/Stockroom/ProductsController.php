<?php

namespace App\Http\Controllers\Stockroom;
//>>>>>>>>>>>> Model
use App\Stockroom_products;
use App\Stockroom_products_brands;
use App\Stockroom_products_type;
use App\Mylibrary\StockroomClass;
use App\Mylibrary\PublicClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
  public  function showProducts()
  {
       $AllProducts = \DB::table('stockroom_products')
            ->join('stockroom_products_brands', 'stockroom_products_brands.id', '=', 'stockroom_products.stkr_prodct_brand')
            ->join('stockroom_products_types',  'stockroom_products_types.id', '=', 'stockroom_products.stkr_prodct_type')
            ->select('*', \DB::raw('stockroom_products_brands.stkr_prodct_brand_title AS Brand ,
                                  stockroom_products_types.stkr_prodct_type_title AS Type,
                                  stockroom_products.stkr_prodct_partnumber_commercial AS PartNumber,
                                  stockroom_products.stkr_prodct_title AS Title,
                                  stockroom_products.stkr_tadbir_stock_id AS Tadbir ,
                                  stockroom_products.stkr_prodct_price AS epl  ,
                                  stockroom_products.stkr_prodct_type_cat AS type_cat
           '))
             ->orderBy('stockroom_products.stkr_prodct_brand', 'ASC')
            ->get();
    $table="<table border='1' style=' border-collapse: collapse;'>";
      $table=$table."<tr>";
      $table=$table."<th>ردیف</th>";
      $table=$table."<th>پارتنامبر</th>";
      $table=$table."<th> گروه کالا</th>";
      $table=$table."<th> برند</th>";
      $table=$table."<th> نوع </th>";
      $table=$table."<th> عنوان کالا</th>";
      $table=$table."<th>قیمت EPL</th>";
       $table=$table."<th> کد کالا در انبار تدبیر </th>";

      $table=$table."</tr>";
    $i=1;
    foreach ($AllProducts AS $allp )
    {
        switch ($allp->type_cat)
        {
            case 1: $type_cat= 'قطعه';break;
            case 2: $type_cat='قطعه منفصله';break;
            case 3: $type_cat= 'شاسی';break;
        }
        //------------------
        if ($allp->Tadbir !=null)
            $Tadbir=$allp->Tadbir;
        else
            $Tadbir="..................";
        //------------------
        $table=$table."<tr>";
            $table=$table."<td>".$i++."</td>";
            $table=$table."<td>".$allp->PartNumber."</td>";
            $table=$table."<td>".$type_cat."</td>";
            $table=$table."<td>".$allp->Brand."</td>";
            $table=$table."<td>".$allp->Type."</td>";
            $table=$table."<td>".$allp->Title."</td>";
            $table=$table."<td>".$allp->epl."</td>";
            $table=$table."<td>".$Tadbir."</td>";
        $table=$table."</tr>";
    }
    return  $table=$table."</table>";
  }

    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }

  public function showAll( )
  {

      if (isset($_GET["searchBox"]))
      {
          $keyword=$_GET["searchBox"];
          $AllProducts = \DB::table('stockroom_products')
              ->join('stockroom_products_brands AS brd', 'stockroom_products.stkr_prodct_brand', '=', 'brd.id')
              ->join('stockroom_products_types', 'stockroom_products.stkr_prodct_type', '=', 'stockroom_products_types.id')
              ->where('stockroom_products.deleted_flag', '=', 0)

              ->where('stockroom_products.stkr_prodct_partnumber_commercial', 'LIKE', "%$keyword%")
              ->orWhere('stockroom_products.stkr_prodct_title', 'LIKE', "%$keyword%")

              ->select('*', \DB::raw('stockroom_products.id AS productID '))
              ->orderBy('stockroom_products.id', 'desc')
          ->paginate(25);
          return view('/stockroom/view_products/allProducts', compact('AllProducts'));
      }

      else if (isset($_GET["recycle"]))
      {
          $AllProducts = \DB::table('stockroom_products')
              ->join('stockroom_products_brands AS brd', 'stockroom_products.stkr_prodct_brand', '=','brd.id')
              ->join('stockroom_products_types', 'stockroom_products.stkr_prodct_type', '=','stockroom_products_types.id')
              ->where('stockroom_products.deleted_flag', '=', 1)
              ->select('*', \DB::raw('stockroom_products.id AS productID '))
              ->orderBy('stockroom_products.id', 'desc')
              ->paginate(200000);
          return view('/stockroom/view_products/allProducts', compact('AllProducts'));
      }
      else
      {
          $AllProducts = \DB::table('stockroom_products')
              ->join('stockroom_products_brands AS brd', 'stockroom_products.stkr_prodct_brand', '=','brd.id')
              ->join('stockroom_products_types', 'stockroom_products.stkr_prodct_type', '=','stockroom_products_types.id')
              ->where('stockroom_products.deleted_flag', '=', 0)
              ->select('*', \DB::raw('stockroom_products.id AS productID '))
              ->orderBy('stockroom_products.id', 'desc')
              ->paginate(25);
              return view('/stockroom/view_products/allProducts', compact('AllProducts'));
      }




   // return $val;
  }

//-----------------------------------------------
    public function searchProduct(request $request)
    {
        return $this->showAll();
        if (isset ($request))
        {
            $data = $request->all();
            if (isset($data['searchBox']))
            {
                $keyWord = $data['searchBox'];
                if (strlen($keyWord) >= 3)
                {
                    $AllProducts = \DB::table('stockroom_products')
                        ->join('stockroom_products_brands AS brd', 'stockroom_products.stkr_prodct_brand', '=', 'brd.id')
                        ->join('stockroom_products_types', 'stockroom_products.stkr_prodct_type', '=', 'stockroom_products_types.id')
                        ->where('stockroom_products.deleted_flag', '=', 0)
                        ->where('stockroom_products.stkr_prodct_partnumber_commercial', 'LIKE', "%$keyWord%")
                        ->select('*', \DB::raw('stockroom_products.id AS productID '))
                        ->orderBy('stockroom_products.id', 'desc')
                        ->paginate(25);
                    return view('/stockroom/view_products/allProducts', compact('AllProducts'));
                }
                else
                {
                    return $this->showAll();
                }

            }
            else
            {
                 return $this->showAll();
            }
        }
        else
            return $this->showAll();




    }
//

  public function showAllTrashedProduct()
  {
    $val = \DB::table('stockroom_products')
    ->join('stockroom_products_brands', 'stockroom_products.stkr_prodct_brand', '=','stockroom_products_brands.id')
    ->join('stockroom_products_types', 'stockroom_products.stkr_prodct_type', '=','stockroom_products_types.id')
    ->where('stockroom_products.deleted_flag', '=', 1)
    //->select('*')
    ->select('*', \DB::raw('stockroom_products.id AS productID '))
    ->orderBy('stockroom_products.id', 'desc')
    //->paginate(15);
    ->get();
    return $val;
  }

  public function newOrEditProduct($getId)
  {
    if ($getId == 'new')
    {
        return view('stockroom/view_products/product', compact('getId'));
    }
    else
    {
      $product = \DB::table('stockroom_products')->where('id', '=',$getId)->get();
      return view('stockroom/view_products/product', compact('getId','product'));
    }

  }

  public function get_Product_data(Request $request)
  {//$data['productID']
      $data = $request->all();
      $id=$data['productIdSelect'];
      return  $product = \DB::table('stockroom_products')->where('id', '=', $id )->get();
  }


    public function insert_form(Request $request)
    {
        $StockroomClass=new StockroomClass ;
        return $StockroomClass->insert_form($request);
    }


//Update
public function Update_form(Request $request)
{
    $StockroomClass=new StockroomClass ;
    return $StockroomClass->Update_product_in_Edit_Dimmer($request);
}

public function moveProductToTrash(Request $request)
{
  $StockroomClass=new StockroomClass ;
  return $StockroomClass->moveProducttoTrash($request);
}
public function RestoreProductFromTrash(Request $request)
{
  $StockroomClass=new StockroomClass ;
  $StockroomClass->RestoreProductFromTrash($request);
}

public function moveSelectedProductsToTrash(Request $request)
{
  $StockroomClass=new StockroomClass ;
  $StockroomClass->move_Selected_Products_to_Trash($request);
}
public function RestoreSelectedProductsFromTrash(Request $request)
{
  $StockroomClass=new StockroomClass ;
  $StockroomClass->Restore_Selected_Products_From_Trash($request);
}

public function deleteProductFromDataBase(Request $request)
{
  $StockroomClass=new StockroomClass ;
  $StockroomClass->delete_Product_From_DataBase($request);
}
public function DeleteSelectedProductsFromDatabase(Request $request)
{
  $StockroomClass=new StockroomClass ;
  $StockroomClass->Delete_Selected_Products_From_Database($request);
}

public function get_Product_brands()
{//$data['productID']

   $product = \DB::table('stockroom_products_brands')
   ->where('stockroom_products_brands.deleted_flag', '=', 0)
   ->orderBy('stockroom_products_brands.id', 'desc')
   ->get();
   return $product;
}
public function get_Product_Types()
{
  return  $product = \DB::table('stockroom_products_types')
  ->where('stockroom_products_types.deleted_flag', '=', 0)
  ->orderBy('stockroom_products_types.id', 'desc')
  ->get();
}
public function get_Product_Types_Join_Brands()
{
      $val = \DB::table('stockroom_products_types')
      ->join('stockroom_products_brands', 'stockroom_products_types.stkr_prodct_type_In_brands', '=','stockroom_products_brands.id')

      ->where('stockroom_products_types.deleted_flag', '=',0)
      //->select('*')
      //->select('*', \DB::raw('stockroom_products.id AS productID '))
      ->orderBy('stockroom_products_types.id', 'desc')
      //->paginate(15);
      ->get();
      return $val;
}


      //return   $validatedData['message'];
}
