@section('section_Step3_PersonInOrganization')

<div id="StepNo3" class="stepForm" >
    <h4 class="ui dividing header">
      <i class="fa fa-sitemap" aria-hidden="true"></i>  {{ Lang::get('labels.PersonInOrganization') }}
    </h4>

    <div class="field">
        <div class=" two fields">
            <div class="field">
                <label  class="RequirementField">{{ Lang::get('labels.firstname') }}  {{ Lang::get('labels.lastname') }}</label>
                <div class="ui container" data-live-search="true" data-selected-text-format="values" >
                    <select  ng-model="custommerid" class="ui search selection dropdown search-select" name="custommerId"  >
                        <option ng-repeat="custommer in allCustommers" value="@{{custommer.id}}" >
                          @{{custommer.cstmr_name}}
                          @{{custommer.cstmr_family}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="field"> </div>
        </div>

        <div class="two fields">
            <div class="field">
              <label class="RequirementField">{{ Lang::get('labels.organization_name') }}</label>
              <div class="ui container" data-live-search="true" data-selected-text-format="values" >
                <select ng-model="custommerOrgId" name="org" class="ui search selection dropdown search-select">
                  <option ng-repeat="org in AllOrganisations" value="@{{org.id}}" >
                        @{{org.org_name}}
                  </option>
                </select>
              </div>
            </div>
            <div class="field">
              <label class="RequirementField" >{{ Lang::get('labels.post_in_organization') }}</label>
                <div class="ui container" data-live-search="true" data-selected-text-format="values" >
                  <select ng-model="postInOrg" name="Allposts" class="ui search selection dropdown search-select">
                    <option ng-repeat="post in Allposts" value="@{{post.id}}" >
                          @{{post.ctm_org_semat_title}}
                    </option>
                  </select>
                </div>
            </div>
        </div>

        <div class="two fields">
          <div class="field">
              <label>{{ Lang::get('labels.tel_inOrg') }}</label>
              <input ng-model="tel_inOrg" type="text" name="tel_inOrg" id="tel_inOrg"   class="form-control">
          </div>
          <div class="field">
              <label>{{ Lang::get('labels.desc') }}</label>
              <textarea ng-model="desc" rows="4" cols="50" name="desc" id="desc" class="form-control"></textarea>
          </div>
        </div>
        <div ng-click="updateCustommerInfo()" class="btn btn-success"> <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ Lang::get('labels.save') }} </div>
    </div>
</div> <!-- StepNo 3 -->



@endsection
