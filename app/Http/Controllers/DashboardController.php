<?php

namespace App\Http\Controllers;
use App\Model_admin\cms_term_relation;
use Illuminate\Http\Request;
use App\Mylibrary\DashboardClass;
use App\Mylibrary\PublicClass;




class DashboardController extends Controller
{
    public $userInfo;
    public function __construct()
    {
        if ( $this->middleware('auth'))
        {
            return  $this->userInfo = \Auth::user();
        }
        else return view('/login');
    }
    //

    public function showDashboard()
    {
        $DashboardController=new DashboardController;
        $rr=new PublicClass();
        if (!$rr->checkUserValidation($DashboardController))
        {
            \Auth::logout();
            return redirect()->route('login');
        }


     $dashboard_class = new DashboardClass;
//-------------------------------
      $ipAddress= $dashboard_class->getIpAddress();
      $test= $dashboard_class->test();
//-------------------------------
      $parameters = array("ipAddress"=>  $ipAddress,
                          "testval"=>$test
      );

        $dshbord_class = new DashboardClass;
        $all_version_log=$dshbord_class->get_all_version_log();

//-------------------------------
        $dshbord_class = new DashboardClass;
        $chart=$dshbord_class->showChart();
//-------------------------------
        $dshbord_class = new DashboardClass;
        $showUsersActivity =$dshbord_class->showUsersActivity();

//-------------------------------

     return view('/dashboard', compact('parameters','all_version_log'  ,'chart' ,'showUsersActivity'));
      //  return view('/dashboard');
    }


    public function dashboardSideMenu()
    {

        return cms_term_relation::where('trmrel_term_id', '=', 7)
                ->get();
    }





}
