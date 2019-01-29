<?php
namespace App\Mylibrary;


class OrganizationClass
{
  public static function get_organizations_info($mode)
    {
      if ($mode==0)
      {
          $organization_info = \DB::table('custommerorganizations')
              ->where('custommerorganizations.deleted_flag', '=', 0)
              ->where('custommerorganizations.org_deleted', '=', 0)
              ->orderBy('custommerorganizations.id', 'DESC')
              ->get();
          return $organization_info;
      }
      else
      {
          $organization_info = \DB::table('custommerorganizations')
              ->where('custommerorganizations.deleted_flag', '=', 1)
              ->where('custommerorganizations.org_deleted', '=', 1)
              ->get();
          return $organization_info;
      }

    }



    public static function get_post_in_organizations_info()
      {
        $post_title = \DB::table('custommerorganizations_semat')
        //->where('Custommerorganizations.org_deleted', '=', 0)
        ->get();
        return $post_title;
      }




}
