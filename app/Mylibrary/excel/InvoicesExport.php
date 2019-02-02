<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 02/02/2019
 * Time: 09:48 AM
 */

namespace App\Mylibrary\excel;

use App\sell_invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    public function collection()
    {
        return sell_invoice::all();
    }
}