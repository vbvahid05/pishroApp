<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 26/09/2018
 * Time: 02:46 PM
 */

namespace App\Mylibrary\setting;


use App\acl_action;
use App\acl_role;
use App\acl_roleAction;
use App\acl_userRoleAction;
use App\User;



class SettingUserClass
{
    function get_ACL_All_Actions()
    {
        return acl_action::all();
    }
//------------------------------------------
    function  get_ACL_All_roles()
    {

        return acl_role::all();

    }
//-------------------------------------------
    function get_ACL_AllActionsAndSelectedActions($value)
    {
//      $acl_actionList= acl_action::all();
        $acl_actionList=acl_action::orderBy('actn_actn_slug')->get();
      $selectedActions=\DB::table('acl_role_actions')
            ->where('role_roleID', '=', $value )
            ->where('deleted_flag', '=', 0 )
            ->orderBy('id', 'desc')
            ->get();
        $r="";
        $Data_array=array();
      foreach ($acl_actionList AS $aclAL)
      {
          $SelectFlag=0;
          foreach ( $selectedActions AS $AVLAL)
          {
              if ($aclAL['id'] == $AVLAL->role_Action_id)
              {
                  $SelectFlag = 1;
              }
          }
           $actionArray= array(
                'id' =>$aclAL['id'],
                'actionTitle' =>$aclAL['actn_title'],
                'actionSlug' =>$aclAL['actn_actn_slug'],
                'Selected' =>$SelectFlag,
            );
              array_push($Data_array,$actionArray);
      }
      return $Data_array;
    }

//-------------------------------------------

    function saveRoleActionCheckList ($request)
    {
        $data=$request->all();
        $actionArray = $data['actionArray'];
        $roleID =$data['roleID'];

        $roleActionInDB =acl_roleAction::where('role_roleID', $roleID)->get();
        $roleActionInDBCount=count($roleActionInDB)-1;
        $string="New Added: ";
        $ArrayValue=array();
        //--------------------------
        foreach ($actionArray as $AA)
        {
            $flag=false;
            for ($i=0;$i<=$roleActionInDBCount ;$i++)
            {
                if ($AA == $roleActionInDB[$i]['role_Action_id'] && $flag !=true)
                    $a=true;
            }

            if ($flag==false)
            {
                array_push($ArrayValue,$AA);
                return $AA.' is New & add MUST be to DB';
            }
        }


         //return $ArrayValue;
        //--------------------------
//        foreach ($roleActionInDB AS $rAiD)
//        {
////            $string=$string.'-'.$rAiD['role_Action_id'];
//            $flag=false;
//            for ($j=0;$j<=count($ArrayValue)-1 ;$j++ )
//            {
//                if ($rAiD['role_Action_id'] !=$AA[$j] && $flag !=true )
//
//            }
//
//        }

    }
//-----------------------
//
    function CheckRoleAction($request)
    {
        $data=$request->all();
         $count = acl_roleAction::where('role_roleID', '=', $data['roleID'])
                                  ->where('role_Action_id', '=', $data['actionID'])
                                  ->count();
         // Do uncheck , remove Action Row
         if ($count ==1)
         {
               $row= acl_roleAction::where('role_roleID', '=', $data['roleID'])
                     ->where('role_Action_id', '=', $data['actionID'])
                     ->firstOrFail();
               //-----------------------------
               //Toggle Status
               if ($row->deleted_flag ==1)
               {
                   return acl_roleAction::where('role_roleID', '=', $data['roleID'])
                       ->where('role_Action_id', '=', $data['actionID'])
                       ->update(array('deleted_flag' => 0));
               }
               else
               {
                   return acl_roleAction::where('role_roleID', '=', $data['roleID'])
                       ->where('role_Action_id', '=', $data['actionID'])
                       ->update(array('deleted_flag' => 1));
               }
         }
         // Check  Add new Action Row
         else
         {
             $acl_roleAction = new acl_roleAction;
             $acl_roleAction->role_roleID = $data['roleID'];
             $acl_roleAction->role_Action_id = $data['actionID'];
             $acl_roleAction->role_details = ' ';
             $acl_roleAction->deleted_flag = 0;
             $acl_roleAction->archive_flag = 0;
             $acl_roleAction->save();
             return 'new Added';
         }

    }
//-----------------------------------------------

    function getAllUserRoles($request)
    {
        $data=$request->all();

        return  $val = \DB::table('acl_user_role_actions AS user_role_actions')
            ->join('users AS user', 'user.id', '=','user_role_actions.ura_user_id')
            ->join('acl_roles AS roles', 'roles.id', '=','user_role_actions.ura_roleAction_id')
            ->where('user_role_actions.deleted_flag', '=', 0)
            //->select('*')
            ->select('*', \DB::raw('user_role_actions.id AS userRoleActionID ,user.id AS userID'))
             ->orderBy('user.id', 'desc')
            //->paginate(15);
            ->get();
    }

//-----------------------------------------------
    function addNewRole($request)
    {
        $data=$request->all();
        $Role_name =  $data['Role_name'];
        $Role_Slug =  $data['Role_Slug'];

        $role = new acl_role;
        $role->role_title =$Role_name;
        $role->role_slug =$Role_Slug;
        $role->role_details = "";
        $role->deleted_flag =0;
        $role->archive_flag = 0;
        $role->save();
    }
//-----------------------------------------------
    function DeleteRole($request)
    {
        $data=$request->all();
        $Role_id =  $data['Role_id'];

        $count = acl_userRoleAction::where('ura_roleAction_id', '=', $Role_id)->count();

        if ($count==0) //Role Action Not in Use
        {
            $countRoleAction = acl_roleAction::where('role_roleID', '=', $Role_id)->count();
            if ($countRoleAction)
            {
                acl_roleAction::
                where('role_roleID', $Role_id)
                    ->delete();
                acl_role::destroy($Role_id);
                return 1;
            }
            else
            {
                acl_role::destroy($Role_id);
                return 1;
            }
        }
        else
            return 0;







    }
//-----------------------------------------------
    function editUserRole($request)
    {
        $data=$request->all();

        $userID =  $data['userID'];
        $selValue =  $data['selValue'];
        $customeroleTitle = $data['customeroleTitle'];
        return acl_userRoleAction::where('ura_user_id', '=',$userID)
            ->update(array('ura_roleAction_id' => $selValue , 'ura_details'=>$customeroleTitle));

    }
//-----------------------------------------------
//-----------------------------------------------
    function AddnewUser($request)
    {
        $next=0;
        $data=$request->all();
        $username   =  $data['username'];
        $usernameID =  $data['usernameID'];
        $roleID     =  $data['roleid'];
        $password   =  $data['password'];
        $count = User::where('email', '=', $usernameID)->count();
        if ($count==0)
        {
            try
            {
//                $obj_user = User::find($user_id);
//                $obj_user->password = \Hash::make($newPassword);;
                //if ( $obj_user->save())


                $user=new User;
                $user->name=$username;
                $user->email=$usernameID;
                $user->password= \Hash::make($password);

                if ($user->save()) $next= 1;
                else return 0;
                if ($next)
                {
                    $user =User::where('email', '=', $usernameID)->firstOrFail();
                    $userID= $user->id;

                    $userRlAC=new acl_userRoleAction;
                    $userRlAC->ura_user_id=$userID;
                    $userRlAC->ura_roleAction_id=$roleID;
                    $userRlAC->ura_details='کاربر سایت';
                    $userRlAC->deleted_flag=0;
                    $userRlAC->archive_flag=0;

                    if ($userRlAC->save()) return 'User Successfully Added';

                }
            }
            catch (\Exception $e)
            {
                return $e->getMessage();
            }
        }
        else
            return 'duplicated';


    }


    public function  set_user_delete($request)
    {
        $data=$request->all();

        $RowID   =  $data['userActionRoleID'];
        if (acl_userRoleAction::where('id', '=', $RowID) ->update(array('deleted_flag' => 1)))
            return 1;
                else return 0;

    }
//-----------------------------------------------
}