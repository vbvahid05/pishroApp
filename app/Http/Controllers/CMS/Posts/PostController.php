<?php

namespace App\Http\Controllers\CMS\Posts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function showAllPosts(Request $request, $postType)
    {
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
                ->where('posts.flag_delete','=',0)
                ->select(['*','posts.id as Postid'  ,'posts.created_at AS postsCreatedAt' ])
                ->orderby('Postid','DESC')
                ->get();
            //-----------
            return view('CMS/Posts/list/list',
                compact(
                    'local','postType' ,
                    'pageTitle' ,'pageIcon','dataList','temcat'
                ));
//        }
//        catch (\Exception $e)
//        {
//            return $e;
//
//        }
    }

//----------------------
    public  function  editPage(Request $request,$postType,$action)
    {

        $locale ='fa';
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
                ->where('lang.lang_title','=',$locale)
                ->where('postType.pst_typ_title','=',$postType)
                ->where('posts.flag_delete','=',0)
                ->orderby('Postid','DESC')
                ->get();
//            //----------------------------------
            $categuryList= \DB::table('cms_terms as terms')
            ->Join('cms_languages as language' ,'language.id','=','terms.trm_lang' )
            ->Join('cms_term_relations as relations' ,'relations.trmrel_term_id','=','terms.id' )
            ->where('language.lang_title','=',$locale)
            ->where('terms.trm_type','=',$postType)
            ->where('terms.deleted_flag','=',0)
            ->select(['*','relations.id as ItemID' ])
            ->get();
              //----------------------------------

            if (count($dataList)!=0 && $action=='edit') $hasValue=true; else $hasValue=false;
            return view('/CMS/Posts/page/page',
                compact(
                    'action','local','postId','postType' ,'pageTitle' ,'pageIcon',
                    'dataList','categuryList','hasValue'));
       }
        else if ('new')
        {
            $pageTitle=  \Lang::get('labels.new').' '.\Lang::get('labels.'.$postType);
            $pageIcon="fa fa-file-text-o";


            return view('/CMS/Posts/page/page',
                compact(
                    'action','local','postType' ,'pageTitle' ,'pageIcon'
                ));
         }
    }

//----------------------------------

}
