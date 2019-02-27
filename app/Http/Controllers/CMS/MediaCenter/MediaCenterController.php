<?php

namespace App\Http\Controllers\CMS\MediaCenter;

use App\Model_admin\cms_post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MediaCenterController extends Controller
{
    public function manageRequest(Request $request,$action)
    {
//        $postAction= $request['postAction'];

        switch ($action) {
            case 'upload':
                try
                {

                    if(!empty($_FILES['image'])){
                        $ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                        $image = time().'.'.$ext;
                        move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/'.$image);
                        echo $_FILES["image"]["tmp_name"]."Image uploaded successfully as ".$image;
                    }else{
                        echo "Image Is Empty";
                    }


//                    $post= cms_post::find(1);
//                    $post ->addMedia($_FILES['image']['name'])->toMediaCollection('test');


//                    if(Input::hasFile('file'))
//                    {
//
//                         $file = Input::file('file');
//                         $file->move('uploads', $file->getClientOriginalName());
//                        return 'Uploaded';
//                    }
//                    else
//                        return 'faild';
//


//                    if(!empty($_FILES)) {
//                        $path = 'uploads' . $_FILES['file']['name'];
//                        if (move_uploaded_file($_FILES['file']['name'], $path)) {
//                            return 'File Uploaded Successfully ;D';
//                        } else
//                            return 'faild ;(';
//                    }

//                         $file = Input::file('file');
////                         $file->move('uploads', $file->getClientOriginalName());
//                    $post= cms_post::find(1);
//                    $post ->addMedia($file->getClientOriginalName())->toMediaCollection();
//                    return 'File Uploaded Successfully ;D';
                }
                catch (\Exception $e)
                {
                    return $e->getMessage();
                }


    //                return $_FILES['file']['name'];
            break;
        }
    }

}
