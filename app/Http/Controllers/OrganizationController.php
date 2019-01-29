<?php

namespace App\Http\Controllers;
//>>>>>>>>>>>> Model
use App\Custommer;
use App\Custommerorganization;

use Illuminate\Http\Request;
use App\Mylibrary\PublicClass;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }

    public function get_organizations_info()
    {
      $val=Custommer::orderBy('id', 'desc')->all();
       return $val;
    }


      public function insert_new_Org (Request $request)
      {
          $data = $request->all();
          $org_name= $data['org_name'];
          $count = \DB::table('custommerorganizations')
             ->where('org_name', $org_name)
             ->count();
          if ($count>=1)
              return "100";
          else
          {
              try {
                  $org = new Custommerorganization;
                  $org->org_name = $request->org_name;
                  $org->org_codeeghtesadi = $request->org_codeeghtesadi;
                  $org->org_tel = $request->org_tel;
                  $org->org_address = $request->org_address;
                  $org->org_postalCode = $request->org_postalCode;
                  $org->deleted_flag = 0;
                  $org->archive_flag = 0;
                  $org->org_deleted = 0;
                  $org->save();
                  // LOG1
                  $string = "/custommer >CustommerOrganization |" . "addNewOrganization() | " . "new-ORG:" . $org->org_name . '|' . $org->org_tel;
                  $add_log = new PublicClass();
                  $add_log->add_user_log($string, "OK", Auth::user()->id);
                  return 'ok' ;
              }
              catch (\Exception $e)
              {
                  // LOG
                  $string = "/custommer>CustommerOrganization|" . "addNewOrganization() | " . "new-ORG " . $ex->getMessage();
                  $add_log = new PublicClass();
                  $add_log->add_user_log($string, "FAILD", Auth::user()->id);
                  return 'error';
              }
          }
      }


   public function UpdateOrg (Request $request)
   {
       $data = $request->all();
        $orgID= $data['orgID'];
        $org_name = $data['org_name'];
        $org_codeeghtesadi = $data['org_codeeghtesadi'];
        $org_tel = $data['org_tel'];
        $org_postalCode= $data['org_postalCode'];
        $org_address= $data['org_address'];
    try
    {
        $updateStep1 = \DB::table('custommerorganizations')
            ->where('id', $orgID)
            ->update(['org_name' => $org_name ,
                      'org_tel' => $org_tel ,
                      'org_address' => $org_address,
                      'org_postalCode' => $org_postalCode,
                      'org_codeeghtesadi' => $org_codeeghtesadi

            ]);
    return 1;
    }
    catch (\Exception $e)
    {
        return $e->getMessage();
    }


   }


    public function showAllOrg ()
    {
      $val = \DB::table('custommerorganizations')
        ->select('*')
        ->where('deleted_flag', 0)
        ->orderBy('id', 'desc')
      ->get();
      return $val;
    }

    public function showAllPostinORG ()
    {
      $val = \DB::table('custommerorganizations_semat')
        ->select('*')
        //->where('ctm_org_semat_details', '=', 0)
          ->orderBy('id', 'desc')
          ->get();
      return $val;
    }

//-----------

    public function trashAction (Request $request)
    {
        $data = $request->all();
        $orgID= $data['orgID'];
        $action= $data['Action'];


        switch ($action)
        {
           case 'del':
               {
                   $count = \DB::table('custommers')
                       ->where('cstmr_organization', $orgID)
                       ->count();
                   if ( $count==0) //
                   {
                       try
                       {
                           $updateStep1 = \DB::table('custommerorganizations')
                               ->where('id', $orgID)
                               ->update(['deleted_flag' => 1 ,
                                   'org_deleted' => 1
                               ]);
                           return 1;
                       }
                       catch (\Exception $e)
                       {
                           return $e->getMessage();
                       }
                   }
                   else
                       return 'InUseId';
               }
           break;
          //.............
           case 'reStore':
               {
                   try
                   {
                       $updateStep1 = \DB::table('custommerorganizations')
                           ->where('id', $orgID)
                           ->update(['deleted_flag' => 0 ,
                               'org_deleted' => 0
                           ]);
                       return 1;
                   }
                   catch (\Exception $e)
                   {
                       return $e->getMessage();
                   }
               }
           break;
          //.............
            case 'hardDel':
                {
                    try
                    {
                        Custommerorganization::destroy($orgID);
                    }
                    catch (\Exception $e)
                    {
                        return $e->getMessage();
                    }
                }
            break;


        }
    }

}
