<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 16/02/2019
 * Time: 02:35 PM
 */

namespace App\Mylibrary\excel;
use App\sell_stockrequest;
use App\stockroom_product_statu;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class StockReportExport implements fromArray,WithHeadings
{


    public function taahodiQTY($productsId)
    {
        $results=  \DB::table('sell_stockrequests_details AS stockrequests_details')
            ->join('sell_stockrequests AS stockrequest', 'stockrequest.id', '=','stockrequests_details.ssr_d_stockrequerst_id')
            ->where ('stockrequests_details.ssr_d_product_id','=',$productsId)
            ->where ('stockrequest.sel_sr_type','=',1)
            ->get();

        $sumTahodiQTY=0;
        foreach ( $results as $res)
        {
                 $sumTahodiQTY=$sumTahodiQTY+$res->ssr_d_qty;
        }
         return $sumTahodiQTY;
    }


    public function reservedQTY( $productsId)
    {
        $result=  \DB::table('sell_stockrequests AS stockrequests')
            ->join('sell_stockrequests_details AS stockrequests_details', 'stockrequests.id', '=','stockrequests_details.ssr_d_stockrequerst_id')
            ->where ('stockrequests_details.ssr_d_product_id','=',$productsId)
            ->where ('stockrequests.sel_sr_type','=',0) // ghatii
            ->select('*')
            ->get();

        $TotalCount=0;
        foreach ($result as $re)
        {
            $TotalCount=$TotalCount+$re->ssr_d_qty;
        }

        // jame  kharej shodeha
        $result2=  \DB::table('sell_stockrequests AS stockrequests')
            ->join('sell_takeoutproducts AS takeoutproducts', 'takeoutproducts.sl_top_stockrequest_id', '=','stockrequests.id')
            ->where ('takeoutproducts.sl_top_productid','=',$productsId)
            ->where ('stockrequests.sel_sr_type','=',0) // ghatii
            ->select('*')
            ->count();


        return  $TotalCount-$result2;
    }

    public function array(): array
    {

        $result=  \DB::table('stockroom_serialnumbers AS serialnumbers')
            ->join('stockroom_stock_putting_products AS putting_products', 'putting_products.id', '=','serialnumbers.stkr_srial_putting_product_id')
            ->join('stockroom_products AS products', 'products.id', '=','putting_products.stkr_stk_putng_prdct_product_id')
//           ->select('*')
            ->select('*',\DB::raw('serialnumbers.created_at AS serialCreatedAt ,
                                 serialnumbers.updated_at AS serialUpdatedAt ,
                                 products.id AS productsId   
                              
          
          '))
            ->get();

        $buf=array();
        $allRecords=array();
        $index=1;
        foreach ($result AS $r)
        {
            if ( !in_array( $r->stkr_prodct_partnumber_commercial,$buf ) )
            {
                array_push($buf,$r->stkr_prodct_partnumber_commercial);

                $AllSerialInQTY=  \DB::table('stockroom_serialnumbers AS serialnumbers')
                    ->join('stockroom_stock_putting_products AS putting_products', 'putting_products.id', '=','serialnumbers.stkr_srial_putting_product_id')
                    ->join('stockroom_products AS products', 'products.id', '=','putting_products.stkr_stk_putng_prdct_product_id')
                    ->where ( 'products.stkr_prodct_partnumber_commercial','=',$r->stkr_prodct_partnumber_commercial )
                    ->select('*' )
                    ->count();


                $takeoutQTY=  \DB::table('sell_takeoutproducts AS takeoutproducts')
                    ->where ( 'takeoutproducts.sl_top_productid','=',$r->productsId )
                    ->select('*',\DB::raw('serialnumbers.created_at AS serialCreatedAt ,
                                 serialnumbers.updated_at AS serialUpdatedAt '))
                    ->count();


                $reservedQTY =$this->reservedQTY($r->productsId);//
                $taahodiQTY= $this->taahodiQTY($r->productsId);

                $reminedQTY=($AllSerialInQTY-($takeoutQTY+$reservedQTY));
                    if ($reminedQTY ==0) $reminedQTY='0';
                    if ($takeoutQTY ==0) $takeoutQTY='0';
                    if ($reservedQTY ==0) $reservedQTY='0';
                     if ($taahodiQTY ==0) $taahodiQTY='0';


//           Update     stockroom_product_status
//                    stockroom_product_statu::
//                    where('sps_product_id', '=', $r->productsId)
//                   ->update(array(
//                                 'sps_available' => $reminedQTY ,
//                                  'sps_reserved' => $reservedQTY ,
//                                  'sps_sold' => $takeoutQTY ,
//                                  'sps_Taahodi' => $taahodiQTY ,
//
//                   ));


                $row=array(
                    "taahodi"=>$taahodiQTY,
                    "reminedQTY"=>$reminedQTY ,
                    "takeoutQTY"=>$takeoutQTY ,
                    "reservedQTY"=>$reservedQTY ,
                    "AllSerialInQTY"=>$AllSerialInQTY,
                    "prodct_title"=>$r->stkr_prodct_title,
                    "partnumber"=>$r->stkr_prodct_partnumber_commercial,
                    "productsId"=>$r->productsId,
                    "#"=>$index++,

               );
               array_push($allRecords,$row);
            }
        }
        return $allRecords;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'تعهدی',
            'باقی مانده انبار',
            'جمع خروجی	',
            'تعداد رزور',
            'جمع کل ورودی',
            'شرح کالا',
            'پارتنامبر',
            'کد کالا',
            '#',

        ];
    }

}