<?php

namespace App\Http\Controllers\SiteAPI;

use App\Model_admin\cms_post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($local,$slug)
    {
        if ($local=='fa')
            $lang=1;

        return $val= \DB::table('cms_posts AS posts')
              ->join('cms_post_metas  AS metas'   ,   'metas.pst_meta_post_id' , '=' ,'posts.id')
              ->join('cms_media_centers  AS media_center'   ,   'media_center.id' , '=' ,'metas.pst_meta_value')
//            ->join('cms_post_types  AS  post_types'   ,   'post_types.id' , '=' ,'posts.post_type')
//            ->join('cms_languages  AS  languages'   ,   'languages.id' , '=' ,'posts.post_lang')

            ->where('posts.post_slug'   , '=', $slug)
            ->where('metas.pst_meta_key'   , '=', '_postImage')


            ->select(  \DB::raw('
                              posts.post_title AS post_title,
                              posts.post_status AS   post_status,
                              posts.post_content AS   post_content,
                              posts.created_at AS     created_at,
                              media_center.id AS postimageID,
                              media_center.mdiac_filename AS postimage
                            '))
            ->get();

//        return   cms_post::where('post_lang', '=', $lang)
//                         ->where('post_slug', '=', $slug)
//                        ->firstOrFail();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
