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


                        // File and new size
                        $filename =$path.'/'.$image;
                        $this->make_thumbnil($filename,$ext,$path,$image);

                    }else{
                        echo "Image Is Empty";
                    }

                }
                catch (\Exception $e)
                {
                    return $e->getMessage();
                }


    //                return $_FILES['file']['name'];
            break;
        }
    }


    function  make_thumbnil($filename,$ext,$path,$image)
    {
        // Get new sizes
        $percent = 0.1;
        list($width, $height) = getimagesize($filename);
        $newWidth = 259 ; //$width * $percent;
        $newHeight =145;// $height * $percent;

        switch ($ext)
        {
            case 'jpg':
                // Content type
                header('Content-Type: image/jpeg');
                // Load
                $thumb = imagecreatetruecolor($newWidth, $newHeight);
                if ($ext=='jpg')
                    $source = imagecreatefromjpeg($filename);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                // Output
                $thumbPath=$path.'/thumb';
                mkdir($thumbPath);
                echo imagejpeg($thumb,$thumbPath.'/'.$image);
            break;
            case 'png':
                $img = imagecreatefrompng($filename);
                $newImage = imagecreatetruecolor($newWidth, $newHeight);
                imagealphablending($newImage, false);
                imagesavealpha($newImage,true);
                $transparency = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newHeight, $newHeight, $transparency);
                imagecopyresampled($newImage, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                // Output
                $thumbPath=$path.'/thumb';
                mkdir($thumbPath);
                imagepng($newImage,$thumbPath.'/'.$image);
            break;
            case 'mp4':
//https://stackoverflow.com/questions/2043007/generate-preview-image-from-video-file
//https://documentation.concrete5.org/developers/packages/advanced-including-third-party-libraries-in-a-package
//
//$sec = 10;
//$movie = 'test.mp4';
//$thumbnail = 'thumbnail.png';
//
//$ffmpeg = FFMpeg\FFMpeg::create();
//$video = $ffmpeg->open($movie);
//$frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
//$frame->save($thumbnail);
//echo '<img src="'.$thumbnail.'">';

                break;


        }
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
