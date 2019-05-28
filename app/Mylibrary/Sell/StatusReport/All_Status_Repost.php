<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 22/05/2018
 * Time: 09:16 AM
 */

namespace App\Mylibrary\Sell\StatusReport;


class All_Status_Repost
{
    public  function get_reports ($request)
    {
        $data=$request->all();
        $mode=$data['qmode'];
        //-----------------------
        $valMain = \DB::table('stockroom_products')
            ->select('*')
            ->where('stockroom_products.deleted_flag', '=', 0)
            ->orderBy('stockroom_products.id', 'desc')
            ->get();
        //--------------------------
        $outArray=array();
        foreach ($valMain as $vm)
        {
            //--- Main ForEach ----
            $stVal1=0;$stVal2=0;$stVal3=0;
            $stVal4=0;$stVal5=0;
            //-----------------------
            $val = \DB::table('stockroom_stock_putting_products')
                ->join('stockroom_products AS products'   ,   'products.id', '=','stockroom_stock_putting_products.stkr_stk_putng_prdct_product_id')
                ->join('stockroom_orders AS orders'   ,   'orders.id', '=','stockroom_stock_putting_products.stkr_stk_putng_prdct_order_id')
                ->join('stockroom_orders_status AS status'   ,   'status.id', '=','orders.stk_ordrs_status_id')
                ->select('*')
                ->where('stockroom_stock_putting_products.stkr_stk_putng_prdct_product_id', '=', $vm->id)
                ->where('stockroom_stock_putting_products.deleted_flag', '=', 0)
                ->get();
            //-----------------------
            foreach ($val as $v)
            {
                $status =$v->stk_ordrs_status_id;
                switch($status)
                {
                    case 1:
                        $stVal1=$stVal1+$v->stkr_stk_putng_prdct_qty;
                        break;
                    case 2:
                        $stVal2=$stVal2+$v->stkr_stk_putng_prdct_qty;
                        break;
                    case 3:
                        $stVal3=$stVal3+$v->stkr_stk_putng_prdct_qty;
                        break;
                    case 4:
                        $stVal4=$stVal4+$v->stkr_stk_putng_prdct_qty;
                        break;
                    case 5:
                        $stVal5=$stVal5+$v->stkr_stk_putng_prdct_qty;
                        break;
                }
            }
            //-----------------------
            $productID= $vm->id;
            $productStatus = \DB::table('stockroom_product_status')
                ->select('*')
                ->where('stockroom_product_status.sps_product_id', '=', $productID)
                ->where('stockroom_product_status.deleted_flag', '=', 0)
                ->get();
            $productStatus_count=count($productStatus);
            if ($productStatus_count !=0)
            {
                ($productStatus[0]->sps_available != null ? $avail=$productStatus[0]->sps_available  : $avail=0);
                ($productStatus[0]->sps_sold      != null ? $sold=$productStatus[0]->sps_sold  : $sold=0);
                ($productStatus[0]->sps_reserved  != null ? $reserved=$productStatus[0]->sps_reserved  : $reserved=0);
                ($productStatus[0]->sps_borrowed  != null ? $borrowed=$productStatus[0]->sps_borrowed  : $borrowed=0);
                ($productStatus[0]->sps_warranty  != null ? $warranty=$productStatus[0]->sps_warranty  : $warranty=0);
                ($productStatus[0]->sps_Taahodi  != null ? $sps_Taahodi=$productStatus[0]->sps_Taahodi  : $sps_Taahodi=0);
            }
            else
            {
                $avail   =0;
                $sold    =0;
                $reserved=0;
                $borrowed=0;
                $warranty=0;
                $sps_Taahodi=0;
            }

            //-----------------------
            $getProductDetails = \DB::table('stockroom_products AS products')
                ->join('stockroom_products_brands AS brands'   ,   'brands.id', '=','products.stkr_prodct_brand')
                ->join('stockroom_products_types AS types'   ,   'types.id', '=','products.stkr_prodct_type')
                ->select(\DB::raw('brands.stkr_prodct_brand_title AS  brand_title ,
                                   types.stkr_prodct_type_title   AS type_title ,
                                   products.stkr_prodct_type_cat  AS  type_cat'))
                ->where('products.id', '=', $vm->id)
                ->where('products.deleted_flag', '=', 0)
                ->get();
            //-----------------------
             // $sum=$stVal1+$stVal2+$stVal3+$stVal4+$stVal5;
            //$AvailableStock=($avail+$sum)-($reserved+$borrowed+$warranty+$sps_Taahodi);

            $sum=($stVal1+$stVal2+$stVal3+$stVal4+$stVal5)-($avail+$sold+$reserved+$borrowed+$warranty);
            if ($sum >=0)
                $sum=$sum;
            else
                $sum=0;

            $AvailableStock=($avail+$sum+$reserved)-($reserved+$borrowed+$warranty+$sps_Taahodi);

            if ($stVal4-($avail+$sold+$reserved+$warranty+$borrowed) >=0)
                $stVal4 =$stVal4-($avail+$sold+$reserved+$warranty+$borrowed);
            else
                $stVal4=0;

            $array = array(
                "productID"    => $vm->id,
                "partnumber"  => $vm->stkr_prodct_partnumber_commercial,
                "prodct_title" => $vm->stkr_prodct_title ,
                "prodct_Brand"=> $getProductDetails[0]->brand_title,
                "prodct_Type"=> $getProductDetails[0]->type_title,
                "prodct_Type_Cat"=> $getProductDetails[0]->type_cat,
                "status1" =>  $stVal1 ,//در حال مذاکره
                "status2" =>  $stVal2 , //تایید سفارش
                "status3" =>  $stVal3 , //منتظر بررسی در مبدا
                "status4" =>  $stVal4 , //ترخیص شده
                "status5" =>  $stVal5 ,//گمرکات داخل کشور

                "status2_1_avail"    =>  $avail  ,
                "status2_2_sold"     =>  $sold ,
                "status2_3_reserved" =>  $reserved ,
                "status2_4_borrowed" =>  $borrowed ,
                "status2_5_warranty" =>  $warranty,
                "status2_6_sps_Taahodi" =>  $sps_Taahodi,
                "AvailableStock" => $AvailableStock,
                "sum"     =>  $sum //$sum-$warranty //جمع کل ورودی

            );
            if ($mode==0)
                array_push($outArray,$array);
            else if ($mode==1 && $AvailableStock >=1 )
            {
                array_push($outArray,$array);
            }

            //--- Main ForEach ----

        }
        return $outArray;
        //-----------------------

    }

    public function   get_brands($request)
    {

            $Brands = \DB::table('stockroom_products_brands  AS brands')
                ->select(\DB::raw('brands.id AS  id ,
                              brands.stkr_prodct_brand_title AS  name'))
                ->get();

            $masterArray=array();
            $subArray=array('id'=>'' , 'name'=>'همه برندها');
            array_push($masterArray,$subArray);
            foreach ($Brands As $Brand)
            {
                $subArray=array('id'=>$Brand->name , 'name'=>$Brand->name);
                array_push($masterArray,$subArray);
            }
            return $masterArray;
        }

// --------------------

    public function  get_types($brand_name)
    {
        try
        {
          return  $types=\DB::table('stockroom_products_types AS types')
                ->join('stockroom_products_brands AS brands','brands.id','=','types.stkr_prodct_type_In_brands')
                ->where('brands.stkr_prodct_brand_title', '=', $brand_name)
                ->select(\DB::raw('types.id AS id , types.stkr_prodct_type_title AS name '))
                ->get();

            $masterArray=array();
            $subArray=array('id'=>'' , 'name'=>'همه نوع کالا');
            array_push($masterArray,$subArray);
            foreach ($types As $type)
            {
                $subArray=array('id'=>$type->name , 'name'=>$type->name);
                array_push($masterArray,$subArray);
            }
            return $masterArray;
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

    }



}