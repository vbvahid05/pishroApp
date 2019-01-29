<?php
namespace App\Mylibrary;
//>>>>>>>>>>>> Model
use App\Custommer;
use App\sell_invoice;
use App\sell_stockrequest;
use Illuminate\Support\Facades\Auth;
use App\Mylibrary\PublicClass;


class CustommersClass
{

  public static function showCustommer($userid)
  {
      return   $custommer= \DB::table('custommers')
          ->join('custommerorganizations', 'custommers.cstmr_organization', '=','custommerorganizations.id')
          ->where('custommers.id', '=',$userid)
          ->select('*', \DB::raw('custommers.id AS id ,
                        custommerorganizations.id AS org_is         
          '))
          ->get();

//
//    $custommer = \DB::table('custommers')->where('id', '=',$userid)->get();
//    return   $custommer;
  }

public static function showAllCustommers($action)
{
  $val = \DB::table('custommers')
  ->join('custommerorganizations', 'custommers.cstmr_organization', '=','custommerorganizations.id')
  ->join('custommerorganizations_semat', 'custommers.cstmr_post', '=','custommerorganizations_semat.id')
  ->where('custommers.cstmr_detials', '=', $action)
  //->select('*')
  ->select('*', \DB::raw('custommers.id AS custommersID '))
  ->orderBy('custommers.id', 'desc')
  //->paginate(15);
  ->get();
  return $val;
}

public static function show_all_custommers_NullORG()
{
  $val = \DB::table('custommers')
  ->where('custommers.cstmr_detials', '=',0 )
  ->where('custommers.cstmr_organization', '=',1 )
  ->orderBy('custommers.id', 'desc')
  ->get();
  return $val;
}

//----------------------
    public static function moveCustommerToTrashMethod ( $request)
    {
        $data = $request->all(); // This will get all the request data.
        $userID= $data['customerIdSelect'];
        $count_invoice = sell_invoice::where('si_custommer_id', '=', $userID)->count();
        $count_stockrequest = sell_stockrequest::where('sel_sr_custommer_id', '=', $userID)->count();

        if ($data['actionToken']==0)
        {\DB::table('custommers')
            ->where('id', $data['customerIdSelect'])
            ->update(['cstmr_detials' =>0]); //delete Flag
            return 2;
        }

        if ($count_invoice==0 && $count_stockrequest==0)
        {
            if ($data['actionToken']==1)
            {\DB::table('custommers')
                ->where('id', $data['customerIdSelect'])
                ->update(['cstmr_detials' =>1]); //delete Flag
            }

            if ($data['actionToken']==3)
            {
                \DB::table('custommers')
                    ->where('id', '=', $data['customerIdSelect'])->delete();
            }
            return "1";
        }
        else
        {
            if ($count_invoice !=0)
                return  "-1";
            else if ($count_stockrequest !=0)
                return  "-2";
            else if ($count_invoice !=0 && $count_stockrequest !=0)
                return "-3";
        }
    }
//----------------------
public static function mmoveSelectedCustommerToTrashMethod ( $request)
{
    $data = $request->all();
    foreach ($data as $id )
    {
      \DB::table('custommers')
      ->where('id', $id)
      ->update(['cstmr_detials' => 1]); //delete Flag
    }
}

public static function CustommerRestoreFromTrash_Method ( $request)
{
    $data = $request->all();
    foreach ($data as $id )
    {
      \DB::table('custommers')
      ->where('id', $id)
      ->update(['cstmr_detials' => 0]); //delete Flag
    }
}

public static function CustommerfullDelete_Method ( $request)
{
    $data = $request->all();
    foreach ($data as $id )
    {
      \DB::table('custommers')
      ->where('id', '=', $id )->delete();
    }
}

public static function addNewPerson($request)
  {
    $val= new Custommer ($request->all());

//    $count = \App\Custommer::where(['cstmr_Mobiletel' =>$request->custommer_Mobile ])->count();
//    if ($count>=1)
//      return "100";
//
//    else
//    {
        try
        {
            $val->cstmr_name =$request->custommer_first_name;
            $val->cstmr_family =$request->custommer_last_name;
            $val->cstmr_codeghtesadi =$request->custommer_codeMelli;
            $val->cstmr_tel =$request->custommer_tel;
            $val->cstmr_Mobiletel =$request->custommer_Mobile;
            $val->cstmr_email =$request->custommer_email;
            $val->cstmr_postalcode =$request->custommer_postalcode;
            $val->cstmr_address =$request->custommer_address;
            $val->cstmr_organization=1; //Not defined
            $val->cstmr_post=1; //Not defined
            $val->cstmr_detials =0; // Avalebel
            $val->deleted_flag=0;
            $val->archive_flag=0;
            $val->save();
            // LOG1
            $string="/custommer |"."addNewPerson() | "."new-Person:".$val->cstmr_name.'|'. $val->cstmr_family;
            $add_log= new PublicClass();
            $add_log->add_user_log($string,"OK",Auth::user()->id);
        }
         catch (\Exception $ex)
         {
             // LOG
             $string="/custommer|"."addNewPerson() | "."new-Person ".$ex->getMessage();
             $add_log= new PublicClass();
             $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
         }
   //  }
  }

public static function update_data_in_custommer_table($req)
  {

      $validatedData = $req->validate([
          'first_name' => 'required',
          'last_name' => 'required',
          'custommer_email' => 'nullable|email',
          'custommerTel' => 'nullable|numeric|digits_between:10,15',
          'custommer_postalcode' => 'nullable|numeric',
          'custommer_codeghtesadi'=>'nullable|digits_between:10,15',

      ]);
       $cmID=  $req->custommerID;
       try
       {
           $val = Custommer::where('id', $cmID)->first();
           $val->cstmr_name =$req->first_name;
           $val->cstmr_family =$req->last_name;
           $val->cstmr_organization=$req->custommer_organization;
           $val->cstmr_post=$req->custommer_post_in_organization;
           $val->cstmr_tel =$req->custommerTel;
           $val->cstmr_Mobiletel =$req->custommer_Mobiletel;
           $val->cstmr_email =$req->custommer_email;
           $val->cstmr_postalcode =$req->custommer_postalcode;
           $val->cstmr_address =$req->custommer_address;
           $val->cstmr_codeghtesadi =$req->custommer_codeghtesadi;
           $val->cstmr_detials =$req->custommer_detials;
           $val->save();
           //Log
           $string="/custommer/{id} |"."submit | "."Update Person, id: ".$cmID.'|'. $val->cstmr_name. $val->cstmr_family;
           $add_log= new PublicClass();
           $add_log->add_user_log($string,"OK",Auth::user()->id);
           //---
           return true;
       }
       catch (\Exception $e)
       {
           // LOG
           $string="/custommer/{id} |"."submit | "."Update Person ".$e->getMessage();
           $add_log= new PublicClass();
           $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
       }



      }

      public static function updateCustommerInfo($req)
        {
          $cmID=  $req->custommerInfo_custommerid;
          try
          {
              $val = Custommer::where('id', $cmID)->first();
              $val->cstmr_organization =$req->custommerInfo_custommerOrgId;
              $val->cstmr_post =$req->custommerInfo_postInOrg;
              $val->cstmr_dakheli =$req->custommerInfo_tel_inOrg;
              $val->cstmr_desc =$req->custommerInfo_desc;
              $val->save();
              //log
              $string="/custommer |"."updateCustommerInfo() | "."assign custommer to org:".$val->cstmr_organization.'|'.$cmID;
              $add_log= new PublicClass();
              $add_log->add_user_log($string,"OK",Auth::user()->id);
              return true;
          }
          catch (\Exception $e)
          {
              // LOG
              $string="/custommer|"."updateCustommerInfo() | "."assign custommer to org ".$e->getMessage();
              $add_log= new PublicClass();
              $add_log->add_user_log($string,"FAILD" ,Auth::user()->id );
          }

        }

      public static function Add_new_in_custommer_table($request)
        {
            $validatedData = $request->validate([
              'first_name' => 'required',
              'last_name' => 'required',
              'custommer_email' => 'nullable|email',
              'custommerTel' => 'nullable|numeric|digits_between:10,15',
              'custommer_postalcode' => 'nullable|numeric',
              'custommer_codeghtesadi'=>'nullable|digits_between:10,15',

            ]);
               $val= new Custommer ($request->all());
                 $val->cstmr_name =$request->first_name;
                 $val->cstmr_family =$request->last_name;
                 $val->cstmr_organization=$request->custommer_organization;
                 $val->cstmr_post=$request->custommer_post_in_organization;
                 $val->cstmr_tel =$request->custommer_tel;
                 $val->cstmr_email =$request->custommer_email;
                 $val->cstmr_postalcode =$request->custommer_postalcode;
                 $val->cstmr_address =$request->custommer_address;
                 $val->cstmr_codeghtesadi =$request->custommer_codeghtesadi;
                 $val->cstmr_detials =0;
               $val->save();

            if ( $val->save())
            return true;
            }




}
