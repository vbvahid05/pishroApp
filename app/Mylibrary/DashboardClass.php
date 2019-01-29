<?php
namespace App\Mylibrary;

use App\version_log;
use App\user_activity_log;

class DashboardClass
{
  public static function getIpAddress()
  {
    $ip=  \request()->ip();
    return $ip;
  }


  public static function test()
  {
    $test='...'      ;
    return $test;
  }

  public static function get_all_version_log()
  {
      return $version_log = version_log::all()->sortByDesc("id");
  }

  public static function showChart()
  {
        $dataPoints = array(
        array("label"=>"Oxygen", "symbol" => "O","y"=>46.6),
        array("label"=>"Silicon", "symbol" => "Si","y"=>27.7),
        array("label"=>"Aluminium", "symbol" => "Al","y"=>13.9),
        array("label"=>"Iron", "symbol" => "Fe","y"=>5),
        array("label"=>"Calcium", "symbol" => "Ca","y"=>3.6),
        array("label"=>"Sodium", "symbol" => "Na","y"=>2.6),
        array("label"=>"Magnesium", "symbol" => "Mg","y"=>2.1),
        array("label"=>"Others", "symbol" => "Others","y"=>1.5),

        );

        return   $chart= '
        <script>
        window.onload = function() {
        
        var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light2",
        animationEnabled: true,
        title: {
        text: ""
        },
        data: [{
        type: "doughnut",
        indexLabel: "{symbol} - {y}",
        yValueFormatString: "#,##0.0\"%\"",
        showInLegend: true,
        legendText: "{label} : {y}",
        dataPoints: '.json_encode($dataPoints, JSON_NUMERIC_CHECK) .'   
        }]
        });
        chart.render();
        }
        </script>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <script src="/js/chart/canvasjs.min.js"></script>
        ';

    }


  public function  showUsersActivity()
  {

//      return user_activity_log::all();
      return \DB::table ('user_activity_logs AS activity_log')
          ->join('users AS user','user.id','=','activity_log.ual_userId')
          ->select('*')
          ->orderBy('activity_log.id', 'Desc')
          ->get();

  }

}
