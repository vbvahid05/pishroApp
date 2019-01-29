<?php
//    use \App\Http\Controllers\PublicController;
    use \App\Mylibrary\PublicClass;
?>
@extends('layouts.theme')

@section('title', 'Page Title')

@section('sidebar') @endsection

@section('TopMenu')
     <ul>
        <li>DashBoard</li>
        <li>Users</li>
        <li>Products</li>
     </ul>
@endsection

//----------------------------
@section('content')
<!-- +++++++++++++++++++++++++++ -->



<div ng-app="firstApp" ng-controller="firstCtrl" >
      <div class="dashboard">

          <div class="dashboard_slog">
            <h1 ><i class="fa fa-tachometer" aria-hidden="true"></i> </h1>
            {{ Lang::get('labels.slog') }}
          </div>
          <hr/>
          <div class="highlight shadow">
             {{ Lang::get('labels.your_ip') }}    {{ $parameters['ipAddress'] }}
             <br/>
             {{ $parameters['testval'] }}

                {{--سلام @{{firstNamex + " " + lastName}}--}}
          </div>





        <!-- +++++++++++++++++++++++++++ -->
      </div><!-- dashboard -->





      <script>
        var app = angular.module('firstApp', []);
      app.controller('firstCtrl', function($scope, $http) {



              $scope.firstNamex="وحید ";
              $scope.lastName= "برزگر";
              $scope.test= "testبرزگر";

      });
          /*Controller */
      </script>
    <div class="voidspace">
            <div class="topBoxs A shadow col-md-3 pull-right">
                <div class="icon col-md-4 pull-right">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    {{Lang::get('labels.custommers')}}
                </div>
                <div class="seprate col-md-1 pull-right"> </div>
                <div class="desc col-md-6">
                </div>
            </div>
            <div class="topBoxs B shadow col-md-3 pull-right">
                <div class="icon col-md-4 pull-right">
                    <i class="fa fa-dropbox" aria-hidden="true"></i>
                    {{Lang::get('labels.stockroom')}}
                </div>
                <div class="seprate col-md-1 pull-right"> </div>
                <div class="desc col-md-6"> </div>
            </div>
            <div class="topBoxs C shadow col-md-3 pull-right">
                <div class="icon col-md-4 pull-right">
                    <i class="fa fa-diamond" aria-hidden="true"></i>
                    {{Lang::get('labels.sell')}}
                </div>
                <div class="seprate col-md-1 pull-right"> </div>
                <div class="desc col-md-6"> </div>
            </div>
            <div class="topBoxs  D shadow col-md-3 pull-right">
                <div class="icon col-md-4 pull-right">
                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                    {{Lang::get('labels.financial')}}
                </div>
                <div class="seprate col-md-1 pull-right"> </div>
                <div class="desc col-md-6"> </div>
            </div>
    <div class="row">
        {{--Show Change Logs   --}}
        <div class="ShowChangeLogs col-md-3 pull-right shadow ">
            <p></p>
            <?php



            ?>
            <ul>
                <h3><i class="fa fa-bug" aria-hidden="true" style="color: #49758c;"></i>&nbsp;{{Lang::get('labels.changeLog')}}</h3>
                <h5>
                    <?php
                           $LogVersion =$all_version_log[0]->vrl_version;
                          //echo ' :: ';
                            $LogDate=$all_version_log[0]->created_at;
                        $date =new PublicClass();

                     ?>
                </h5>
                <?php $i=0;?>
                @foreach($all_version_log AS $vLogs)
                    @if($i<=2 )
                        @if($vLogs->vrl_version != $LogVersion )
                            <h5>
                                <hr/>
                                {{Lang::get('labels.version')}}
                                <?php echo  $LogVersion =$vLogs->vrl_version;//echo ' :: '.$i;?>

                                  <?php
                                       $cdate= $vLogs->created_at;
                                        $DDate= explode(" ",$cdate) ;
                                        $BaseDate= $DDate[0];
                                        $DDate= explode("-",$BaseDate) ;
                                        echo '<span style="float: left;">'. $date->convert_gregorian_to_jalali($DDate[0],$DDate[1],$DDate[2]).'</span>' ;
                                   ?>

                            </h5>
                            <?php $i++ ?>
                        @endif
                            <li>{{$vLogs->vrl_title}}</li>
                    @endif

                @endforeach
            </ul>
        </div>
        {{--Show Change Logs   --}}
        <div class="col-md-3 ShowChangeLogs  shadow  pull-right" style="margin-right: 20px;min-height:  470px;border-right:  0;padding:  20;">
            <h3><i class="fa fa-pie-chart" aria-hidden="true" style="color: #49758c;"></i>&nbsp;{{Lang::get('labels.chart')}}</h3>
            <hr>
            <?php echo $chart ?>
        </div>
        <div class="col-md-6   shadow  pull-right" style="min-height:  470px;border-right:  0;padding:  20;margin-top:  20;width: 47.5%;margin-right: 20px;background:  #fff;">
            <h3><i class="fa fa-group" aria-hidden="true" style="color: #49758c;"></i>&nbsp;{{Lang::get('labels.Users_activity')}}</h3>
            <hr>

            <ul class="list-group">
                <?php $i=0; ?>
                @foreach($showUsersActivity AS $userActivity)
                  @if($i<=5 )
                <li class="list-group-item">
                    {{$userActivity->name}}
                    {{$userActivity->ual_ip}}
                    <span style="float: left;">

                        <?php
                        $Adate= $userActivity->created_at;
                        $DADate= explode(" ",$Adate) ;
                        $BaseDate= $DADate[0];
                        $DADate= explode("-",$BaseDate) ;
                        echo '<span style="float: left;font-size: 11px;">'. $date->convert_gregorian_to_jalali($DADate[0],$DADate[1],$DADate[2]).'</span>' ;
                        ?>
                    </span>
                    <br/>
                    <p style="text-align: left;font-size: 12px;font-weight: bold; ">{{$userActivity->ual_status}} | {{$userActivity->ual_Activity}}</p>

                </li>
                    <?php $i++ ?>
                    @endif
                @endforeach
            </ul>






<?php
          //  $base=$r->userInfo;
            //echo $r;
//            $set=strpos($r,"id");
//            $subster=    substr($r,$set+4,3) ;
//            $pos=strpos($subster,',"');
//            $strArray=(str_split($subster)) ;
//            $numStr="";
//            foreach ($strArray AS $ss)
//            {
//            if ($ss !=',' && $ss !='"')
//            $numStr=$numStr.$ss;
//            }
//            echo (int)$numStr;



 ?>















        </div>
    </div>
    </div>   <!-- firstApp -->

</div>
@endsection
