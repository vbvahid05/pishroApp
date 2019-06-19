<?php
use App\Custommerorganization;
use App\stockroom_order;
//use Illuminate\Auth\Access\Gate;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Gate;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//Route::get('stock/allproducts', ['middleware' => 'plgLicns:products', function () {
//}]);


Route::get('/gateCheck',function () {
    if (Gate::allows('customer_create', 1))
       {
           echo 'Welcome';
       }
     else echo 'Access Denied';
});


Route::get('/orderss', function () {
  $ordersx=stockroom_order::all();
  //return View::make('stockroom/view_Orders/all_Orders')->with('stockroom/view_Orders/all_Orders',$ordersx);
return View::make('stockroom/view_Orders/all_Orders', compact('ordersx'));

});

//Route::get('/','DashboardController@home');
Route::get('/lab', function () {return view('lab');});
Route::post('upload', 'LabController@upload');
Route::post('/upload/file', 'LabController@angular_upload');

/* +++++++++++  USER ++++++++++++++++ */
Route::get('/editUser', function () {return view('user/edit-user');});
Route::post('/user/setting/{function}' ,'PublicController@userSettings');

/* +++++++++++ PUBLIC MENU ++++++++++++++++ */
//Route::get('/', function () {return view('welcome');});
Route::get('/','DashboardController@showDashboard');
Route::get('/about-us', function () {return view('about-us');});

/*+++++++++++++ PUBLIC Controller  ++++++*/
Route::post('/Publicservices/datalist'     ,'PublicController@getAllData');
Route::post('/Publicservices/GetCount'     ,'PublicController@Get_Count_Of_Rows');

Route::post('/Publicservices/relatedDatalist'     ,'PublicController@getAllData_select_one_fiald');
Route::post('/Publicservices/relatedDatalist2Fld'     ,'PublicController@getAllData_select_two_fialds');
Route::post('/Publicservices/relatedDatalist3Fld'     ,'PublicController@getAllData_select_three_fialds');
Route::post('/Publicservices/moveToTrash'     ,'PublicController@moveToTrash');
Route::post('/Publicservices/RestoreFromTrash','PublicController@RestoreFromTrash');
Route::post('/Publicservices/DeleteFromDB'    ,'PublicController@DeleteFromDB');
Route::post('/Publicservices/moveSelectedToTrash'    ,'PublicController@moveSelectedToTrash');
Route::post('/Publicservices/RestoreGroupFromTrash'    ,'PublicController@RestoreGroupFromTrash');
Route::post('/Publicservices/FullDeleteSelectedItems'    ,'PublicController@FullDeleteSelectedItems');
Route::post('/Publicservices/ShowCalender'    ,'PublicController@ShowCalender');
Route::post('/Publicservices/UpdateSingleRecord'    ,'PublicController@UpdateOneRecord');
Route::post('/Publicservices/UpdateSingleRecordByAnyRow'    ,'PublicController@UpdateOneRecordByanyRowId');







/* +++++++++++ DASHBOARD ++++++++++++++++ */
Route::get('/dashboard','DashboardController@showDashboard');
Route::get('/showchart','DashboardController@showChart');


/* +++++++++++ CUSTOMMER ++++++++++++++++ */
Route::get('/all-custommers','CustommerController@showallallcustommers');
Route::get('/all-orgs','CustommerController@showAllOrgsPage');
Route::get('/services/all-custommersNullORG','CustommerController@show_all_custommers_NullORG');

Route::get('/services/all-custommers','CustommerController@showAll');
Route::get('/services/all-Trashed-custommers','CustommerController@showAllTrashed');
Route::post('/services/all-ORG-data','CustommerController@ShowAllOrgData');

Route::get('/custommer','CustommerController@newcustommer');

\Illuminate\Support\Facades\Route::get ('/custommer/{id}' ,'CustommerController@editcustommer');
Route::post('/updateCustommer','CustommerController@update_form');
Route::post('/services/addNewPerson','CustommerController@addNewPerson');
Route::post('/services/Custommer_updateCustommerInfo','CustommerController@updateCustommerInfo');
//Route::post('/addNewCustommer','CustommerController@insert_form');


Route::post('/services/Trash_Restore_delete','CustommerController@moveCustommerToTrash');
Route::post('/services/Custommer_moveSelectedToTrash','CustommerController@moveSelectedCustommerToTrash');
Route::post('/services/Custommer_RestoreFromTrash','CustommerController@CustommerRestoreFromTrash');
Route::post('/services/Custommer_fullDelete','CustommerController@CustommerfullDelete');

/*++++++ Organization +++++++++*/
Route::get('/services/orgName','OrganizationController@showAllOrg');
Route::get('/services/orgPostinORG','OrganizationController@showAllPostinORG');
Route::post('/services/addOrg','OrganizationController@insert_new_Org');
Route::post('/services/UpdateOrg','OrganizationController@UpdateOrg');
Route::post('/services/trashAction','OrganizationController@trashAction');

/*
Route::get('/services/orgName', function () {
return Custommerorganization::all();
}); */
//Route::post('/services/addOrg',function(){  return App\Custommerorganization::create(\Illuminate\Support\Facades\Input::all()); });



//Stockroom Products ...
Route::get('/showProducts','Stockroom\ProductsController@showProducts');
Route::get('/ProductsStatus','Stockroom\ProductsController@ExportProductsStatus');
//Route::get('stock/allproducts', function () {return view('stockroom/view_products/allProducts');});
Route::get('stock/allproducts/{keyword?}', 'Stockroom\ProductsController@showAll');
//\Illuminate\Support\Facades\Route::get ('stock/allproducts/{keyword?}' ,'Stockroom\ProductsController@showAll');
Route::post('/service/stock/searchProduct','Stockroom\ProductsController@searchProduct');


    Route::get('/services/all-products','Stockroom\ProductsController@showAll');
    Route::get('/services/stock/all-trashed-products','Stockroom\ProductsController@showAllTrashedProduct');
    \Illuminate\Support\Facades\Route::get ('stock/product/{id}' ,'Stockroom\ProductsController@newOrEditProduct');
    Route::post('/service/stock/getProductData','Stockroom\ProductsController@get_Product_data');
    Route::get('/service/stock/getProductBrands','Stockroom\ProductsController@get_Product_brands');
    Route::get('/service/stock/getProductTypes','Stockroom\ProductsController@get_Product_Types');
    \Illuminate\Support\Facades\Route::get('/service/stock/getProductTypesByBrandID/{id}','Stockroom\ProductTypeController@get_Product_Types_ByBrandID');
    Route::post('/service/stock/add_new_product','Stockroom\ProductsController@insert_form');
    Route::post('/service/stock/editUpdate_product','Stockroom\ProductsController@Update_form');
    Route::post('/services/stock/moveToTrash','Stockroom\ProductsController@moveProductToTrash');
    Route::post('/services/stock/RestoreFromTrash','Stockroom\ProductsController@RestoreProductFromTrash');
    Route::post('/services/stock/moveSelectedGroupToTrash','Stockroom\ProductsController@moveSelectedProductsToTrash');
    Route::post('/services/stock/RestoreGroupFromTrash','Stockroom\ProductsController@RestoreSelectedProductsFromTrash');
    Route::post('/services/stock/DeleteProductFromDataBase','Stockroom\ProductsController@deleteProductFromDataBase');
    Route::post('/services/stock/DeleteSelectedGroupFromDatabase','Stockroom\ProductsController@DeleteSelectedProductsFromDatabase');
    /*Brands*/
    Route::post('/services/stock/addNewBrand2DB','Stockroom\ProductBrandsController@addNewBrand');
    /*Types*/
    Route::post('/services/stock/addNewType2DB','Stockroom\ProductTypeController@addNewType');
    Route::get('/service/stock/getProductTypesJoinBrand','Stockroom\ProductsController@get_Product_Types_Join_Brands');



    //ORDERS......
    /*all Orders*/
Route::get('stock/AllOrders', function () {return view('stockroom/view_Orders/all_Orders');});
    \Illuminate\Support\Facades\Route::get('/services/stock/all-orders/{mode}','Stockroom\OrdersController@showAllOrders');
    Route::post('/service/stock/getOrderData','Stockroom\OrdersController@getOrderData');
    Route::post('/service/stock/getOrderData_partsInChassis','Stockroom\OrdersController@getOrderData_partsInChassis');

    Route::post('/service/stock/Order/updateOrder','Stockroom\OrdersController@updateOrder');
    Route::post('/service/stock/Order/get_Just_OrderData','Stockroom\OrdersController@getJustOrderData');
    Route::get( '/services/stock/Order/generateNewOrderCode','Stockroom\OrdersController@generateNewOrderCode');
    Route::post('/services/stock/Order/Insert_ProductOrders_To_DB','Stockroom\OrdersController@Insert_ProductOrders_To_DB');
    Route::post('/services/stock/Order/Update_ProductOrders_DB','Stockroom\OrdersController@Update_ProductOrders_DB');
    Route::post('/services/stock/Order/DeleteOrder_From_list','Stockroom\OrdersController@Delete_order_From_list');
    Route::post('/services/stock/Order/Order_checkSingleItemToDelete','Stockroom\OrdersController@Order_check_SingleItemToDelete');
    Route::post('/services/stock/Order/getRelatedProducts_ByType','Stockroom\OrdersController@getRelatedProducts_ByType');

//    Route::post('/services_stock/{controller}/{function}','Stockroom\OrdersController@ManageStockRoutes');
//    Route::post('/services_stock/orders/updateStackrequest_info','Stockroom\OrdersController@ManageStockRoutes');
    Route::post('/services_stock/{controller}/{function}','Stockroom\OrdersController@ManageStockRoutes');

    Route::post('/services/stock/addNewOrder','Stockroom\OrdersController@addNewOrder');

//    Route::post('/service/stock/Order/{function}','Stockroom\OrdersController@manageRequestxx');




    /*all Sellers*/
    Route::get('/services/stock/all-sellers','Stockroom\OrdersController@showAllSellers');
    /*all Status*/
    Route::get('/services/stock/all-Status','Stockroom\OrdersController@showAllStatus');
    Route::get('/services/stock/partNumberList','Stockroom\OrdersController@GetpartNumberList');


/*Putting  products*/
Route::get('stock/PuttingProducts', function () {return view('stockroom/view_puttingProducts_ToStock/all_records');});
  Route::post('/services/stock/getProductTitleBrandType','Stockroom\PuttingProductController@getProductTitleBrandType');
  Route::post('/services/stock/getAllOrderList','Stockroom\PuttingProductController@getAllOrderList');
  Route::post('/services/stock/PuttingToStock','Stockroom\PuttingProductController@PuttingToStock');
  Route::post('/services/stock/Order/add_ChassesPart_to_DB','Stockroom\PuttingProductController@add_ChassesPart_to_DB');
  Route::post('/services/stock/Get_subChassisParts','Stockroom\PuttingProductController@Get_subChassis_Parts');
  Route::post('/services/stock/saveSerialNumbers','Stockroom\PuttingProductController@saveSerialNumbers');
  Route::post('/services/stock/editSerialNumbers','Stockroom\PuttingProductController@editSerialNumber');
  Route::post('/services/stock/test','Stockroom\PuttingProductController@test');
  Route::post('/services/stock/SaveSubSerialFields','Stockroom\PuttingProductController@SaveSubSerialFields');
  Route::post('/services/stock/get_SubSerialNumbers','Stockroom\PuttingProductController@getSubSerialNumbers');
  Route::post('/services/stock/delete_Serial_Number','Stockroom\PuttingProductController@delete_Serial_Number');
  Route::post('/services/stock/RemoveSubChassisSerial','Stockroom\PuttingProductController@RemoveSubChassisSerial');

  Route::get('/convert','Stockroom\PuttingProductController@convert');
  \Illuminate\Support\Facades\Route::get('/services/stock/all-Putting-Products/{mode}','Stockroom\PuttingProductController@showAllRecords');
  \Illuminate\Support\Facades\Route::get('/services/stock/show_Record_by_id/{id}','Stockroom\PuttingProductController@show_Record_by_id');

Route::get('puttingProducts/reports/{id}','Stockroom\PuttingProductController@reports');
Route::post('/services/stock/countOfSubChassis','Stockroom\PuttingProductController@countOf_SubChassis');

/* Sell ----------*/
Route::get('sell/ProductStatusReport', function () {return view('sell/view_report/allRecord');});
  //---------Get Report

  //Route::get('/services/sell/getAllStatusReport','Sell\SellController@AllStatusReport');
  Route::post('/services/sell/getAllStatusReport','Sell\SellController@AllStatusReport');
  Route::post('/services/sell/getBrandSTypeSTitles','Sell\SellController@get_BrandSTypeSTitles');


  //--------- stockRequest
Route::get('sell/stockRequest', function () {return view('sell/view_stockRequest/allRecord');});
  Route::post('/services/sell/GetAllstockRequest','sell\SellController@Get_AllstockRequest');
  Route::post('/services/sell/addStockRequestToDB','sell\SellController@add_StockRequest_To_DB');
  Route::post('/services/sell/ListOfPartNumbers','sell\SellController@List_Of_PartNumbers');
  Route::post('/services/sell/countofavailableProduct','sell\SellController@count_of_availableProduct');
  Route::post('/services/sell/insert_Edit_StockRequest_details_DB','sell\SellController@insertOrEdit_StockRequest_details_DB');
  Route::post('/services/sell/getStockRequestData_by_id','sell\SellController@get_StockRequestData_by_id');
  \Illuminate\Support\Facades\Route::get ('/sell/stockRequest/print/{id}' ,'sell\SellController@printStockRequest');
  \Illuminate\Support\Facades\Route::get ('/sell/stockRequest/pdf/{id}/{outPut}'   ,'sell\SellController@pdfStockRequest');
  Route::post('/services/sell/getList_AllCustommers','sell\SellController@getList_AllCustommers');
  Route::post('/services/sell/UpdateProductQTY','sell\SellController@Update_ProductQTY');
  Route::post('/services/sell/countOftakeoutproducts','sell\SellController@count_Of_takeoutproducts');



  Route::post('/services/sell/Delete_StockRequest_From_BaseList','sell\SellController@Delete_StockRequest_From_BaseList');
  Route::post('/services/sell/getProductName','sell\SellController@Delete_StockRequest_From_BaseList');
  Route::post('/services/SellController/getProductName','sell\SellController@getProductName');
  Route::get('/sell/stockRequest/reports/{id}','sell\SellController@reports');
//New Stock Request Routs
  Route::post('/services_sell/{controller}/{function}/{value?}','sell\SellController@manageRequest');
  Route::get('/showsn','sell\SellController@showsn');
  Route::get('/showInOut','sell\SellController@showInOut');

//Warranty
    Route::get('sell/stockRequest/{controller}/{function}/{value?}','sell\SellController@manageRequest');
    Route::post('sell/stockRequest/service/{controller}/{function}/{value?}','sell\SellController@manageRequest');



//    Route::get('services/{controller?}/{action?}', function ($controller = null ,$action = null) {
//        return '/services/'.$controller.'/'.$action;
//
//    });



/*Take Out Products */
Route::get('sell/TakeOutProducts', function () {return view('sell/view_TakeOutProducts/allRecord');});
  Route::post('/services/sell/takeOutSerials','Sell\SellController@takeOutSerials');
  Route::post('/services/sell/checkserial','Sell\SellController@checkserial');
//  Route::post('/services/sell/getSerils','Sell\SellController@getSerils');


  /*Invoice*/
    Route::get('sell/invoice', function () {return view('sell/view_invoice/allRecord');});
    Route::post('/services/sell/{function}/{value?}'         ,'Sell\SellController@Invoice');
    \Illuminate\Support\Facades\Route::get ('sell/invoice/print/{id}' ,'Sell\SellController@InvoicePrint');
    \Illuminate\Support\Facades\Route::get ('sell/invoice/pdf/{id}' ,'Sell\SellController@InvoiceToPDF');

    Route::get('sell/warranty/pdf/{id}', 'Sell\SellController@getWarrantyPdf');
    //Route::get('sell/warranty/pdf/{id}', function () {var_dump('test') ; });
/*Setting*/
Route::get('setting/users', function () {return view('setting/users/ManageRoles');});
Route::post('setting/{controller}/{function}/{value?}','setting\SettingController@manageRequest');
Route::get('setting/user/changePassword','setting\SettingController@changePassword');

Route::get('/test' ,'setting\SettingController@dotest');

//Route::get('/movepartnumbers' ,'LabController@movePartNumbers');

/*Posts*/
Route::get('/all-posts/{lang}/{postType}'         ,'CMS\Posts\PostController@showAllPosts');
Route::get('/all-posts/{lang}/{postType}/{action}','CMS\Posts\PostController@editPage');
Route::post('/all-posts/postActions/{postType}/{action}','CMS\Posts\PostController@CRUD');

/*Media Center*/
Route::post('/mediaLibrary/Actions/{Type}','CMS\MediaCenter\MediaCenterController@manageRequest');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
