<?php
/**
 * Created by PhpStorm.
 * User: vahid
 * Date: 23/06/2019
 * Time: 04:28 PM
 */

namespace App\Mylibrary\CMS;
use App\Model_admin\cms_language;
use App\Model_admin\cms_term;
use App\Model_admin\cms_term_relation;
use App\Mylibrary\PublicClass;
class Category_Actions
{
    public function get_category_list_by_Term_type($arguments){
        $local= $arguments['local'];
        $TermType= $arguments['postType'];
       return     $term= \DB::table('cms_terms as  terms')
                ->Join('cms_languages as lang' ,'lang.id','=','terms.trm_lang' )
                ->where('lang.lang_title','=',$local)
                ->where('terms.trm_type','=',$TermType)
                ->select(\DB::raw('
                                terms.id AS termID ,                            
                                terms.trm_title   AS  termTitle
                                    '))
                ->get();
    }

    public function showAllCategories($arguments){
        $local= $arguments['local'];
        $postType= $arguments['postType'];
        $termId =$arguments['termId'];
              $term= \DB::table('cms_terms as  terms')
            ->Join('cms_languages as lang' ,'lang.id','=','terms.trm_lang' )
            ->where('lang.lang_title','=',$local)
            ->where('terms.trm_type','=',$postType)
            ->where('terms.id','=',$termId)
            ->select(['terms.id as termId' ])
           ->get();


        $termArray=[];
        foreach ($term AS $tr){
            $term= \DB::table('cms_term_relations as  term_relations')
                ->where('term_relations.trmrel_term_id','=',$tr->termId)
//                ->where('term_relations.trmrel_parent','=',0)
                ->select(['*' ,'term_relations.id AS ItemID'])
            ->get();
            array_push($termArray,$term);
        }

        $render= new PublicClass();

        $result=[];
        foreach ($termArray  as $trAry) {
            $level=0;
            $res_render=$render->renderMenuAsList($trAry ,$level);
            array_push($result,$res_render );
        }
        return $result;
    }

    public function categoryListItems($arguments){
        $resultArray=[];
        $local= $arguments['local'];
        $postType= $arguments['postType'];
        $term_id= $arguments['term_id'];

        $term= \DB::table('cms_terms as  terms')
            ->Join('cms_languages as lang' ,'lang.id','=','terms.trm_lang' )
            ->Join('cms_term_relations as term_relations' ,'term_relations.trmrel_term_id','=','terms.id' )
            ->where('lang.lang_title','=',$local)
            ->where('terms.trm_type','=',$postType)
            ->where('terms.id','=',$term_id)

          ->select('*', \DB::raw('
                            terms.id AS termID ,
                            term_relations.id   AS  ItemID,
                            term_relations.trmrel_title   AS  termRelTitle
                                '))
            ->get();
                array_push($resultArray ,array("termID"=>$term[0]->termID));
                $publicClass= new PublicClass();
                array_push($resultArray ,array("list"=>$publicClass->DropDownList($term ,0,0,0)));
                return $resultArray;
    }

    public function addNewCategory($arguments){
        $termID= $arguments['termID'];
        $newCatName= $arguments['newCatName'];
        $newCatSlug= $arguments['newCatSlug'];
        $newCatParent= $arguments['newCatParent'];


        $term_relation = new cms_term_relation;
        $term_relation->trmrel_term_id = $termID;
        $term_relation->trmrel_title = $newCatName;
        $term_relation->trmrel_slug = $newCatSlug;
        $term_relation->trmrel_action = 2;
        $term_relation->trmrel_parent = $newCatParent;
        $term_relation->deleted_flag = 0;
        $term_relation->archive_flag = 0;


      if( $term_relation->save())
          return 1;

    }


    public function add_new_wCategory_Item($arguments){
       $local=          $arguments['local'];
       $postType=       $arguments['postType'];
       $newCategoryName=$arguments['newCategoryName'];

       $lang= cms_language::where('lang_title', '=', $local)->firstOrFail();
       $lang_ID= $lang['id'];

        $cms_terms = new cms_term;
        $cms_terms->trm_type = $postType;
        $cms_terms->trm_title = $newCategoryName;
        $cms_terms->trm_slug = $newCategoryName;
        $cms_terms->trm_parent = 0;
        $cms_terms->trm_lang = $lang_ID;
        $cms_terms->trm_permission = 0;
        $cms_terms->trm_public_name = $newCategoryName;
        $cms_terms->deleted_flag = 0;
        $cms_terms->archive_flag = 0;
        if ($cms_terms->save())
            return $cms_terms->id;
        else
            return 0;

    }

}