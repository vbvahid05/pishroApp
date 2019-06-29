<?php

namespace App\Http\Controllers\CMS\Categories;

use App\Model_admin\cms_language;
use App\Mylibrary\PublicClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Mylibrary\CMS\Category_Actions;

class CategoryController extends Controller
{
    public function loadPage(Request $request,$lang ,$postType,$term_ID=null)
    {
        $local=$lang;
        $pageTitle=  \Lang::get('labels.posts_cat').' '.\Lang::get('labels.'.$postType);
        $pageIcon="fa fa-file-text-o";

        $all_language = cms_language::all();


        return view('CMS/Categories/list/list',
            compact(
                'local','postType' ,'pageTitle' ,'pageIcon' ,'all_language','term_ID'
            ));
    }

    public  function CategoryServices(Request $request ,$function){
        $action=new Category_Actions();

        switch ($function){
            case 'showAllCategory_data':
                return $action->showAllCategories($request);
            break;
            case 'category_list':
                return $action->categoryListItems($request);
            break;
            case 'addNewCategory':
                return $action->addNewCategory($request);
            break;
            case 'get_category_list_by_Term_type':
                return $action->get_category_list_by_Term_type($request);
            break;
            case 'add_new_wCategory_Item':
                return $action->add_new_wCategory_Item($request);
            break;



        }
    }


}
