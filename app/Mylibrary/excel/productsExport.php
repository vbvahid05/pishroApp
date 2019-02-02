<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 02/02/2019
 * Time: 09:52 AM
 */

namespace App\Mylibrary\excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class productsExport implements FromCollection,WithHeadings,WithMapping
{

    public function collection()
    {
     return   $AllProducts = \DB::table('stockroom_products')
            ->join('stockroom_products_brands', 'stockroom_products_brands.id', '=', 'stockroom_products.stkr_prodct_brand')
            ->join('stockroom_products_types',  'stockroom_products_types.id', '=', 'stockroom_products.stkr_prodct_type')
            ->select( \DB::raw('stockroom_products_brands.stkr_prodct_brand_title AS Brand ,
                                  stockroom_products_types.stkr_prodct_type_title AS Type,
                                   stockroom_products.stkr_prodct_type_cat AS type_cat ,
                                  stockroom_products.stkr_prodct_partnumber_commercial AS PartNumber,                                                                   
                                  stockroom_products.stkr_prodct_price AS epl  ,
                                  stockroom_products.stkr_tadbir_stock_id AS Tadbir ,
                                  stockroom_products.stkr_prodct_title AS Title 
                                 
           '))
            ->orderBy('stockroom_products.stkr_prodct_brand', 'ASC')
            ->get();
    }


    public function headings(): array
    {
        return [
            'برند',
            'نوع کالا',
            'گروه کالا',
            'پارتنامبر',
            'قیمت EPL',
            'کد تدبیر',
            'شرح کالا'
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        if ($row->type_cat==1)
            $typCat='قطعه';
        else if ($row->type_cat==2)
            $typCat='قطعه منفصله';
        else
            $typCat='شاسی';

        return
            [
                $row->Brand,
                $row->Type,
                $typCat,
                $row->PartNumber,
                $row->epl,
                $row->Tadbir,
                $row->Title
            ];
    }
}