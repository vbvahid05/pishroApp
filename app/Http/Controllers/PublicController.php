<?php

namespace App\Http\Controllers;
use App\Mylibrary\PublicClass;
use Illuminate\Http\Request;
use App\User;

class PublicController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }
//---------------------------
    public static  function checkUserACL($action)
    {
        $userId=\Auth::user()->id;


        $result=  \DB::table('acl_user_role_actions AS user_role_actions')
            ->join('acl_roles AS roles', 'roles.id', '=', 'user_role_actions.ura_roleAction_id')
            ->join('acl_role_actions AS role_actions', 'role_actions.role_roleID', '=', 'user_role_actions.ura_roleAction_id')
            ->join('acl_actions AS actions', 'actions.id', '=', 'role_actions.role_Action_id')
            ->select(\DB::raw('
                            actions.actn_actn_slug AS actn_slug ,
                            actions.actn_title     AS    actn_title,
                            actions.id AS actn_id,
                            roles.role_title AS  role_title
                                '))
            ->where('user_role_actions.ura_user_id', '=', $userId)
            ->where('role_actions.deleted_flag', '=', 0)
            ->get();

        $flag=false;
        foreach ($result AS $URA)
        {
            if($URA->actn_slug == $action )   $flag=true;
        }
        return $flag;
    }
//---------------------------
    public static  function getUserACL($userId)
    {

       // $userId=\Auth::user()->id;
        $result=  \DB::table('acl_user_role_actions AS user_role_actions')
            ->join('acl_roles AS roles', 'roles.id', '=', 'user_role_actions.ura_roleAction_id')
            ->join('acl_role_actions AS role_actions', 'role_actions.role_roleID', '=', 'user_role_actions.ura_roleAction_id')
            ->join('acl_actions AS actions', 'actions.id', '=', 'role_actions.role_Action_id')
            ->select(\DB::raw('
                            actions.actn_actn_slug AS actn_slug ,
                            actions.actn_title     AS    actn_title,
                            actions.id AS actn_id,
                            roles.role_title AS  role_title
                                '))
            ->where('user_role_actions.ura_user_id', '=', $userId)
            ->get();
        return $result;

    }
//---------------------------

  function getAllData (request $request)
  {
      $data = $request->all();
      $Table= $data[0];
      $mode = $data[1];
      $publicClass= new PublicClass;
      $tableName = $publicClass->get_Table_Name($Table);

      return  \DB::table($tableName)
      ->where('deleted_flag', '=', $mode )
      ->orderBy('id', 'desc')
      ->get();
  }

  //---------------------------
  function Get_Count_Of_Rows (request $request)
  {
    $data = $request->all();
    $Table= $data["table"];
    $mode = $data["mode"];
    $key = $data["key"];
    $value=$data["value"];
    $publicClass= new PublicClass;
    $tableName = $publicClass->get_Table_Name($Table);
    //----


    $Pcount = \DB::table($tableName)
                ->where($key, $value)
                ->count();
    //----
    return $Pcount;

  }

//---------------------------
  function getAllData_select_one_fiald (request $request)
  {
      $data = $request->all();
      $Table= $data["t"];
      $mode = $data["mode"];
      $key = $data["key"];
      $value=$data["value"];
      $publicClass= new PublicClass;
      $tableName = $publicClass->get_Table_Name($Table);

      return  \DB::table($tableName)
      ->where($key, '=', $value )
      ->where('deleted_flag', '=', $mode )
      ->orderBy('id', 'desc')
      ->get();
  }

  function getAllData_select_two_fialds (request $request)
  {
      $data = $request->all();
      $Table= $data["t"];
      $mode = $data["mode"];
      $key = $data["key"];
      $value=$data["value"];
      $key2 = $data["key2"];
      $value2=$data["value2"];
      $publicClass= new PublicClass;
      $tableName = $publicClass->get_Table_Name($Table);

      return  \DB::table($tableName)
      ->where($key, '=', $value )
      ->where($key2, '=', $value2 )
      ->where('deleted_flag', '=', $mode )
      ->orderBy('id', 'desc')
      ->get();
  }

  function getAllData_select_three_fialds (request $request)
  {
      $data = $request->all();
      $Table= $data["t"];
      $mode = $data["mode"];
      $key = $data["key"];
      $value=$data["value"];
      $key2 = $data["key2"];
      $value2=$data["value2"];
      $key3 = $data["key3"];
      $value3=$data["value3"];
      $publicClass= new PublicClass;
      $tableName = $publicClass->get_Table_Name($Table);
      if ($mode !="val3Neg")
      {
        return  \DB::table($tableName)
        ->where($key, '=', $value )
        ->where($key2, '=', $value2 )
        ->where($key3, '=', $value3 )
        ->where('deleted_flag', '=', $mode )
        ->orderBy('id', 'desc')
        ->get();
      }
      else
      {
        return  \DB::table($tableName)
        ->where($key, '=', $value )
        ->where($key2, '=', $value2 )
        ->where($key3, '!=', $value3 )
        ->where('deleted_flag', '=', 0 )
        ->orderBy('id', 'desc')
        ->get();
      }

  }

  function moveToTrash (request $request)
  {
    $data = $request->all();
    $Table=  $data['table'];
    $row_id=  $data['selectesRowId'];
    $publicClass= new PublicClass;
    $tableName = $publicClass->get_Table_Name($Table);

    \DB::table($tableName)
              ->where('id', $row_id)
              ->update(['deleted_flag' => 1]); //delete Flag
  }



  function RestoreFromTrash  (request $request)
  {
    $data = $request->all();
    $Table=  $data['table'];
    $row_id=  $data['selectesRowId'];
    $publicClass= new PublicClass;
    $tableName = $publicClass->get_Table_Name($Table);

    \DB::table($tableName)
              ->where('id', $row_id)
              ->update(['deleted_flag' => 0]);
  }

  function UpdateOneRecord  (request $request)
  {
    $data = $request->all();
    $Table=  $data['table'];
    $rowTitle=$data['rowTitle'];
    $row_id=  $data['selectesRowId'];
    $row_new_value=$data['rowValue'];
    $publicClass= new PublicClass;
    $tableName = $publicClass->get_Table_Name($Table);

    \DB::table($tableName)
              ->where('id', $row_id)
              ->update([$rowTitle => $row_new_value]);
  }

    function UpdateOneRecordByanyRowId  (request $request)
    {
        $data = $request->all();
        $Table=  $data['table'];
        $whereRowID = $data['whereRowID'];
        $row_id=  $data['selectesRowId'];

        $whereRowID2 = $data['whereRowID2'];
        $row_id2=  $data['selectesRowId2'];

        $rowTitle=$data['rowTitle'];
        $row_new_value=$data['rowValue'];
        $publicClass= new PublicClass;
        $tableName = $publicClass->get_Table_Name($Table);

        \DB::table($tableName)
            ->where($whereRowID, $row_id)
            ->where($whereRowID2, $row_id2)
            ->update([$rowTitle => $row_new_value]);
    }

  function DeleteFromDB (request $request)
  {
    $data = $request->all();
    $Table=  $data['table'];
    $row_id=  $data['selectesRowId'];
    $publicClass= new PublicClass;
    $tableName = $publicClass->get_Table_Name($Table);

      \DB::table($tableName)
                ->where('id', '=', $row_id )
                ->delete();



  }

  function moveSelectedToTrash (request $request)
  {   $val="";
      $data = $request->all();
      $Table= $data[0];
      $publicClass= new PublicClass;
      $tableName = $publicClass->get_Table_Name($Table);
      $array_Lenght=count($data);
      //for ($i=1;$i<= $array_Lenght;$i++)
      foreach($data as $d)
        {
          \DB::table($tableName)
                    ->where('id', $d)
                    ->update(['deleted_flag' => 1]);
        }
      return $val;
  }

  function RestoreSelectedFromTrash (request $request)
  {   $val="";
      $data = $request->all();
      $Table= $data[0];
      $publicClass= new PublicClass;
      $tableName = $publicClass->get_Table_Name($Table);
      $array_Lenght=count($data);
      //for ($i=1;$i<= $array_Lenght;$i++)
      foreach($data as $d)
        {
          \DB::table($tableName)
                    ->where('id', $d)
                    ->update(['deleted_flag' => 1]);
        }
      return $val;
  }

  function RestoreGroupFromTrash (request $request)
  {   $val="";
      $data = $request->all();
      $Table= $data[0];
      $publicClass= new PublicClass;
      $tableName = $publicClass->get_Table_Name($Table);
      $array_Lenght=count($data);
      //for ($i=1;$i<= $array_Lenght;$i++)
      foreach($data as $d)
        {
          \DB::table($tableName)
                    ->where('id', $d)
                    ->update(['deleted_flag' => 0]);
        }
      return $val;
  }

  function FullDeleteSelectedItems (request $request)
  {   $val="";
      $data = $request->all();
      $Table= $data[0];
      $publicClass= new PublicClass;
      $tableName = $publicClass->get_Table_Name($Table);
      $array_Lenght=count($data);
      //for ($i=1;$i<= $array_Lenght;$i++)
      foreach($data as $d)
        {
          \DB::table($tableName)
                    ->where('id', $d)
                    ->delete();
        }
      return $val;
  }


  function ShowCalender (request $request)
  {
    $Jalali_cal=array();
    //----Jalali----
    $days=array('-');
    for($i=1;$i<=31;$i++)
    array_push($days,$i);
    //-----------------------
    $Months=array('-');
    for($i=1;$i<=12;$i++)
    array_push($Months,$i);
    //-----------------------
    $Years=array();
    for($i=1390;$i<=1410;$i++)
    array_push($Years,$i);
    //----
    array_push($Jalali_cal,$days,$Months,$Years);
    return $Jalali_cal;

    //return $days;
 //var_dump($Jalali_cal);





  }
public static  function CurencySeprator($currency)
{
    $array = str_split($currency) ;
    $arrayCount= count($array);
    $resNumber="";
    $j=0;
    if ($arrayCount<=3) $flag=0;
    else if ($arrayCount >3 && $arrayCount<=6) $flag=1;
    else if ($arrayCount >6 && $arrayCount<=9 ) $flag=2;
    else if ($arrayCount >9 && $arrayCount<=12 ) $flag=3;
    else if ($arrayCount >12 && $arrayCount<=15 ) $flag=4;
    else if ($arrayCount >15 && $arrayCount<=18 ) $flag=5;
    for ($i=$arrayCount-1 ;$i>=0;$i--)
    {
        $j++;
        $resNumber=$array[$i].$resNumber;
        if ($j==3 && $flag !=0)
        {
            $resNumber=','.$resNumber;
            $flag--;
            $j=0;
        }
//        if ($j==3 && $array[$i].$resNumber !='' ) { //&& $flag >1
//            $j=0;
//            $resNumber=','.$resNumber;
////            $flag--;
//        }
    }
    return $resNumber;
}


    public static function userSettings(request $request,$function)
    {
        switch ($function)
        {
            case 'changePassword' :
                if (isset($request['userID']))
                {
                     $UID= $request['userID']  ;
                }
                else
                {
                    $UID = \Auth::id();
                }
                $userPassword= \Hash::make($request['password']);
                if (User::where('id', '=', $UID)
                       ->update(array('password' => $userPassword)))
                    return $UID.'/'.$request['password'];
                else
                    return 0;
            break;
        }
    }



}
