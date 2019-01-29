@section('section_Step2_CustommerOrganization')

<div id="StepNo2" class="stepForm" >
      <h4 class="ui dividing header"><i class="fa fa-building" aria-hidden="true"></i> {{ Lang::get('labels.OrgInformation') }}</h4>
      <div class="field">
          <div class=" two fields">
            <div class="field">
                <label class="RequirementField">{{ Lang::get('labels.organization_name') }}</label>
                <input  type="text" ng-model="org_name"  name="org_name" id="org_name"    autocomplete="" required>
            </div>
            <div class="field">
                <label >{{ Lang::get('labels.codeghtesadi') }}</label>
                <input type="text" ng-model="org_codeeghtesadi" name="org_codeeghtesadi	" id="org_codeeghtesadi	"  class="form-control">
            </div>
          </div>
      <h4 class="ui dividing header">{{ Lang::get('labels.ContactInformation') }}</h4>
          <div class=" three fields">
            <div class="field">
                <label class="RequirementField">{{ Lang::get('labels.tel') }}</label>
                <input type="text"  ng-model="org_tel"  name="org_tel" id="org_tel"   class="form-control">
            </div>
            <div class="field">
                <label >{{ Lang::get('labels.email') }}</label>
                <input type="text" ng-model="org_email" name="org_email" id="org_email"   >
            </div>
            <div class="field">
                <label>{{ Lang::get('labels.webSite') }}</label>
                <input type="text" ng-model="org_webSite" name="org_webSite" id="org_webSite"  class="form-control">
            </div>
          </div>

          <div class="two fields">
            <div class="field">
                <label>{{ Lang::get('labels.address') }}</label>
                <textarea rows="4" cols="50"   ng-model="org_address" name="org_address" id="org_address" class="form-control"></textarea>
            </div>
            <div class="field">
                <label>{{ Lang::get('labels.postalcode') }}</label>
                <input type="text" ng-model="org_postalcode" name="org_postalcode" id="org_postalcode"   class="form-control">
            </div>
          </div>
      <div ng-click="addNewOrganization()" class="btn btn-success" > <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ Lang::get('labels.save') }} </div>
      </div>
</div> <!-- StepNo2 -->



@endsection
