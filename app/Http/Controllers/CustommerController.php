<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//>>>>>>>>>>>> Model
use App\Custommer;
use App\Custommerorganization;

use App\Mylibrary\CustommersClass;
use App\Mylibrary\OrganizationClass;

class CustommerController extends Controller
{
    public function __construct()
    {
        if ( $this->middleware('auth')) return "OK";
        else return view('/login');
    }
    //
  /*  public function home()
    {
      $FmyFunctions1 = new CustommersClass;
      return $FmyFunctions1->showCustommer();
    }
*/

    public function showallallcustommers()
    {
    $organizationclass= new OrganizationClass;
    $custommer_post_title= $organizationclass->get_post_in_organizations_info();
     $val="1";
     return view('custommers/all-custommers',compact('val','custommer_post_title'));
    }

    public function showAllOrgsPage()
    {
        return view('custommers/all_Orgs');
    }

    public function ShowAllOrgData(Request $request)
    {
        $data = $request->all();
        $mode= $data['mode'];
        $organizations= new OrganizationClass;
        return   $organizations->get_organizations_info($mode);
    }

    public function show_all_custommers_NullORG()
    {
        $customerclass= new CustommersClass;
        return   $customerclass->show_all_custommers_NullORG();
    }

    public function showAll ()
    {
    //  return Custommerorganization::all();
        $customerclass= new CustommersClass;
        return   $customerclass->showAllCustommers(0);
    }
    public function showAllTrashed ()
    {
        $customerclass= new CustommersClass;
        return   $customerclass->showAllCustommers(1);
    }

    public function newcustommer()
    {
      $organizationclass= new OrganizationClass;
      $organization_info=  $organizationclass->get_organizations_info(0);
      //$organization_info = \DB::table('Custommerorganizations')->get();
      $custommer_post_title= $organizationclass->get_post_in_organizations_info();
      return view('custommers/custommer', compact('organization_info','custommer_post_title'));
    }
//---------------------------------------------
    public function editcustommer($userid)
    {
        $organizationclass= new OrganizationClass;
        $organization_info=  $organizationclass->get_organizations_info(0);
        $custommer_post_title= $organizationclass->get_post_in_organizations_info();

        $customerclass= new CustommersClass;
        $customer_info= $customerclass->showCustommer($userid);
       //$val=$userid;
      return view('custommers/custommer', compact('customer_info','organization_info','custommer_post_title'));
    }

//----------------------------------------------
public function updateCustommerInfo(Request $request)
{
    $customerclass= new CustommersClass;
    if ($customerclass->updateCustommerInfo($request))
    return 1;
}


//---------------------------------------------
    public function organization_list()
    {
      /*  $customerclass= new CustommersClass;
        $customer_info= $customerclass->showCustommer($userid);
        */
       //$val=$userid;
       $organization_info = array("org1"=>"0", "org2"=>"1");
      return view('custommers/custommer', compact('organization_info'));
    }

//----------------------------------------------
public function addNewPerson(Request $req)
{


  $customerclass= new CustommersClass;
  $val=$customerclass->addNewPerson($req);
  return $val;
}


  public function update_form(Request $req)
  {
    $customerclass= new CustommersClass;
    if ($customerclass->update_data_in_custommer_table($req))
        return Redirect ('/all-custommers');
  }

    public function insert_form(Request $request)
    {
      $customerclass= new CustommersClass;
      if ($customerclass->Add_new_in_custommer_table($request))
          return Redirect ('/all-custommers');
    }

    public function  moveCustommerToTrash (Request $request)
    {
         $customerclass= new CustommersClass;
        return  $customerclass->moveCustommerToTrashMethod($request);
    }

    public function    moveSelectedCustommerToTrash (Request $request)
    {
       $customerclass= new CustommersClass;
       $customerclass-> mmoveSelectedCustommerToTrashMethod($request);
    }

    public function    CustommerRestoreFromTrash (Request $request)
    {
       $customerclass= new CustommersClass;
       $customerclass-> CustommerRestoreFromTrash_Method($request);
    }

    public function    CustommerfullDelete (Request $request)
    {
       $customerclass= new CustommersClass;
       $customerclass-> CustommerfullDelete_Method($request);
    }




}
