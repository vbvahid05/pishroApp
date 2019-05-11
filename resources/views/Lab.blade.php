@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection


//----------------------------
@section('content')

<!-- +++++++++++++++++++++++++++ -->

<div ng-app="firstApp" ng-controller="firstCtrl"  ng-init="firstName='John'">
<div class="dashboard">
<h1>
  <i class="fa fa-steam" aria-hidden="true"></i>
      Laboratuvar
  <i class="fa fa-cogs" aria-hidden="true"></i>
</h1>
  <hr/>
  <p></p>



  <!-- +++++++++++++++++++++++++++ -->
  <div class="ui tabular menu">
    <div class="item active" data-tab="tab-home">reference</div>
    <div class="item" data-tab="tab-name11">Eloquent</div>
    <div class="item" data-tab="tab-name12">Migrate</div>
    <div class="item" data-tab="tab-name">Dimmer</div>
    <div class="item" data-tab="tab-name2">Angular #1</div>
    <div class="item" data-tab="tab-name3">Angular Get Json data</div>
    <div class="item" data-tab="tab-name4">"For" syntax in Laravel</div>
    <div class="item" data-tab="tab-name5">semantic Ui dropdown</div>
    <div class="item" data-tab="tab-name6">Bootstrap’s dropdown</div>
    <div class="item" data-tab="tab-name7">Pagination Example</div>
    <div class="item" data-tab="tab-name8">Menu</div>
    <div class="item" data-tab="tab-name9">Brand/Types  dropMenu</div>
    <div class="item" data-tab="tab-name10">Upload File</div>


  </div>

  <!-- reference Home -->
  <div class="ui tab active" data-tab="tab-home">
      <a class="btn btn-default" href="{{ route('register') }}">Register</a>
      <input type="text" ng-model="textCurency" ng-keypress="expression">
      <hr/>
    <ul>
      <li><a href="https://bootsnipp.com/snippets/featured/advanced-dropdown-search">bootsnipp.com/advanced-dropdown-search</a></li>
      <li><a href="https://scotch.io/tutorials/create-a-laravel-and-angular-single-page-comment-application">scotch.io |create-a-laravel-and-angular-single </a></li>
      <li><a href="https://cdnjs.com/libraries/semantic-ui"> cdnjs.com | semantic-ui</a></li>
      <li><a href="https://laracasts.com/discuss/channels/laravel/laravel-data-handling-from-angularjs-httppost">Laravel Data Handling From AngularJS http.post</a></li>
      <li><a href="http://thingsaker.com/blog/ajax-laravel-controller-method">AllCustommer_How to make an AJAX call to a Laravel controller function / method </a></li>
<hr/>
        <li><a href="https://vegibit.com/how-to-create-user-registration-in-laravel/" > create_Custome -user-registration-in-laravel </a></li>
      <li><a href="http://www.roxo.ir/احراز-هویت-در-لاراول-بخش-۱‍/">احراز هویت در لاراول</a></li>
      <li><a href="http://www.roxo.ir/احراز-هویت-در-لاراول-بخش-۱‍/">Authentication فارسی  roxo.ir</a></li>
      <li><a href="http://larabook.ir/docs/5.0/authentication#introduction">Authentication فارسی  http://larabook.ir</a></li>
      <li><a href="https://andrew.cool/blog/64/How-to-use-API-tokens-for-authentication-in-Laravel-5-2" >OK-> How-to-use-API-tokens-for-authentication-in-Laravel-5-2 </a> </li>
      <li><a href="https://laracasts.com/discuss/channels/laravel/laravel-5-fileimage-upload-example-with-validation" > File(Image) Upload Example with Validation</a></li>
      <li>jQuery Form Validation->>   var valu= $("#inpt_brandTile").val(); if (valu.length !=0)</li>

        <li><a href="https://babakhani.github.io/PersianWebToolkit/doc/datepicker/" >datepicker </a>  </li>

        <li>
            <a href="https://stackoverflow.com/questions/4075440/dynamic-height-for-div" > dynamic height for div</a>
        </li>
    </ul>

      <select multiple="" name="skills" class="ui fluid normal dropdown">
          <option value="">Skills</option>
          <option value="angular">Angular</option>
          <option value="css">CSS</option>
          <option value="design">Graphic Design</option>
          <option value="ember">Ember</option>
          <option value="html">HTML</option>
          <option value="ia">Information Architecture</option>
          <option value="javascript">Javascript</option>
          <option value="mech">Mechanical Engineering</option>
          <option value="meteor">Meteor</option>
          <option value="node">NodeJS</option>
          <option value="plumbing">Plumbing</option>
          <option value="python">Python</option>
          <option value="rails">Rails</option>
          <option value="react">React</option>
          <option value="repair">Kitchen Repair</option>
          <option value="ruby">Ruby</option>
          <option value="ui">UI Design</option>
          <option value="ux">User Experience</option>
      </select>

<script >
      $('.ui.normal.dropdown')
      .dropdown({
      })
</script>

  </div>
    <!--   -->
    <div class="ui tab" data-tab="tab-name11">
        <h2>Eloquent ORM </h2>
        <h4><a href="https://laravel.com/docs/4.2/eloquent#introduction" > Laravel - The PHP Framework For Web Artisans </a>  </h4>
        <div id="Eloquent" style="direction:  ltr;">
             return $users = sell_stockrequest::all();
            <hr/>
             return $user = sell_stockrequest::find(34);
            <hr/>
             return $model = sell_stockrequest::where('sel_sr_registration_date', '>', '2018-05-06')->firstOrFail();
            <hr/>
             return $count = sell_stockrequest::where('sel_sr_registration_date', '>', '2018-05-06')->count();
            <hr/>
            $stockrequest = new sell_stockrequest; <br/>
            $stockrequest->sel_sr_type = 2;<br/>
            $stockrequest->sel_sr_custommer_id = 4;<br/>
            $stockrequest->sel_sr_registration_date = 'value';<br/>
            $stockrequest->sel_sr_delivery_date='value';<br/>
            $stockrequest->sel_sr_pre_contract_number='value';<br/>
            $stockrequest->sel_sr_lock_status='value';<br/>
            $stockrequest->save();<br/>
            <hr/>
            Update :
            <br/>
            $affectedRows = sell_stockrequest::where('sel_sr_custommer_id', '=', 4)
            ->update(array('sel_sr_pre_contract_number' => 202020));
            <hr/>
            DELETE:
            <br/>
            $Rowid=48; <br/>
            $user = sell_stockrequest::find($Rowid);<br/>
            $user->delete();
            <br/>
            OR:
            <br/>
            sell_stockrequest::destroy(44);
            <hr/>
        </div>
    </div>

    <!--   -->
    <div class="ui tab" data-tab="tab-name12">
        <h2>Migrate</h2>
        <h4><a href="https://laravel.com/docs/5.6/migrations#creating-tables" > Migration   </a>  </h4>
        <h4><a href="https://laracasts.com/discuss/channels/code-review/sqlstate42s01-base-table-or-view-already-exists-1050-table-users-already-exists" > Migration Error  </a>  </h4>
        <div id="Eloquent" style="direction:  ltr;">
            <hr/>
            php artisan make:migration create_users_table

            <hr/>
            Step 1 : php artisan migrate:reset <br/>
            Step 2 : php artisan migrate
            <hr/>
            Delete All Table !!! <br/>
            php artisan migrate:fresh
            <hr/>


        </div>
    </div>
  <!-- dimmer -->
  <div class="ui tab" data-tab="tab-name">
    <h2>Show dimmer</h2>
    <div id="morez" class="ui green vertical animated button" tabindex="0">
      <div class="hidden content">2223</div>
      <div class="visible content"> <i class="plus icon"></i> </div>
    </div>

    <div  id="dimmer"   class="ui page dimmer">
      <div class="content">
        <div class="center">
          <div class="ui text container">
              <div class="ui segments">
                <div class="ui segment" style="height:  300px;">Content  </div>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Angular Simple change Label -->
  <div class="ui tab" data-tab="tab-name2">
    <h2> Angular Simple change Label </h2>
    <br/>
    نام    <input class="form-control" type="text" ng-model="firstNamex" >
    <br/>
    نام خانوادگی    <input class="form-control" type="text" ng-model="lastName" >
    <hr/>
    سلام @{{firstNamex + " " + lastName}}

    <br/><hr/><br/>
<!-- ************************************************************* -->
    <h2>Form example | User account signup</h2>
     <p>
       Validations are displayed one at a time based on the order set in customValidations.js
     </p>
     <form novalidate="">
       <label for="username">Username</label>
       <input type="text" id="username" name="username" ng-model="user.username" validation-min-length="5" validation-no-space="true" validation-field-required="true" validation-max-length="10" validation-no-special-chars="true" validation-dynamically-defined="locallyDefinedValidations" />
       <span class="help-block">username | validates no ones, no twos, min char = 5, max = 10, no special chars</span>

       <label for="password">Password</label>
       <input type="text" id="password" name="password" ng-model="user.password" validation-min-length="8" validation-one-number="true" validation-one-upper-case-letter="true" validation-one-lower-case-letter="true" validation-field-required="true" validation-no-space="true" />
       <span class="help-block">password | validates number required, lowercase required, uppercase...no space...</span>

       <label for="confirmPassword">Confirm Password</label>
       <input type="text" id="confirmPassword" name="confirmPassword" ng-model="user.confirmPassword" validation-confirm-password="true" />
       <span class="help-block">only validates when password is valid</span>
     </form>
     <br/><hr/>
     http://plnkr.co/edit/z0DTSV?p=preview
     <br/>
     https://www.npmjs.com/package/angular-ui-form-validation
<!-- ************************************************************* -->

  </div>
  <!-- Angular Get info from Webservice add to Combobox -->
  <div class="ui tab" data-tab="tab-name3">
    <h2>Angular Get info from Webservice add to Combobox</h2>
    <form ng-submit="addtoDB() "  id="FormORG">
      <div class="form-group">
          <select class="Organizations form-control" ng-model="selectedorg">
              <option ng-repeat="org in values" value="@{{org.id}}">@{{org.org_name}}</option>
          </select>
          <p></p>

          <i  ng-show="loading"   id="loading" class="fa fa-cog fa-spin fa-3x fa-fw"></i>
          <label  ng-show="messageng" id="messageBar" class="alert alert-success" ng-model="message" style="width:100%;" >@{{message}}</label><br/>
          <label  ng-show="messageng_Danger" id="messageBarDanger" class="alert alert-danger" ng-model="messageDanger" style="width:100%;" >@{{messageDanger}}</label><br/>

          <input type="text" class="form-control"  ng-model="newORGname" placeholder="Organization Name" > <br/>
          <input type="text" class="form-control"  ng-model="neworg_tel" placeholder="org_tel " > <br/>
          <input type="text" class="form-control"  ng-model="neworg_address" placeholder="org_address " > <br/>
          <input type="text" class="form-control"  ng-model="neworg_postalCode" placeholder="org_postalCode " > <br/>
          <input type="text" class="form-control"  ng-model="newoorg_codeeghtesadi" placeholder="org_codeeghtesadi " > <br/>

          <label ng-model="message" >@{{statuscode}}</label><br/>

          <button type="submit"   >add ORG </button>

      </div>
    <!--  <button type="submit" class="btn btn-info" >add new Organization </button> -->
    </form>

     <div ng-click="addnewORGFunc()" class="btn btn-success" style="margin-top:  -10px;">Add +</div>

     <script>
     /* ANGULAR Controller */
    var app = angular.module('firstApp', []);
     app.controller('firstCtrl', function($scope, $http) {
        $scope.loading = false;
        $scope.messageng = false;

      function  get_org_data()
      {
          $scope.loading = true;
       $http(
         {
           method : "GET",
           url : "services/orgName"
         }).then(function mySuccess(response)
          {
               $scope.values=response.data;
              $scope.loading = false;
              //$scope.statuscode = response.status;
           }, function myError(response)
           {
         //   $scope.values = response.statusText;
           });

         }
        get_org_data();
        $scope.addtoDB = function() //add Click
              {
                $scope.loading = true;
                var todo={
                  org_name:$scope.newORGname,
                  org_tel:$scope.neworg_tel,
                  org_address:$scope.neworg_address,
                  org_postalCode:$scope.neworg_postalCode,
                  org_codeeghtesadi:$scope.newoorg_codeeghtesadi,
                };
                $http.post('/services/addOrg',todo).then(function xSuccess(response)
                 {
                     //$scope.statuscode = response.status;
                     $scope.message="درج شد ";
                     $scope.loading = false;
                     $scope.messageng = true;
                     get_org_data();
                     $('#messageBar').delay(500).fadeOut('slow');

                }, function xError(response)
                {
                  $scope.messageng_Danger = true;
                  $scope.messageDanger="بروز خطا";
                  $scope.loading = false;
                  $('#messageBarDanger').delay(2000).fadeOut('slow');

                  var validator = $( "#FormORG" ).validate();
                  validator.resetForm();
              //   $scope.values = response.statusText;
                });



                  // $scope.values.push({ body:'iiiii'});
           }
         /* angular Controller */
         });
     </script>

  </div>
  <!-- "For" in Laravel -->
  <div class="ui tab" data-tab="tab-name4">


    @for ($i = 0; $i < 10; $i++)
        The current value is {{ $i }}
        <br/>
    @endfor


  </div>
  <!--  semantic Ui  -->
  <div class="ui tab" data-tab="tab-name5">
      <div class="ui container">
      <h3>DropDown </h3>
        <select class="ui search selection dropdown" id="search-select">
        			<option value="">State</option>
        			<option value="AL">Alabama</option>
        			<option value="AK">Alaska</option>
        			<option value="AZ">Arizona</option>
        			<option value="AR">Arkansas</option>
        			<option value="CA">صنایع الکترونیکی ایران</option>
        			<!-- Saving your scroll sanity !-->
        			<option value="OH">پخش و پالایش تهران </option>
        			<option value="OK">مس کرمان</option>
        			<option value="OR">معدن گل گهر سیرجان</option>
        			<option value="PA">Pennsylvania</option>
        			<option value="RI">Rhode Island</option>
        			<option value="SC">South Carolina</option>
        			<option value="SD">South Dakota</option>
        			<option value="TN">Tennessee</option>
        			<option value="TX">Texas</option>
        			<option value="UT">Utah</option>
        			<option value="VT">Vermont</option>
        			<option value="VA">Virginia</option>
        			<option value="WA">Washington</option>
        			<option value="WV">West Virginia</option>
        			<option value="WI">Wisconsin</option>
        			<option value="WY">Wyoming</option>
        		</select>
            <hr/>
            <br/>
            <h3>Radio Group </h3>
            <div class="btn btn-info" ng-click="checkw()">ss</div>
            <div class="grouped fields">
              <div class="two field">

                <div class="field">
                  <input class="ui slider checkbox" type="radio" name="status" value="1" ng-model="formData.ord_status">
                  <label>A </label>
                </div>

                <div class="field">
                  <input class="ui slider checkbox" type="radio" name="status" value="2" ng-model="formData.ord_status">
                  <label>B </label>
                </div>
              </div>
            </div>
      </div>
  </div>
<!--  semantic Ui dropdown -->
  <div class="ui tab" data-tab="tab-name6">

      <select class="selectpicker" data-live-search="true">
          <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
          <option data-tokens="mustard">Burger, Shake and a Smile</option>
          <option data-tokens="frosting">Sugar, Spice and all things nice</option>
          <option value="CA">صنایع الکترونیکی ایران</option>
          <!-- Saving your scroll sanity !-->
          <option value="OH">پخش و پالایش تهران </option>
          <option value="OK">مس کرمان</option>
          <option value="OR">معدن گل گهر سیرجان</option>
      </select>
      <hr/>
      <p></p>
      <select class="selectpicker" multiple title="انتخاب کنید">
          <option>Mustard</option>
          <option>Ketchup</option>
          <option>Relish</option>
      </select>
      <hr/>
      <p></p>
    Documentations :   <a href="https://silviomoreto.github.io/bootstrap-select/" target="_blank" >bootstrap-select</a>
  </div>
  <!--  Pagination Example -->
  <div class="ui tab" data-tab="tab-name7">
    <h2>Pagination Example</h2> <br/>
    <ul>
      <div ng-model="mytext" > </div>
      <div ng-repeat="post in posts | startFrom: pagination.page * pagination.perPage | limitTo: pagination.perPage">
         <li > @{{ post }} </li>
      </div>
  </ul>

  <ul class="pagination" style="float:  right;">
    <li><a href="" ng-click="pagination.prevPage()">&laquo;</a></li>
    <li ng-repeat="n in [] | range: pagination.numPages" ng-class="{active: n == pagination.page}">
    <a href="" ng-click="pagination.toPageId(n)">@{{n + 1}}</a>
    </li>
    <li><a href="" ng-click="pagination.nextPage()">&raquo;</a></li>
  </ul>


  <div style="height:80px;"></div>
  <hr/>
  https://github.com/svileng/ng-simplePagination
<hr/> Filters: <br/>
  https://docs.angularjs.org/api/ng/filter/filter

<script>

    var app = angular.module('firstApp', ['simplePagination']);
    app.controller('firstCtrl', ['$scope', 'Pagination',
    function($scope, Pagination) {

    $scope.posts = [
    'Jack',
    'Jill',
    'vahid',
      'Ali',
      'rexza',
      'rexzadd',
      'rexzaddxx',
    'Tom',
    'Harvey'
    ];
    $scope.pagination = Pagination.getNew(5);
    $scope.pagination.numPages = Math.ceil($scope.posts.length/$scope.pagination.perPage);
    }]);


</script>


  </div>
  <div class="ui tab" data-tab="tab-name8">
    <div id="accordian">
      <ul>
        <li>
          <h3><span class="icon-dashboard"></span>Dashboard</h3>
          <ul>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Search</a></li>
            <li><a href="#">Graphs</a></li>
            <li><a href="#">Settings</a></li>
          </ul>
        </li>
        <!-- we will keep this LI open by default -->
        <li class="active">
          <h3><span class="icon-tasks"></span>Tasks</h3>
          <ul>
            <li><a href="#">Today's tasks</a></li>
            <li><a href="#">Urgent</a></li>
            <li><a href="#">Overdues</a></li>
            <li><a href="#">Recurring</a></li>
            <li><a href="#">Settings</a></li>
          </ul>
        </li>
        <li>
          <h3><span class="icon-calendar"></span>Calendar</h3>
          <ul>
            <li><a href="#">Current Month</a></li>
            <li><a href="#">Current Week</a></li>
            <li><a href="#">Previous Month</a></li>
            <li><a href="#">Previous Week</a></li>
            <li><a href="#">Next Month</a></li>
            <li><a href="#">Next Week</a></li>
            <li><a href="#">Team Calendar</a></li>
            <li><a href="#">Private Calendar</a></li>
            <li><a href="#">Settings</a></li>
          </ul>
        </li>
        <li>
          <h3><span class="icon-heart"></span>Favourites</h3>
          <ul>
            <li><a href="#">Global favs</a></li>
            <li><a href="#">My favs</a></li>
            <li><a href="#">Team favs</a></li>
            <li><a href="#">Settings</a></li>
          </ul>
        </li>
      </ul>
  </div>
  <hr/>
  <a href="http://thecodeplayer.com/walkthrough/vertical-accordion-menu-using-jquery-css3" >
      vertical-accordion-menu-using-jquery-css3
  </a>
</div>
  <div class="ui tab" data-tab="tab-name9">

    <div class="ui two column grid">
      <div class="column">
        <div class="ui fluid vertical steps">
          <div class="step active">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
            <div class="content">
              <div class="title">{{ Lang::get('labels.customerPerson') }}</div>
              <div class="description">{{ Lang::get('labels.customerPersonDesc') }} </div>
            </div>
          </div>
          <div class="step">
            <i class="fa fa-building" aria-hidden="true"></i>
            <div class="content">
              <div class="title">{{ Lang::get('labels.CustommerOrganization') }}</div>
              <div class="description">{{ Lang::get('labels.CustommerOrganizationDesc') }}</div>
            </div>
          </div>
          <div class="step">
           <i class="fa fa-sitemap" aria-hidden="true"></i>
            <div class="content">
              <div class="title">{{ Lang::get('labels.PersonInOrganization') }}</div>
              <div class="description">{{ Lang::get('labels.PersonInOrganizationDesc') }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
          <div class="stepAction">
            sasdasd
          </div>
      </div>

    </div>

  </div>
<!-- Upload files-->
  <div class="ui tab" data-tab="tab-name10">
    <h1>Simple Upload files</h1><br/>
    <form action="{{ URL::to('upload') }}" method="post" enctype="multipart/form-data">
				<label>Select image to upload:</label>
			  <input type="file" name="file" id="file">
			  <input class="btn btn-info" type="submit" value="Upload" name="submit">
				<input type="hidden" value="{{ csrf_token() }}" name="_token">
		</form>
    <hr/>
    <a href="https://devdojo.com/episode/image-uploads-with-laravel" >Image Uploads with Laravel</a>
    <p></p>

         <div class="row alert alert-info">
           <h1>AngularJS Upload files</h1><br/>
             <div class="col-md-12">

                 <input type="file" ng-model="myFile" class="form-control" accept="image/*"
             		   onchange="angular.element(this).scope().uploadedFile(this)">
                 <button ng-click = "uploadFile()">upload me</button>
                 <br/>
                 <img ng-src="@{{src}}">

             </div>
             <br/>

         </div>

         <!-- script -->
     <script>

     var app = angular.module('firstApp',['simplePagination']);
     app.service('uploadFile', ['$http', function ($http)
	      {
            this.uploadFiletoServer = function(file, uploadUrl){


//-----------------------------------------
            /*  var newFormData=
              {
                fileName:file['name'],
              };*/
              var fd = new FormData();
              fd.append('file', file);

              $http.post('/upload/file',fd).then
              (function xSuccess(response)
              {
               //alert (response.data);
               console.log(response.data);
              }),
              function xError(response)
              {

              }
//-----------------------------------------


          /*
                 var fd = new FormData();
                 fd.append('file', file);

                 $http.post(uploadUrl, fd, {
                     transformRequest: angular.identity,
                     headers: {'Content-Type': undefined,'Process-Data': false}
                 })
                 .success(function(data){
                    alert(data);
                 })
                 .error(function(){
                    alert("Error");
                 });
                */
             }
         }]);

         app.controller('firstCtrl',  ['$scope', 'uploadFile', function($scope, uploadFile)
        {
          //----------------------
          $scope.uploadFile = function() {
                     $scope.myFile = $scope.files[0];
                     var file = $scope.myFile;
                     var url = "upload.php";
                     uploadFile.uploadFiletoServer(file, url);
                   };
          //---------------------
          $scope.uploadedFile = function(element)
             {
                var reader = new FileReader();
                 reader.onload = function(event)
                 {
                   $scope.$apply(function($scope) {
                   $scope.files = element.files;
                   $scope.src = event.target.result
                   });
                 }
                  reader.readAsDataURL(element.files[0]);
             }



        }]); /*Controller*/








     </script>













  </div>
<!-- Dashboard -->
  </div>
  <!-- Dashboard -->


  <!-- +++++++++++++++++++++++++++ -->







  </div>@endsection
