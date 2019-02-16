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


    <div class="row" style="margin-top: 15px">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-user-circle-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> {{Lang::get('labels.custommers')}}</span>
                    <span class="info-box-number">
                        <small>
                            <ul class="col-md-6 pull-right">
                                <li><a href="/custommer">{{lang::get('labels.newCustommer')}}</a></li>
                                <li><a href="/all-custommers">{{lang::get('labels.AllCustommer')}}</a></li>
                            </ul>

                             <ul class="col-md-6 pull-right">
                               <li><a href="/all-orgs">{{lang::get('labels.AllOrgs')}}</a></li>
                            </ul>
                        </small>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-dropbox"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> {{Lang::get('labels.stockroom')}}</span>
                    <span class="info-box-number">
                     <small>
                            <ul class="col-md-6 pull-right">
                                <li><a href="stock/allproducts">{{lang::get('labels.newProduct')}}</a></li>
                                <li><a href="/stock/AllOrders">{{lang::get('labels.allOrders')}}</a></li>
                            </ul>

                             <ul class="col-md-6 pull-right">
                               <li><a href="/stock/PuttingProducts">{{lang::get('labels.addtoStock')}}</a></li>
                               <li><a href="/sell/TakeOutProducts">{{lang::get('labels.outStock')}}</a></li>
                            </ul>
                        </small>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-diamond"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> {{Lang::get('labels.sell')}}</span>
                    <span class="info-box-number">
                         <small>
                            <ul class="col-md-6 pull-right">
                                <li><a href="/sell/ProductStatusReport">{{lang::get('labels.ProductStatusReport')}}</a></li>
                                <li><a href="/sell/stockRequest">{{lang::get('labels.stockRequest')}}</a></li>
                            </ul>

                             <ul class="col-md-6 pull-right">
                               <li><a href="/sell/invoice">{{lang::get('labels.invoice')}}</a></li>
                            </ul>
                        </small>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-credit-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> {{Lang::get('labels.financial')}}</span>
                    <span class="info-box-number"> </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
    </div>


    <div class="row">
        <div class="col-md-4 pull-right" >
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bug" aria-hidden="true" style="color: #49758c;"></i>&nbsp;{{Lang::get('labels.changeLog')}}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <ul>
                            <?php
                            $LogVersion =$all_version_log[0]->vrl_version;
                            //echo ' :: ';
                            $LogDate=$all_version_log[0]->created_at;
                            $date =new PublicClass();
                            ?>
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
            </div>
        </div>

        <div class="col-md-4 pull-right" >
        <div class="box box-warning ">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-pie-chart" aria-hidden="true" style="color: #49758c;"></i>&nbsp;{{Lang::get('labels.chart')}}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <?php  echo $chart ?>

            </div><!-- /.box-body -->
        </div>
        </div>

        <div class="col-md-4 pull-right" >
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-group" aria-hidden="true" style="color: #49758c;"></i>&nbsp;{{Lang::get('labels.Users_activity')}}</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
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
                        </div>


           </div>
     </div>
   </div>




</div>
@endsection
