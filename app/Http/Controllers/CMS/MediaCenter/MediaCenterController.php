<?php

namespace App\Http\Controllers\CMS\MediaCenter;


use App\File;
use App\Model_admin\cms_post;
use App\Model_admin\cms_term_relation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Model_admin\cms_media_center;
use App\Model_admin\cms_term;


class MediaCenterController extends Controller
{
    public function manageRequest(Request $request,$action)
    {

        switch ($action) {

            case 'showMediaCenterFiles':
                $viewmode=$request['viewmode'];
                $folder=$request['folder'];

                switch ($viewmode)
                {
                    case 'all':
                       return cms_media_center::where('mdiac_category', '=', $folder)->get();
                    break;
                }

            break;
            case 'showMediaCenterFolders':
                $term=$request['filesGallery'];
                $cms_term = cms_term::where('trm_type', '=', 'filesGallery')->firstOrFail();
                 $termID= $cms_term->id;
                return cms_term_relation::where('trmrel_term_id', '=', $termID)->get();

            break;
            case 'upload':
                try
                {

                    if(!empty($_FILES['image'])){
                        $folder= $request['folder'];
                        $ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                        $image = rand().time().'.'.$ext;



                        $media_center = new cms_media_center;
                        $media_center->mdiac_category = $folder;
                        $media_center->mdiac_name = $_FILES['image']['name'];
                        $media_center->mdiac_filename = $image;
                        $media_center->mdiac_mime_type = $ext;
                        $media_center->mdiac_size =  $_FILES['image']['size'];
                        $media_center->mdiac_upload_by =  Auth::user()->id;
                        $media_center->mdiac_permission = 0 ;
                        $media_center->mdiac_options = "" ;
                        $media_center->deleted_flag = 0 ;
                        $media_center->archive_flag = 0 ;
                        $media_center->save();

                        $galleryId=$media_center->id;


                        $path = public_path().'/storage/mediaCenter/'.$galleryId;
                        mkdir($path);



                        move_uploaded_file($_FILES["image"]["tmp_name"], $path.'/'.$image);
                        echo $image;




                    }else{
                        echo "Image Is Empty";
                    }




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


    function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }



    function unzip($location,$new_location){
        try{
            if(exec("unzip $location",$arr)){
                mkdir($new_location);
                $source_dir = dirname($location);
                for($i = 1;$i< count($arr);$i++){
                    $file = trim(preg_replace("~inflating: ~","",$arr[$i]));
                    copy($source_dir."/".$file,$new_location."/".$file);
                    unlink($source_dir."/".$file);
                }
                return 'Unziped';
            }
            return 'zip Faild';
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

    }

// usage of this code


}
