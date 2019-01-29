@section('section_Step1_customerPerson')
<div id="StepNo1" class="stepForm active" >
      <h4 class="ui dividing header"><i class="fa fa-user-plus" aria-hidden="true"></i>  {{ Lang::get('labels.PersonalInformation') }}</h4>
      <div class="field">
          <div class=" three fields">
            <div class="field">
                <label class="RequirementField">{{ Lang::get('labels.firstname') }}</label>
                <input type="text" ng-model="first_name"  name="first_name" id="first_name"   required>
            </div>
            <div class="field">
                <label class="RequirementField">{{ Lang::get('labels.lastname') }}</label>
                <input type="text" ng-model="last_name"  name="last_name" id="last_name" required  >
            </div>
            <div class="field">
                <label>{{ Lang::get('labels.codeMelli') }}</label>
                <input type="text" ng-model="codeMelli" name="code_Melli" id="code_Melli"   >
            </div>
          </div>
      <h4 class="ui dividing header">{{ Lang::get('labels.ContactInformation') }}</h4>
          <div class=" three fields">
            <div class="field">
                <label>{{ Lang::get('labels.tel') }}</label>
                <input type="text" ng-model="custommer_tel" name="custommer_tel" id="custommer_tel"   class="form-control" placeholder="0xx-xxx-xx-xx"  >
            </div>
            <div class="field">
                <label  >{{ Lang::get('labels.MobileTel') }}</label>
                <input type="text" ng-model="custommer_Mobile" name="custommer_Mobile" id="custommer_Mobile"  placeholder="09xx-xxx-xx-xx"  >
            </div>
            <div class="field">
                <label>{{ Lang::get('labels.email') }}</label>
                <input type="text" ng-model="custommer_email" name="custommer_email" id="custommer_email"  class="form-control" placeholder="example@email.com" >
            </div>
          </div>

          <div class="two fields">
            <div class="field">
                <label>{{ Lang::get('labels.address') }}</label>
                <textarea rows="4" cols="50" ng-model="custommer_address" name="custommer_address" id="custommer_address" class="form-control"></textarea>
            </div>
            <div class="field">
                <label>{{ Lang::get('labels.postalcode') }}</label>
                <input type="text" ng-model="custommer_postalcode" name="custommer_postalcode" id="custommer_postalcode"   class="form-control">
            </div>
          </div>
          <div ng-click="addNewPerson()" class="btn btn-success" > <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ Lang::get('labels.save') }} </div>
      </div>
</div> <!-- StepNo1 -->



@endsection
