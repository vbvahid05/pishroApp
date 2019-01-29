@section('section_serialNumber')
  <div ng-show="serialNumber_in_Dimmer">
    <div   class="ui segment" style="height: auto;width: 190%!important;right: -300px;border-top: 4px solid #e03997;">

        <h3 class="dimmer-title">@{{ FormTitle }}</h3>
        <hr/>
        <!-- Notifications-->
        <div id="publicNotificationMessage" class="publicNotificationMessage" >
          <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
        </div>
        <!-- Form Body -->
        <form class="ui form" name="myForm">
              <label >Email :</label>
             <input type="email" name="myAddress" ng-model="text" required>
            <!--  <span ng-show="myForm.myAddress.$error.email">Not a valid e-mail address</span> -->
             <hr/>
               <label >Name :</label>
             <input name="myName" ng-model="myName" required>
          <!--   <span ng-show="myForm.myName.$touched && myForm.myName.$invalid">The name is required.</span> -->
        </form>
    </div>
  </div>
@endsection
