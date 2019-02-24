<?php

namespace App\Http\Controllers\CMS\Posts;

use App\Model_admin\cms_post;
use App\Model_admin\cms_post_meta;
use App\Model_admin\cms_term;
use App\Model_admin\cms_term_relation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function showAllPosts(Request $request, $postType)
    {
        $viewListMode=Input::get("view");
        switch (Input::get("view"))
        {
            case 'trash':
                $deleted_flag=1;
            break;
            default:
                $deleted_flag=0;

        }
        $local='fa';

//        try
//        {
             $pageTitle=  \Lang::get('labels.Management').' '.\Lang::get('labels.'.$postType);
            $pageIcon="fa fa-file-text-o";
//
            $temcat = \DB::table('cms_post_types')
                ->where('pst_typ_title','=',$postType)
                ->select('*')
                ->get();
             $catID=$temcat[0]->pst_typ_Termcat_id;

            $dataList= \DB::table('cms_posts as  posts')
                ->Join('cms_term_relations as categories' ,'categories.id','=','posts.post_categury' )
                ->Join('cms_languages as lang' ,'lang.id','=','posts.post_lang' )
                ->Join('cms_post_types as postType' ,'postType.id','=','posts.post_type' )
                ->Join('users' ,'users.id','=','posts.post_author_id' )
                ->where('lang.lang_title','=',$local)
                ->where('postType.pst_typ_title','=',$postType)
                ->where('categories.trmrel_term_id','=',$catID)
                ->where('posts.deleted_flag','=',$deleted_flag)
                ->select(['*','posts.id as Postid'  ,'posts.created_at AS postsCreatedAt' ])
                ->orderby('Postid','DESC')
                //->get();
                ->paginate(10);
            //-----------
            return view('CMS/Posts/list/list',
                compact(
                    'local','postType' ,'viewListMode',
                    'pageTitle' ,'pageIcon','dataList','temcat'
                ));
//        }
//        catch (\Exception $e)
//        {
//            return $e;
//
//        }
    }

    public function GetAllCategory($locale,$postType)
    {
         return    \DB::table('cms_terms as terms')
            ->Join('cms_languages as language' ,'language.id','=','terms.trm_lang' )
            ->Join('cms_term_relations as relations' ,'relations.trmrel_term_id','=','terms.id' )
            ->where('language.lang_title','=',$locale)
            ->where('terms.trm_type','=',$postType)
            ->where('terms.deleted_flag','=',0)
            ->select(['*','relations.id as ItemID' ])
            ->get();
    }
//----------------------
    public  function  editPage(Request $request,$postType,$action)
    {

        $local ='fa';
        if ($action=='edit')
        {
            $pageTitle=  \Lang::get('labels.edit').' '.\Lang::get('labels.'.$postType);
            $pageIcon="fa fa-file-text-o";
            //------Get ID from Url    ---------
            $postId = $request->input('id');
//            //----------------------------------
//            //Query ->find Post By ->        ID,local,
            $dataList= \DB::table('cms_posts as posts')
                // ->Join('terms' ,'terms.id','=','posts.post_categury' )
                ->Join('cms_term_relations as relations' ,'relations.id','=','posts.post_categury' )
                ->Join('cms_languages as lang' ,'lang.id','=','posts.post_lang' )
                ->Join('cms_post_types as postType' ,'postType.id','=','posts.post_type' )
                ->select(['*','posts.id as Postid' ])
                ->where('posts.id','=',$postId)
                ->where('lang.lang_title','=',$local)
                ->where('postType.pst_typ_title','=',$postType)
//                ->where('posts.deleted_flag','=',0)
                ->orderby('Postid','DESC')
                ->get();
//            //----------------------------------
            $categuryList =$this->GetAllCategory($local,$postType);
              //----------------------------------
            $post= cms_post::find($postId);
              //$media= $post->getMedia()->first()->getUrl();;
             $media= $post->getMedia() ;


            if (count($dataList)!=0 && $action=='edit') $hasValue=true; else $hasValue=false;
            return view('/CMS/Posts/page/page',
                compact(
                    'action','local','postId','postType' ,'pageTitle' ,'pageIcon',
                    'dataList','categuryList','hasValue','media'));
       }
        else if ('new')
        {
            $hasValue=false;
            $pageTitle=  \Lang::get('labels.new').' '.\Lang::get('labels.'.$postType);
            $pageIcon="fa fa-file-text-o";
            $categuryList =$this->GetAllCategory($local,$postType);
            $postId='';

            return view('/CMS/Posts/page/page',
                compact(
                    'action','local','postId','postType' ,'pageTitle' ,'pageIcon','hasValue','categuryList'
                ));
         }
    }

 public function renderSlug($title)
 {
     $slog='';
     $str=explode(" ",$title);
     for($i=0 ;$i<=count($str)-1;$i++)
         if ($slog=='')
             $slog=$slog.$str[$i];
         else
             $slog=$slog.'-'.$str[$i];
         return $slog;
 }
//----------------------------------
   public function updateMetaTable_Tags($postID,$tagsArray)
   {
            $masterArray=array();
            for ($i=0;$i<= count($tagsArray)-1 ;$i++)
            {
              if( !cms_term_relation::find($tagsArray[$i])) // it's Not a number and  unavailable in table
              {
                  $term= cms_term::where('trm_type', '=', 'tag')->firstOrFail();
                  $termTypeID=$term['id'];

                   if (!cms_term_relation::
                     where('trmrel_title', '=', $tagsArray[$i])
                    ->where('trmrel_term_id', '=', $termTypeID)
                    ->count())
                       {
                           $cms_term_relation = new cms_term_relation;
                           $cms_term_relation->trmrel_term_id = $termTypeID;
                           $cms_term_relation->trmrel_title = $tagsArray[$i];
                           $cms_term_relation->trmrel_slug = '';
                           $cms_term_relation->trmrel_action = '';
                           $cms_term_relation->trmrel_value = '';
                           $cms_term_relation->trmrel_icon = '';
                           $cms_term_relation->trmrel_class = '';
                           $cms_term_relation->trmrel_lang_label = '';
                           $cms_term_relation->deleted_flag=0;
                           $cms_term_relation->archive_flag=0;
                           $cms_term_relation->save();
                               $tableStatus = \DB::select("show table status from  ratis_cms where Name = 'cms_term_relations'");
                               if (empty($tableStatus)) {
                                   throw new \Exception("Table not found");
                               }
                               $newId= $tableStatus[0]->Auto_increment;
                              array_push($masterArray ,$newId-1);
                       }
                       else
                       {
             $cms_term_rel=cms_term_relation::
                           where('trmrel_title', '=', $tagsArray[$i])
                           ->where('trmrel_term_id', '=', $termTypeID)
                           ->firstOrFail();
                           $trmrel= $cms_term_rel['id'];
                           array_push($masterArray ,$trmrel);
                       }
              }
              else
              array_push($masterArray ,(int)$tagsArray[$i]);
            }


           $tags=json_encode($masterArray);
           $count= cms_post_meta::where('pst_meta_post_id', '=',$postID)->count();
           if ($count) //update
           {
               cms_post_meta::where('pst_meta_post_id', '=', $postID)
                   ->update(array('pst_meta_value' => $tags));
           }
           else        //new
           {

               $cms_post_meta = new cms_post_meta;
               $cms_post_meta->pst_meta_post_id = $postID;
               $cms_post_meta->pst_meta_key = '_tags';
               $cms_post_meta->pst_meta_value = $tags;
               $cms_post_meta->deleted_flag = 0;
               $cms_post_meta->archive_flag = 0;
               $cms_post_meta->save();
           }



//
//       $tableStatus = \DB::select("show table status from  ratis_cms where Name = 'cms_posts'");
//       if (empty($tableStatus)) {
//           throw new \Exception("Table not found");
//       }
//   return    $newId= $tableStatus[0]->Auto_increment;
   }
//----------------------------------
    public function CRUD(Request $request,$postType,$action)
    {
        $postAction= $request['postAction'];
        if ($action =='newOrUpdate')
        {
            switch($postType)
            {
                case 'posts':
                    {
                        switch ($postAction)
                        {
                            case 'edit':
                                {
                                    try{

                                       $slug=$this->renderSlug( $request['postTitle']);
                                        cms_post::where('id', '=', $request['postID'])
                                            ->update(array(
                                                'post_title' => $request['postTitle'] ,
                                                'post_slug'=>$slug,
                                                'post_categury'=>$request['postCategury'] ,
                                                'post_content'=>$request['postContent'] ,
                                            ));

                                           $this->updateMetaTable_Tags($request['postID'],$request['tags']);
                                           //----------------------------Upload Image
                                           $post= cms_post::find($request['postID']);
                                           $post ->addMedia($request['postImage'])->toMediaCollection();
                                           //$post ->addMediaFromUrl($url)->toMediaCollection();
                                           $Imageid=$post->media[0]['id'];
                                           $imageName= $post->media[0]['file_name'];
                                            //----------------------------Upload Image
                                            return Storage::url($Imageid.'/'.$imageName);
                                        }
                                        catch (\Exception $e)
                                        {
                                            return $e->getMessage();
                                        }
                                }
                            case 'new':
                                {

                                    try{
                                        $slog='';
                                        $str=explode(" ",$request['postTitle']);
                                        for($i=0 ;$i<=count($str)-1;$i++)
                                            if ($slog=='')
                                                $slog=$slog.$str[$i];
                                            else
                                                $slog=$slog.'-'.$str[$i];

                                        $cms_post = new cms_post;
                                        $cms_post->post_title=$request['postTitle'];
                                        $cms_post->post_slug=$slog;
                                        $cms_post->post_type=1;
                                        $cms_post->post_lang=1;
                                        $cms_post->post_status=1;
                                        $cms_post->post_author_id=1;
                                        $cms_post->deleted_flag=0;
                                        $cms_post->archive_flag=0;
                                        $cms_post->post_categury=$request['postCategury'];
                                        $cms_post->post_content=$request['postContent'];
                                        $cms_post->save();

                                        $tableStatus = \DB::select("show table status from  ratis_cms where Name = 'cms_posts'");
                                        if (empty($tableStatus)) {
                                            throw new \Exception("Table not found");
                                        }
                                        $postID= $tableStatus[0]->Auto_increment-1;
                                        $this->updateMetaTable_Tags($postID,$request['tags']);
                                        return 1;
                                    }
                                    catch (\Exception $e)
                                    {
                                        return $e->getCode();
                                    }
                                }

                        }
                    }

                case 'pages':
                    {
                        switch ($postAction)
                        {
                            case 'edit':
                                {
                                    try{
                                        cms_post::where('id', '=', $request['postID'])
                                            ->update(array(
                                                'post_title' => $request['postTitle'] ,
                                                'post_content'=>$request['postContent'] ,
                                            ));
                                        return 1;
                                    }
                                    catch (\Exception $e)
                                    {
                                        return $e->getMessage();
                                    }

                                }
                        }
                    }
            }
        }


    }
}
