<?php

namespace App\Http\Controllers\Sell;
//>>>>>>>>>>>> Model

use App\Mylibrary\Sell\TakeOutProducts\TakeOutProducts;
use App\Mylibrary\Sell\warranty\Warranty;
use App\sell_stockrequests_detail;
use App\sell_takeoutproduct ;
use App\Stockroom_stock_putting_product;
use App\stockroom_order;
use App\stockroom_serialnumber;
use App\stockroom_product_statu;
use App\Stockroom_products_brands;
use App\stockroom_products_types;
use App\Stockroom_products;
use App\sell_stockrequest;
//>>>>>>>>>>>> Model
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//>>>>>>>>>>>>Library
use App\Mylibrary\PublicClass;
use App\Mylibrary\Sell\StatusReport\All_Status_Repost;
use App\Mylibrary\Sell\Stock_Request\ListPage;
Use App\Mylibrary\Sell\Stock_Request\New_Edit_stockRequest;
Use App\Mylibrary\Sell\Invoice\Invoice;
Use App\Mylibrary\Sell\Stock_Request\makePdf;

//use Meneses\LaravelMpdf\LaravelMpdfWrapper;

use mPDF;
use PhpParser\Node\Expr\Array_;

class SellController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }
  //Report Page
  public function AllStatusReport(request $request)
    {
        $status=new All_Status_Repost();
        return $status->get_reports($request);
    }
//--------------
    public function get_BrandSTypeSTitles(request $request)
    {

            $data = $request->all();
            if ($data['qmode']=="GetBrands")
            {
                $brands=new All_Status_Repost();
                return $brands->get_brands($request);
            }
            else if ($data['qmode']=="GetTyps")
            {
                $types =new All_Status_Repost();
                return $types->get_types($data['brandName']);
            }
    }

//Invoice

public function Invoice(request $request ,$function)
{
    $argdata = $request->all();
    $Action=$argdata['Action'];

    switch ($Action)
    {
        case 'All_invoice':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Get_all_records($request);
        break;

        case 'All_curency':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Get_all_curency();
        break;

        case 'All_Custommer':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Get_all_Custommers();
        break;

        case 'All_PartNumbers':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->All_PartNumbers($request);
        break;

        case 'All_Brands':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->All_Brands($request);
        break;

        case 'All_Product_Types':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->All_Product_Types($request);
        break;

        case 'All_Related_Products':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->All_Related_Products($request);
        break;

        case 'InvoiceAliasID':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Generate_Invoice_id();
        break;

        case 'select_product_by_partNum':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->select_product_by_partNum($request);
            break;

        case 'SaveInvoice_Base':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->SaveInvoice_Base($request);
        break;

        case 'Edit_Invoice':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Edit_Invoice($request);
        break;

        case 'save_invoice_Desc':

            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->save_invoice_Desc($request);
            break;

        case 'Confirm_Invoice':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Confirm_Invoice($request);
            break;

        case 'add_product_to_invoice_DB':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->add_product_to_invoice_DB($request);
        break;

        case 'Get_Selected_invoice_Data':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Get_Selected_invoice_Data($request);
        break;

        case 'delete_selected_invoice':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->delete_selected_invoice($request);
        break;

        case 'Update_invoice_qrt':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Update_invoice_qrt($request);
            break;

        case 'Update_invoice_price':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Update_invoice_price($request);
            break;

        case 'update_invoice_description':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->update_invoice_description($request);
            break;

        case 'delete_item_From_Invoice_List':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->delete_item_From_Invoice_List($request);
            break;

        case 'Copy_Invoice':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->Copy_Invoice($request);
            break;

        case 'edit_invoice_Base_data':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->edit_invoice_Base_data($request);
            break;

        case 'delete_restore_Invoice':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->delete_restore_Invoice($request);
            break;

        case 'add_subProduct_in_Invoice':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->add_subProduct_in_Invoice($request);
            break;

        case 'get_subProduct_list_invoice':

            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->get_subProduct_list_invoice($request);
            break;

        case 'delete_subProduct_from_list_invoice':

            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->delete_subProduct_from_list_invoice($request);
            break;

        case 'setTaxStatus':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->setTaxStatus($request);
        break;

        case 'setPDFStingAction':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->setPDFStingAction($request);
            break;

        case 'getPDFStings':
            $allInvoiceDate= new Invoice();
            return $allInvoiceDate->getPDFStings($request);
            break;

       case 'update_NewSubProduct_Qty':
               $allInvoiceDate= new Invoice();
               return $allInvoiceDate->updateNewSubProduct_Qty($request);
            break;

        case 'SearchInvoice':
            $SearchInvoice= new Invoice();
            return $SearchInvoice->SearchInvoice($request);
            break;
    }

}

    public function InvoicePrint($id)
    {
        $request = new \Illuminate\Http\Request();
        $request->replace(['invoicesID' => $id]);
        $invoice=new Invoice();
        $result=$invoice->Get_Selected_invoice_Data($request);
        return view('sell/view_invoice/invoice_parts/section_printPage',compact( 'result'));
    }

    public function InvoiceToPDF($id)
    {
        $request = new \Illuminate\Http\Request();
        $request->replace(['invoicesID' => $id]);
        $invoice=new Invoice();
        $result=$invoice->Get_Selected_invoice_Data($request);

        $pdf=new Invoice();
        return $pdf->getPdf($result);

    }

//---- New Route
    public function manageRequest(request $request, $controller,$function,$value=null)
    {
        switch ($controller)
        {
            case 'warranty' :
                switch ($function)
                {
                    case 'addRequest':
                        $pageType='addRequest';
                        return view('sell/view_warranty/allRecord',compact('pageType'));
                    break;

                    case 'stockOut':
                        $pageType='stockOut';
                        return view('sell/view_warranty/allRecord',compact('pageType'));
                    break;

                    case 'getWarrantyList':
                          $data= new Warranty();
                          return $data->getWarrantyList($request);
                    break;

                    case 'GetSerialNumbers':
                          $data= new Warranty();
                          return $data->GetSerialNumbers();
                    break;
                    case 'getInfoAroundSerialNumber':
                        $data= new Warranty();
                        return $data->getInfoAroundSerialNumber($request);
                        break;
                    case 'SaveWarrantyForm':
                        $data= new Warranty();
                        return $data->SaveWarrantyForm($request,$value);
                    break;

                    case 'UpdateWarrantyForm':
                        $data= new Warranty();
                        return $data->UpdateWarrantyForm($request,$value);
                        break;

                    case 'getSavedWarrantyDataByID':
                        $data= new Warranty();
                        return $data->getSavedWarrantyDataByID($request);
                        break;

                    case 'addAlternativeSerial':
                        $data= new Warranty();
                        return $data->addAlternativeSerial($request);
                        break;

                    case 'RemoveSerialFromList':
                        $data= new Warranty();
                        return $data->RemoveSerialFromList($request);
                        break;

                    case 'delete_alternative_serial':
                        $data= new Warranty();
                        return $data->delete_alternative_serial($request);
                        break;

                    case 'backToWarrantyRequest':
                        $data= new Warranty();
                        return $data->backToWarrantyRequest($request);
                        break;

                    case 'changeWarrantyDeleteFlag':
                        $data= new Warranty();
                        return $data->changeWarrantyDeleteFlag($request);
                    break;

                    case 'WarrantyFullDelete':
                        $data= new Warranty();
                        return $data->WarrantyFullDelete($request);
                        break;

                }
            break ;

            case 'Stockrequest' :
                switch ($function)
                {
                    case 'addProductToStockRequest':
                        $data= new New_Edit_stockRequest();
                        return $data->addProductToStockRequest($request);
                        break;
                    case 'GetSubChassisParts' :
                        $data= new New_Edit_stockRequest();
                        return $data->Get_SubChassisParts($request);
                    break;

                    case 'AddSubChassisPartsToDB' :
                        $data= new New_Edit_stockRequest();
                        return $data->AddSubChassisPartsToDB($request);
                        break;

                    case 'get_saved_SubchassisParts' :
                      $data= new New_Edit_stockRequest();
                      return $data->get_saved_SubchassisParts($request);
                    break;

                    case 'Delete_product_of_Request' :
                      $data= new New_Edit_stockRequest();
                      return $data->DeleteProduct_From_StackRequest($request);
                    break;

                    case 'delete_SubChassis_Item' :
                        $data= new New_Edit_stockRequest();
                        return $data->delete_SubChassis_Item($request);
                     break;

                    case 'showConvertStockRequest' :
                        $data= new New_Edit_stockRequest();
                        return $data->showConvertStockRequest($request);
                     break;


                    case 'convertStockRequest' :
                        $data= new New_Edit_stockRequest();
                        return $data->convertStockRequest($request);
                        break;

                    case 'editStackrequest_info' :
                        $data= new New_Edit_stockRequest();
                        return $data->editStackrequest_info($request);
                        break;

                    case 'pdfSetting' :
                        $data= new New_Edit_stockRequest();
                        return $data->pdfSetting($request,$value);
                        break;
                    case 'getPdfSettingValue' :
                        $data= new New_Edit_stockRequest();
                        return $data->getPdfSettingValue($request);
                        break;

                    case 'UpdateWarrantyDiuration' :
                        $data= new New_Edit_stockRequest();
                        return $data->UpdateWarrantyDiuration($request);
                        break;


                }
            break;
            case 'TakeOutProducts':
                switch ($function)
                {
                    case 'GetSubChassisParts':
                        $data=new TakeOutProducts();
                        return $data->GetSubChassisParts($request);
                    break;
                    case 'getSerils':
                            $data=new TakeOutProducts();
                            return $data->getSerils($request);
                            //return $this->getSerils($request);
                    break;

                    case 'Get_SerialToSubChassis':
                       $data=new TakeOutProducts();
                       return $data->GetSerialToSubChassis($request);
                    break;

                    case 'TakeASerial':
                       $data=new TakeOutProducts();
                       return $data->TakeASerial($request);
                    break;

                    case 'deleteSubChassisSerial':
                        $data=new TakeOutProducts();
                        return $data->deleteSubChassisSerial($request);
                        break;



                }
            break;
        }
      //  return $req=$controller.$function;
    }

    public function getWarrantyPdf ($id)
    {
        $data= new Warranty();
        return $data->getWarrantyPdf($id);
    }

    public function showsn()
    {
        $data=new TakeOutProducts();
        return $data->showAllSerialNumbers();
    }

    public function showInOut()
    {
        $data=new TakeOutProducts();
        return $data->INandOutReport();
    }


//%%%%%%%%%%%% All Stock Request Page %%%%%%%%%%%%%%%%%%%%%%%
  public function Get_AllstockRequest(request $request)
    {
        $list=new ListPage();
        return $list->Get_ListPage($request);
    }
//%%%%%%%%%%%% Stock Request SUB Page ( New | Edit ) %%%%%%%%

  public function getList_AllCustommers(request $request)
{
    $custommerList=new New_Edit_stockRequest();
    return $custommerList->Get_Custommer_list($request);
}
//---------------------------
  public function add_StockRequest_To_DB(request $request)
  {
        $NewStockRequest=new New_Edit_stockRequest();
        return $NewStockRequest->Add_to_DB($request);
  }
//-------------
public  function get_SubChassisParts (request $request)
{
        $SubChassis_parts =new New_Edit_stockRequest() ;
        return $SubChassis_parts->Get_SubChassisParts($request);
}
//-------------
  public function  insertOrEdit_StockRequest_details_DB(request $request)
    {
        $argdata = $request->all();
        $formType=$argdata['formType']; // ghaTii = 0  ya TaaHoDI = 1
        $data=$argdata['dataArray'];
        if ($argdata['type']=='inserNew')
        {
           $insertToDB =new New_Edit_stockRequest();
           return $insertToDB->insert_StockRequest_details_to_DB($formType,$data);
        }
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        else if ($argdata['type']=='editRow')
        {
            $insertToDB =new New_Edit_stockRequest();
            return $insertToDB->Update_Stockrequest_details_to_DB($formType,$data);
        }
    }
//-------------
  public function Update_ProductQTY  (request $request)
  {
      $argdata = $request->all();
      $type=$argdata['type'];
      $stockrequerst_id=$argdata['stockrequerst_id'];
      $product_id=$argdata['product_id'];
      $newQty=$argdata['qty'];
      $oldQty=$argdata['oldQty'];

    if ($type==1)  //Ta'ahodi
    {
        //Update QTY  OLdQTY+newQTY | in -> stockrequests details Table
        $updateStep1 = \DB::table('sell_stockrequests_details')
            ->where('ssr_d_stockrequerst_id', $stockrequerst_id)
            ->where('ssr_d_product_id', $product_id)
            ->update(['ssr_d_qty' => $newQty]);

        //update   OLdQTY+newQTY | in ->product_status -> sps_Taahodi
        $QTYinDB = \DB::table('stockroom_product_status AS product_status')
            ->where('product_status.sps_product_id', '=', $product_id)
            ->select(\DB::raw('product_status.sps_Taahodi AS  QTY_Taahodi '))
            ->get();
        $oldQTY_Taahodi = $QTYinDB[0]->QTY_Taahodi;
        $newQTY = $oldQTY_Taahodi + $newQty;
        $updateStep2 = \DB::table('stockroom_product_status')
            ->where('sps_product_id', $product_id)
            ->update(['sps_Taahodi' => $newQty]);
        if ($updateStep1 && $updateStep2)
            return 1;
    }
    else if ($type==0) //Ghatii
    {
        $QTYinDB = \DB::table('stockroom_product_status AS product_status')
            ->where('product_status.sps_product_id', '=', $product_id)
            ->select(\DB::raw('product_status.sps_available AS  QTY_available ,
                               product_status.sps_reserved AS  QTY_reserved'))
            ->get();
        $addedQty =$newQty-$oldQty;
        $oldQTY_available = $QTYinDB[0]->QTY_available;
        $oldQTY_reserved = $QTYinDB[0]->QTY_reserved;

        if ($oldQTY_available >= $addedQty)
        {
            //Update QTY  OLdQTY+newQTY | in -> stockrequests details Table
            $updateStep1 = \DB::table('sell_stockrequests_details')
                ->where('ssr_d_stockrequerst_id', $stockrequerst_id)
                ->where('ssr_d_product_id', $product_id)
                ->update(['ssr_d_qty' => $newQty]);

            $val = stockroom_product_statu::where('sps_product_id',$product_id)->first();
            $val->sps_available= $oldQTY_available-$addedQty;
            $val->sps_reserved= $oldQTY_reserved+$addedQty;
            if ($updateStep1) $val->save();
            return 1;
        }
        else return 0;


    }

  }
 //------------
    public function Delete_StockRequest_From_BaseList (request $request)
    {
        $DeleteStockRequestBASE =new New_Edit_stockRequest();
        return $DeleteStockRequestBASE->DeleteStockRequest_From_BaseList($request);
    }
//-------------
//  public function DeleteProduct_of_Request (request $request)
//  {
//     try
//     {
//      $insertToDB =new New_Edit_stockRequest();
//      return $insertToDB->DeleteProduct_From_StackRequest($request);
//     }
//     catch (\Exception $e)
//     {
//         return $e->getMessage();
//     }
//  }

  //%%%%%%%%%%%%  SUBPAGE DATA SERVICES
  public function count_Of_takeoutproducts(request $request )
  {
      $argdata = $request->all();
      $stockrequest_id=$argdata['stockrequest_id'];
      $productid=$argdata['productid'];
      return  \DB::table('sell_takeoutproducts AS takeoutproducts')
          ->where('takeoutproducts.sl_top_stockrequest_id', '=', $stockrequest_id)
          ->where('takeoutproducts.sl_top_productid', '=', $productid)
          ->count();
  }
  public function List_Of_PartNumbers   (request $request)
  {
      try {
          $val = \DB::table('stockroom_stock_putting_products AS stock')
              ->join('stockroom_products AS products', 'products.id', '=', 'stock.stkr_stk_putng_prdct_product_id')
              ->join('stockroom_products_brands AS brands', 'brands.id', '=', 'products.stkr_prodct_brand')
              ->join('stockroom_products_types  AS types', 'types.id', '=', 'products.stkr_prodct_type')
//              ->join('stockroom_serialnumbers AS serialnumbers', 'serialnumbers.stkr_srial_putting_product_id', '=', 'stock.id')
//              serialnumbers.stkr_srial_putting_product_id AS puttingID,
              ->select(\DB::raw('
                            products.id AS productID,
                            stock.id  AS    puttingID,                       
                            products.stkr_prodct_partnumber_commercial AS commercialPartnumber ,
                            products.stkr_prodct_title AS productTitle,
                            products.stkr_prodct_type_cat AS typeCat ,
                            brands.stkr_prodct_brand_title AS productBrand,
                            types.stkr_prodct_type_title  AS productType


                                '))
//              ->where('serialnumbers.stkr_srial_status', '=', 0)
//              ->where('serialnumbers.deleted_flag', '=', 0)
              ->orderBy('productID', 'asc')
              ->get();

          //****************
          $Arry_PuttingIDs = array();
          $last_productID = $val[0]->productID;
          $retArray = array("productID" => $val[0]->productID,
              "puttingID" => $val[0]->puttingID,
              "Partnumber" => $val[0]->commercialPartnumber,
              "productTitle" => $val[0]->productTitle,
              "productBrand" => $val[0]->productBrand,
              "productType" => $val[0]->productType,
              "typeCat" => $val[0]->typeCat
          );
          array_push($Arry_PuttingIDs, $retArray);
          foreach ($val as $v) {
              if ($v->productID != $last_productID)  // Delete Duplicated Records
                  //  if ($v->puttingID !=$last_puttingID)  // Delete Duplicated Records
              {
                  $retArray = array("productID" => $v->productID,
                      "puttingID" => $v->puttingID,
                      "Partnumber" => $v->commercialPartnumber,
                      "productTitle" => $v->productTitle,
                      "productBrand" => $v->productBrand,
                      "productType" => $v->productType,
                      "typeCat" => $v->typeCat

                  );
                  array_push($Arry_PuttingIDs, $retArray);
                  $last_productID = $v->productID;
              }
          }
          return $Arry_PuttingIDs; // List of Putting IDs
          //**********************
      }
      catch (\Exception $e)
      {
          return $e->getMessage();

      }
  }


  public function count_of_availableProduct(request $request)
  {
   try
   {
    $data = $request->all();
    $product_ID=$data['product_ID'];
    if ($product_ID=='all')
    {

    }
    else
    {
        $val = \DB::table('stockroom_product_status AS product_status')
                   ->where('product_status.sps_product_id', '=', $product_ID)
                   ->select( \DB::raw('
                              product_status.sps_available AS  total_qty
                                  '))
                    ->get();
                    return $val[0]->total_qty;
      /*
      $val = \DB::table('stockroom_stock_putting_products AS stock')
                  ->join('stockroom_products AS products'   ,   'products.id', '=','stock.stkr_stk_putng_prdct_product_id')
                  ->join('stockroom_products_brands AS brands'   ,   'brands.id', '=','products.stkr_prodct_brand')
                  ->join('stockroom_products_types  AS types'   ,    'types.id', '=', 'products.stkr_prodct_type')
                  ->join('stockroom_serialnumbers AS serialnumbers'   ,  'serialnumbers.stkr_srial_putting_product_id', '=','stock.id')
                  ->select( \DB::raw('
                             products.id AS productID,
                             serialnumbers.stkr_srial_putting_product_id AS puttingID,
                             products.stkr_prodct_partnumber_commercial AS commercialPartnumber ,
                             products.stkr_prodct_title AS productTitle,
                             brands.stkr_prodct_brand_title AS productBrand,
                             types.stkr_prodct_type_title  AS productType


                                 '))
                   ->where('products.id', '=', $product_ID)
                   ->where('serialnumbers.stkr_srial_status', '=', 0)
                   ->where('serialnumbers.deleted_flag', '=', 0)

                   ->orderBy('productID', 'asc')
                   ->count();
                    return $val;


                   $val = \DB::table('sell_stockrequests_details AS stockrequests_details')
                              ->where('stockrequests_details.ssr_d_product_id', '=', $product_ID)
                              ->where('stockrequests_details.ssr_d_status', '=', 0)
                              ->where('stockrequests_details.deleted_flag', '=', 0)
                              //->selectRaw('sum(ssr_d_qty)')
                               ->select( \DB::raw('SUM(ssr_d_qty) as total_qty'))

                                ->get();
                              //  return $val;

*/
    }
   }
   catch (\Exception $e)
   {
       return $e->getCode()."||".$e->getMessage();
   }

  }
//--------------------
  public function  get_StockRequestData_by_id(request $request)
{
  $data = $request->all();
  $qmode=$data['qmode'];
  $StockRequestID=$data['StockRequestID'];
    if ($qmode==0) // get StockRequest Data by id
      {
      $val = \DB::table('sell_stockrequests AS stockrequests')
      ->join('custommers AS custmer'   ,   'custmer.id', '=','stockrequests.sel_sr_custommer_id')
       ->select( \DB::raw('
                 stockrequests.sel_sr_pre_contract_number AS contract_number,
                 stockrequests.sel_sr_delivery_date AS  delivery_date,
                 stockrequests.sel_sr_warranty_priod AS  warranty_date,
                 stockrequests.sel_sr_registration_date AS  registration_date,                 
                 stockrequests.sel_sr_type AS stockRequestsType,
                 custmer.cstmr_name AS cstmrName,
                 custmer.cstmr_family AS cstmrFamily,
                 custmer.cstmr_organization AS cstmrOrganization,
                 custmer.id AS cstmr_id,                 
                 custmer.cstmr_post AS cstmrPost
                     '))
        ->where('stockrequests.id', '=', $StockRequestID)
        ->where('stockrequests.deleted_flag', '=', 0)
        ->get();


          $warranty_date = date('Y-m-d', strtotime("+".$val[0]->warranty_date." months", strtotime($val[0]->delivery_date)));


//          $date=date_create($val[0]->delivery_date);
//          date_add($date,date_interval_create_from_date_string(($val[0]->warranty_date*30)." days"));
//          $warranty_date=  date_format($date,"Y-m-d");


          $Vval = array(
                       "contract_number"=>$val[0]->contract_number,
                       "delivery_date"=>$val[0]->delivery_date,
                       "warranty_date"=>$warranty_date ,
                       "WarrantyPriod"=>$val[0]->warranty_date ,
                       "registration_date"=>$val[0]->registration_date,
                       "stockRequestsType"=>$val[0]->stockRequestsType ,
                       "cstmrName"=>$val[0]->cstmrName ,
                       "cstmrFamily"=>$val[0]->cstmrFamily,
                       "cstmrOrganization"=>$val[0]->cstmrOrganization,
                       "cstmr_id"=>$val[0]->cstmr_id ,
                       "cstmrPost"=>$val[0]->cstmrPost,
          );
          $ret=[];
          array_push($ret,$Vval);

        return $ret;
      }

    if ($qmode==1) // get StockRequest Data by id
      {
       $val = \DB::table('sell_stockrequests AS stockrequests')
                 ->join ('custommers AS custmer','custmer.id', '=','stockrequests.sel_sr_custommer_id')
                 ->join ('custommerorganizations AS customerOrg' , 'customerOrg.id', '=','custmer.cstmr_organization')
                 ->select(\DB::raw('
                           customerOrg.org_name AS orgName
                               '))
                  ->where('stockrequests.id', '=', $StockRequestID)
                 ->get();
                 return $val;

      }
      //------
      if ($qmode==2) // -GET stockrequests Products
        {
      return    $val = \DB::table('sell_stockrequests AS stockrequests')
                   ->join ('sell_stockrequests_details AS stockrequests_details',
                            'stockrequests_details.ssr_d_stockrequerst_id', '=','stockrequests.id')
                     ->join ('stockroom_products AS product','product.id', '=','stockrequests_details.ssr_d_product_id')
                     ->join ('stockroom_products_types AS types','types.id', '=','product.stkr_prodct_type')
                     ->join ('stockroom_products_brands AS brands','brands.id', '=','product.stkr_prodct_brand')

                     ->select( \DB::raw('
                               stockrequests_details.id AS StockRequestRowID,
                               stockrequests.id AS StockRequestID,
                               product.id AS  productID ,
                               product.stkr_prodct_partnumber_commercial AS product_partnumbers,
                               product.stkr_prodct_title AS  ProductTitle,
                               product.stkr_prodct_type_cat AS typeCat,
                               brands.stkr_prodct_brand_title AS ProductBrand,
                               types.stkr_prodct_type_title AS ProductType,
                               stockrequests_details.ssr_d_qty AS  product_QTY
                                   '))
                   /*->select(\DB::raw('
                             customerOrg.org_name AS orgName
                                 ')) */
                    ->where('stockrequests.id', '=', $StockRequestID)
                    ->where('stockrequests_details.ssr_d_ParentChasis', '=', 0)
                   ->get();
        }

  //return   $StockRequest_ID=$data['StockRequestID'];


}
// saveSerial
  public function takeOutSerials(request $request)
  {
    $data = $request->all();
    $product_id= $data['product_id'];
    $StockRequest_id =$data['StockRequest_id'];
    $serialArray=$data['SerialNumbers'];
    $StockRequestRowID = $data['StockRequestRowID'];
  $i=0;
  $Result_status=true;

//it Have two Serial Number ?
    $checking = \DB::table('stockroom_products AS products')
      ->where('products.id', '=', $product_id)
      ->select(\DB::raw('products.stkr_prodct_two_serial AS haveTwo_serial'))
      ->get();
      if ($checking[0]->haveTwo_serial)
      $have_two_serial_Number=1;
      else $have_two_serial_Number=0;
//--------------------------
  foreach ($serialArray as $sa )
    {
      //Find  serialnumber Row ID
      if ($have_two_serial_Number)
      {
        $val = \DB::table('stockroom_stock_putting_products AS stock')
                ->join ('stockroom_serialnumbers AS serialnumbers','serialnumbers.stkr_srial_putting_product_id', '=','stock.id')
                ->where('stock.stkr_stk_putng_prdct_product_id', '=', $product_id)
                ->where('serialnumbers.stkr_srial_serial_numbers_a', '=', $sa['SerialA'])
                ->where('serialnumbers.stkr_srial_serial_numbers_b', '=', $sa['SerialB'])
                ->where('serialnumbers.stkr_srial_status', '=', 0)
                ->where('serialnumbers.deleted_flag', '=', 0)
                ->select( \DB::raw('serialnumbers.id AS serialnumberID'))
                ->get();
      }
      else{
      $val = \DB::table('stockroom_stock_putting_products AS stock')
              ->join ('stockroom_serialnumbers AS serialnumbers','serialnumbers.stkr_srial_putting_product_id', '=','stock.id')
              ->where('stock.stkr_stk_putng_prdct_product_id', '=', $product_id)
              ->where('serialnumbers.stkr_srial_serial_numbers_a', '=', $sa['SerialA'])
              ->where('serialnumbers.stkr_srial_status', '=', 0)
              ->where('serialnumbers.deleted_flag', '=', 0)
              ->select( \DB::raw('serialnumbers.id AS serialnumberID'))
              ->get();
          }

       $serialnumberRowID=$val[0]->serialnumberID;

       //Update serial number status  :: stockroom_serialnumbers
         $val = stockroom_serialnumber ::where('id', $serialnumberRowID)->first();
         $val->stkr_srial_status =1; //sold Status
       if ($val->save()) $Result_status=$Result_status && true;

      //Update  count of products     :: stockroom_product_status
        $val =  stockroom_product_statu ::where('sps_product_id', $product_id)->first();
        if ($val->sps_reserved-1 >=0)
          $val->sps_reserved =$val->sps_reserved-1;
        $val->sps_sold =$val->sps_sold+1;
      if ($val->save()) $Result_status=$Result_status && true;

       //insert serilaNumber to stockrequests  :: sell_takeoutproducts
        $val= new sell_takeoutproduct ($request->all());
        $val->sl_top_stockrequest_id =$StockRequest_id;
        $val->sl_top_product_serialnumber_id =$serialnumberRowID;
        $val->sl_top_productid =$product_id;
        $val->sl_top_StockRequestRowID =$StockRequestRowID;
        $val->archive_flag =0;
        $val->deleted_flag =0;
      if ($val->save()) $Result_status=$Result_status && true;

        }

        //update count of serialnumbers  ::sell_stockrequests_details
        /*
        $val = sell_stockrequests_detail ::
        where('id', $serialnumberRowID)
        ->first();
        $val->stkr_srial_status =1; //sold Status
        if ($val->save()) $Result_status=$Result_status && true;
      */

        if ($Result_status )return 1;
  }


    public function checkserial (request $request)
    {
        $data = $request->all();
        $serialType= $data['type'];
        $product_ID=$data['product_ID'];
        $serialValue =$data['serialValue'];

        if ($serialType==1)
        {
            return  $val = \DB::table('stockroom_stock_putting_products AS stock')
                ->join ('stockroom_serialnumbers AS serialnumbers','serialnumbers.stkr_srial_putting_product_id', '=','stock.id')
                ->where('stock.stkr_stk_putng_prdct_product_id', '=', $product_ID)
                ->where('serialnumbers.stkr_srial_serial_numbers_a', '=',$serialValue)
                ->where('serialnumbers.stkr_srial_status', '=', 0)
                ->where('serialnumbers.deleted_flag', '=', 0)
                ->count();
        }

        if ($serialType==2)
        {

            $serialValueA =$data['serialValueA'];
            return     $val = \DB::table('stockroom_stock_putting_products AS stock')
                ->join ('stockroom_serialnumbers AS serialnumbers','serialnumbers.stkr_srial_putting_product_id', '=','stock.id')
                // ->where('stock.stkr_stk_putng_prdct_product_id', '=', $product_ID)
                ->where('serialnumbers.stkr_srial_serial_numbers_a', '=',$serialValueA)
                ->where('serialnumbers.stkr_srial_serial_numbers_b', '=',$serialValue)
                ->where('serialnumbers.stkr_srial_status', '=', 0)
                ->where('serialnumbers.deleted_flag', '=', 0)
                ->count();
        }
    }


    public static function  ChassisSerialNumbers( $ChassisID)
    {
      return  $RequestDataSubChassis = \DB::table('sell_takeoutproducts AS  takeoutproducts')
            ->join ('stockroom_serialnumbers AS serialnumbers','serialnumbers.id', '=','takeoutproducts.sl_top_product_serialnumber_id')
            ->where('takeoutproducts.sl_top_StockRequestRowID', '=', $ChassisID)
            ->get();
//        return $RequestDataSubChassis[0]->stkr_srial_serial_numbers_a;
    }

  public static function subChassisPartsAndSerialNumbers($stockrequerstID, $parentChassisID)
  {
      //return $stockrequerstID.' '.$parentID;
   return   $RequestDataSubChassis = \DB::table('sell_stockrequests_details AS stockrequests_details')
       ->join ('stockroom_products AS products','products.id', '=','stockrequests_details.ssr_d_product_id')
       ->join ('sell_takeoutproducts AS takeoutproducts','takeoutproducts.sl_top_StockRequestRowID', '=','stockrequests_details.id')
       ->join ('stockroom_serialnumbers AS serialnumbers','serialnumbers.id', '=','takeoutproducts.sl_top_product_serialnumber_id')

      ->where('stockrequests_details.ssr_d_stockrequerst_id', '=', $stockrequerstID)
      ->where('stockrequests_details.ssr_d_ParentChasis', '=', $parentChassisID)
       ->select('*', \DB::raw('products.id AS productsID ' ))
      ->get();
  }



  public function printStockRequest ($StockRequest_id)
  {
    $RequestData = \DB::table('sell_stockrequests AS stockrequests')
              ->join ('custommers AS custommer','custommer.id', '=','stockrequests.sel_sr_custommer_id')
              ->join ('custommerorganizations AS custommerORG','custommerORG.id', '=','custommer.cstmr_organization')
              ->join ('sell_stockrequests_details AS stockrequests_details','stockrequests_details.ssr_d_stockrequerst_id', '=','stockrequests.id')
              //->join ('sell_takeoutproducts AS takeoutproducts','takeoutproducts.sl_top_stockrequest_id', '=','stockrequests.id')
              //->join ('stockroom_serialnumbers AS serialnumbers','serialnumbers.id', '=','takeoutproducts.sl_top_product_serialnumber_id')
              ->join ('stockroom_products AS products','products.id', '=','stockrequests_details.ssr_d_product_id')
                ->join ('stockroom_products_brands AS brands','brands.id', '=','products.stkr_prodct_brand')
                ->join ('stockroom_products_types AS types','types.id', '=','products.stkr_prodct_type')
              ->where('stockrequests.id', '=', $StockRequest_id)
              ->where('stockrequests_details.ssr_d_ParentChasis', '=', 0)
              ->select('*', \DB::raw('stockrequests_details.id AS stkreqdeta_id ,stockrequests.id AS stockrequestsid' ))
              ->get();



      $RequestDataSubChassis = \DB::table('sell_stockrequests_details AS stockrequests_details')
          ->join ('sell_takeoutproducts AS takeoutproducts','takeoutproducts.sl_top_StockRequestRowID', '=','stockrequests_details.id')
////          ->join ('stockroom_serialnumbers AS serialnumbers','serialnumbers.id', '=','takeoutproducts.sl_top_product_serialnumber_id')
////          ->join ('stockroom_products AS products','products.id', '=','stockrequests_details.ssr_d_product_id')
//          ->where('stockrequests_details.ssr_d_stockrequerst_id', '=', $StockRequest_id)
//          ->select('*', \DB::raw('stockrequests_details.id AS stkreq_details_id'))
          ->get();


              $serialnumberData = \DB::table('stockroom_serialnumbers AS serialnumbers')
                        ->join ('sell_takeoutproducts AS takeoutproducts','takeoutproducts.sl_top_product_serialnumber_id', '=','serialnumbers.id')
                        ->where('takeoutproducts.sl_top_stockrequest_id', '=', $StockRequest_id)
                        ->get();
      $delivery_date=$RequestData[0]->sel_sr_delivery_date;
      $DateArray=explode("-",$delivery_date);
      $year=$DateArray[0];$month=$DateArray[1];$day=$DateArray[2];

      $registration_date=$RequestData[0]->sel_sr_registration_date;
      $DateArray=explode("-",$registration_date);
      $dyear=$DateArray[0];$dmonth=$DateArray[1];$dday=$DateArray[2];

      $px=new PublicClass();
      $delivery_date=$px->convert_gregorian_to_jalali($year,$month,$day);
      $registration_date=$px->convert_gregorian_to_jalali($dyear,$dmonth,$dday);


    return view('sell/view_stockRequest/stockRequest_parts/print_stockRequest',
           compact('RequestData','serialnumberData','delivery_date','registration_date','RequestDataSubChassis'));

  }


    public function getProductName (request $request)
    {
      try
      {
        $data = $request->all();
        $brandName= $data['brandName'];
        $TypeName=$data['TypeName'];
         $val = \DB::table('stockroom_products')
              ->join('stockroom_products_brands AS brd', 'stockroom_products.stkr_prodct_brand', '=','brd.id')
              ->join('stockroom_products_types', 'stockroom_products.stkr_prodct_type', '=','stockroom_products_types.id')
              ->where('stockroom_products.deleted_flag', '=', 0)
              ->where('brd.stkr_prodct_brand_title', '=', $brandName)
              ->where('stockroom_products_types.stkr_prodct_type_title', '=', $TypeName)
              //->select('*')
              ->select('*', \DB::raw('stockroom_products.id AS productID '))
              ->orderBy('stockroom_products.id', 'desc')
              //->paginate(15);
              ->get();
          return $val;
      }
      catch (\Exception $e)
      {   return $e->getMessage();}
    }

    //---------------------



//-----------------------
    public function  reports($TakoutID)
    {
            $val = \DB::table('sell_stockrequests_details AS stockrequests_details')
            ->join('stockroom_products AS products', 'products.id', '=','stockrequests_details.ssr_d_product_id')
            ->where('stockrequests_details.ssr_d_stockrequerst_id', '=', $TakoutID)
            ->select('*')
            //->orderBy('stockroom_products.id', 'desc')
            ->get();

            $TotalQty=0;
            foreach ($val as $v )
            {
                $TotalQty=$TotalQty+ $v->ssr_d_qty;
            }

        return view('sell/view_stockRequest/reports/page',
            compact( 'val','TakoutID','TotalQty'));
    }
//---------------------------------------
    public function pdfStockRequest($id)
        {

//            https://packagist.org/packages/carlos-meneses/laravel-mpdf?q=&p=2&hFR[type][0]=composer-plugin
//            https://github.com/niklasravnsborg/laravel-pdf
//https://mpdf.github.io/paging/page-breaks.html

        //NEW
        $RequestData = \DB::table('sell_stockrequests AS stockrequests')
            ->join ('custommers AS custommer','custommer.id', '=','stockrequests.sel_sr_custommer_id')
            ->join ('custommerorganizations AS custommerORG','custommerORG.id', '=','custommer.cstmr_organization')
            ->join ('sell_stockrequests_details AS stockrequests_details','stockrequests_details.ssr_d_stockrequerst_id', '=','stockrequests.id')
            ->join ('stockroom_products AS products','products.id', '=','stockrequests_details.ssr_d_product_id')
            ->join ('stockroom_products_brands AS brands','brands.id', '=','products.stkr_prodct_brand')
            ->join ('stockroom_products_types AS types','types.id', '=','products.stkr_prodct_type')
            ->where('stockrequests.id', '=', $id)
            ->where('stockrequests_details.ssr_d_ParentChasis', '=', 0)
            ->select('*', \DB::raw('stockrequests_details.id AS stkreqdeta_id ,stockrequests.id AS stockrequestsid' ))
            ->get();

        $serialnumberData = \DB::table('stockroom_serialnumbers AS serialnumbers')
            ->join ('sell_takeoutproducts AS takeoutproducts','takeoutproducts.sl_top_product_serialnumber_id', '=','serialnumbers.id')
            ->where('takeoutproducts.sl_top_stockrequest_id', '=', $id)
            ->get();
        //----------
        $stackReq=  sell_stockrequest::where('id', '=', $id)->firstOrFail();
        $Pdfsetting= json_decode($stackReq['sel_sr_pdf_setting'], false);
        $delivery_date=$RequestData[0]->sel_sr_delivery_date;
        $DateArray=explode("-",$delivery_date);
        $year=$DateArray[0];$month=$DateArray[1];$day=$DateArray[2];

        $registration_date=$RequestData[0]->sel_sr_registration_date;
        $DateArray=explode("-",$registration_date);
        $dyear=$DateArray[0];$dmonth=$DateArray[1];$dday=$DateArray[2];

        $px=new PublicClass();
        $delivery_date=$px->convert_gregorian_to_jalali($year,$month,$day);
        $registration_date=$px->convert_gregorian_to_jalali($dyear,$dmonth,$dday);
        $Jdatat =explode("/",$delivery_date);
        $Jyear=explode("13",$Jdatat[0]);

        $mpdf = new Mpdf('','A4',  0,  '',  15,  15,  35, 55,
                           1,  9,   'P');
        //$html = '<bookmark content="Start of the Document" /><div>Section text </div>'.$id;
        $lbl_date=\Lang::get('labels.date') ;
        $lbl_number=\Lang::get('labels.Number');
        $lbl_pageNumber=\Lang::get('labels.pageNumber');
       $header='<img src="img/sr_print_logo_PDF.png"  >
        <div style="text-align: left; padding-left: 60px; margin-top: -20px" >صفحه  {PAGENO}از{nb}</div> 
<div style="width: 100%;text-align: left;padding-left: 100px ;margin-bottom: 10px;height: 100px;"></div> ';

       $cstmr_name= $RequestData[0]->cstmr_name;
       $cstmr_family= $RequestData[0]->cstmr_family;
       $org_name= $RequestData[0]->org_name;
       if ($RequestData[0]->cstmr_organization ==1) $customer=$cstmr_name.' '.$cstmr_family; else $customer=$org_name;
       $contract_number=$RequestData[0]->sel_sr_pre_contract_number;

    $topTable='
                <div > 
                    <div style="width: 160px; float: left;">
                    <br/>
                    '. $lbl_date .' تحویل '.':  <span class="farsiNumber" >'. $delivery_date.' </span> <br/>
                    '.$lbl_number.': EP'.$Jyear[1].'-'.$id.' <br/>                         
                    </div>
                </div>
                <div style="text-align: center" > بسمه تعالي  <br/> صورتجلسه تحويل دستگاه  </div>
                <br/>
                <table   style="width: 100%; border: 1px solid #4c4c4e;">
                    <tr>
                        <td style="width: 20%;">فروشنده / مجري :</td>
                        <td>شرکت سيستمهای اطلاعاتی پيشرو	</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">خريدار / كارفرما :	</td>
                        <td>'.$customer.'</td>
                    </tr>
                    <tr>
                        <td>شماره قرارداد / فاكتور</td>
                        <td  style="width: 60%">: '.$contract_number.' </td>
                        <td>'.$lbl_date.'</td>
                        <td class="farsiNumber">'.$registration_date.'</td>
                    </tr>
                </table>';

    $table_Header='<table style="width: 100% ; " >
                <tr style="background: #c0c0c0 ;color: #fff">
                    <th width="1cm">رديف</th>
                    <th width="3cm">شرح</th>
                    <th width="10cm">شماره سريال</th>
                    <th width="20%">پارت نامبر</th>
                    <th width="1cm">تعداد</th>
                </tr>
                </table>';
        $table_Header='';


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $e=new makePdf();
        $content_Table2 =$e->ContentType_B($RequestData);
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $e=new makePdf();
        $content_Table1 =$e->ContentType_A($RequestData);
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $e=new makePdf();
        $content_Table3 =$e->ContentType_C($RequestData,$Pdfsetting);
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $signature="<table width='100%'   class='signature cellBorder bordergray'>                  
                    <tr>
                    <td class='border-left bordergray' style='height: 90px;'>
                        نماينده خريدار با امضاي ذيل اين برگه دريافت اقلام فوق را تاييد مينمايد. 
                        <br/>
                        نام و نام خانوادگي : ----------
                        <br/> 
                        واحد فن آوري اطلاعات و انفورماتيك
                    </td>
                    <td>
                        سيستمهاي اطلاعاتي پيشرو
                        <br/> 
                        
                        <table style='width: 100%'>
                            <tr>
                                <td>کارشناس فنی </td>
                                <td style='text-align: left'>کارشناس فروش</td>
                            </tr>
                        </table>                        	                           
                    </td>        
                </tr>            
        </table>";

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $footer=$signature.'<img style="margin-top: 0px " src="img/footer.png">';
//    $footer='<img src="img/footer.png" >';


$html =
    <<<EOT
        <!DOCTYPE>
        <html>
            <head>
            <style>
            body {
            direction: rtl;
            font-family: byekan !important;            
            }    
          .farsiNumber
            {
            font-family: Koodak !important;
            }
             .officeAddress
            {
                font-size: 13.5px;
                text-align: center;
                padding-top: 5px;
                padding-bottom: 5px;                    
            }
            .signature
            {
                  
                font-size: 10px !important;
            }
            .cellBorder
                {
                 border: 1px solid ;
                }
             .border-left
             {
                border-left: 1px solid ;
             }   
            .bordergray
            {
                border-color:gray;
            }    
            </style>
            </head>
            <body>             
                <div> $topTable </div>
                <br/>
                
                $table_Header
                           
                $content_Table3   
                  <p></p>
                  <br/>  
                
                    
                           
                <br/>              
            </body>
        </html>
EOT;


        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        //$mpdf->SetHTMLFooter('<div class="pdf_date" style="color:black; text-align:left;" >{DATE j-m-Y}</div><div class="pdf_pagination" style="color:black; text-align:right;" >{PAGENO}</div>');

        $mpdf->AddPage(); // force pagebreak
        $mpdf->WriteHTML($html);

//        return $mpdf->Output();
        $file_name = $contract_number.'_'.$registration_date.'_'.$customer.'.pdf';
        $mpdf->Output($file_name, 'D');




        }
}
