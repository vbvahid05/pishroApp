<?php

namespace App\Http\Controllers\setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mylibrary\setting\SettingUserClass;
use  App\User;

class SettingController extends Controller
{
    public function dotest()
    {
// 1 )
//         $page = file_get_contents('http://localhost/MTT/export_results.html');
//        print_r (explode(" ",$page));

// 2)
//        $url = "http://localhost/MTT/export_results.html";
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: graph.facebook.com'));
//
//          $output = curl_exec($ch);
//         $rr= (explode('<div class="value bold">',$output));
//         echo $rr[1];
//        curl_close($ch);



// 3)
//        $html = file_get_contents('http://localhost/MTT/export_results.html');
//        $dom = new DOMDocument;
//        @$dom->loadHTML($html);
//
////Get all links. You could also use any other tag name here,
////like 'img' or 'table', to extract other tags.
//        $links = $dom->getElementsByTagName('a');
////Iterate over the extracted links and display their URLs
//        foreach ($links as $link){
//            //Extract and show the "href" attribute.
//            echo $link->nodeValue;
//            echo $link->getAttribute('href'), '<br>';
//        }

// 4)

        $dom = new DOMDocument;
    }

    function changePassword()
    {
        $user_id =6;$newPassword='123456';
//     $user_id = \Auth::User()->id;
        $obj_user = User::find($user_id);
        $obj_user->password = \Hash::make($newPassword);;

        if ( $obj_user->save())
            return 'changed';
        else
            'Faild...';
    }


    public function manageRequest(request $request, $controller,$function,$value=null)
    {
        switch ($controller)
        {
            case 'user' :
                    switch ($function)
                    {
                        case 'getAllActions':
                            $data= new SettingUserClass;
                            return $data->get_ACL_All_Actions();
                        break;
                        case 'getAllRoles':
                            $data= new SettingUserClass;
                            return $data->get_ACL_All_roles();
                        break;
                        case 'getAllActionsAndSelectedActions':
                            $data= new SettingUserClass;
                            return $data->get_ACL_AllActionsAndSelectedActions($value);
                            break;
                        case 'saveRoleActionCheckList':
                            $data= new SettingUserClass;
                            return $data->saveRoleActionCheckList($request);
                            break;

                        case 'CheckRoleAction':
                            $data= new SettingUserClass;
                            return $data->CheckRoleAction($request);
                            break;

                        case 'getAllUserRoles':
                            $data= new SettingUserClass;
                            return $data->getAllUserRoles($request);
                            break;

                             case 'addNewRole':
                            $data= new SettingUserClass;
                            return $data->addNewRole($request);
                            break;

                        case 'DeleteRole':
                            $data= new SettingUserClass;
                            return $data->DeleteRole($request);
                            break;

                        case 'editUserRole':
                            $data= new SettingUserClass;
                            return $data->editUserRole($request);
                            break;

                        case 'AddnewUser':
                            $data= new SettingUserClass;
                            return $data->AddnewUser($request);
                            break;

                        case 'set_user_delete':
                            $data= new SettingUserClass;
                            return $data->set_user_delete($request);
                            break;
                    }

            break;
        }


        return $req=$controller.$function;
    }
}
