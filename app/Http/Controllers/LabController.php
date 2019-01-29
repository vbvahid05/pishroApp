<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;
use App\Stockroom_products;
use App\Mylibrary\PublicClass;
//use \Input as Input;
use Illuminate\Support\Facades\Input;
class LabController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }

    public function upload()
    {
      if(Input::hasFile('file'))
      {
        echo 'Uploaded';
        $file = Input::file('file');
        $file->move('uploads', $file->getClientOriginalName());
        echo '';
      }
    }

    public function angular_upload(Request $request)
    {
          return $request->file('image_file')->getClientOriginalName();
        /*
        if($request->file())
        {
          $file = Input::file('file');
          $file->move('uploads', $file->getClientOriginalName());
          return  " successfully uploaded";
        }else
        {
        return "Invalid File or Empty File";
        }
        */

    }

        public function  movePartNumbers()
        {
            return 'disabled';
            $check=new PublicClass();
            $products = \DB::table('stockroom_products_temp')->get();
$i=0;
            foreach ($products AS $prd)
            {
                $newPart= $check->checkAscii($prd->stkr_prodct_partnumber_commercial);

//                echo $prd->id.'<br/>';
                \DB::table('stockroom_products')
                    ->where('id','=' ,$prd->id)
                    //->update('stkr_prodct_partnumber_commercial',$prd->stkr_prodct_partnumber_commercial);
                    ->update(['stkr_prodct_partnumber_commercial' =>$newPart ]);
                $i++;
            }

            return 'movePartNumbers'.' > '.$i;
        }


}
