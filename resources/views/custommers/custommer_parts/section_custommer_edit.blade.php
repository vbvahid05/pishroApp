<?php use App\Mylibrary\PublicClass;
 $all_org= PublicClass::Get_all_orgs();
 ?>
@section('section_custommer_edit')


<?php

if (isset( $customer_info))
  {
        foreach ($customer_info as $cm)
          {
           ?>
             <form  method="post" action="/updateCustommer">
                {{ csrf_field() }}

 <?php //----------TOOLBAR------------------------------------------------?>
               <div class="toolbars well well-sm">
                        <button   class="btn btn-default  " type="submit"> <i class="fa fa-pencil" aria-hidden="true"></i>  {{ Lang::get('labels.apply') }} </button>
                        <a class="backButton" href="{{ url('/all-custommers') }}" ><div class="btn btn-info btn-xs" >{{ Lang::get('labels.back') }}<i class="fa fa-arrow-left" aria-hidden="true"></i></div></a>
               </div>
<?php //-------------------------------------------------------------------------?>

              <input type="hidden" name="custommerID" value="{{ $cm->id}}">
               <table class="form-table">
             	   <tbody>

                 <tr>
                 	<th><label for="first_name">{{ Lang::get('labels.firstname') }} </label></th>
                 	<td><input type="text" name="first_name" id="first_name" value="{{  $cm->cstmr_name}}"  class="form-control"></td>
                 </tr>

                 <tr>
                 	<th><label for="last_name"> {{ Lang::get('labels.lastname') }}</label></th>
                 	<td><input type="text" name="last_name" id="last_name" value="{{$cm->cstmr_family}}"  class="form-control"></td>
                 </tr>

              <tr>
                 <th><label for="custommer_organization"> {{ Lang::get('labels.organization') }}</label></th>
                 <td>
                <div class="CustommerOrg">
                     <select name="custommer_organization" class="selectpicker" data-live-search="true"  id="custommerID"  >
                          <option value="{{$cm->cstmr_organization}}">{{$cm->org_name}}</option>
                         <?php echo $all_org; ?>
                     </select>
                </div>
                 </td>

              </tr>


              <tr>
                 <th><label for="custommer_post_in_organization"> {{ Lang::get('labels.post_in_organization') }}</label></th>
                 <td>
                    <select name="custommer_post_in_organization" class="selectpicker" data-live-search="true">
                        <option   value="{{$cm->cstmr_post}}">
                          <?php foreach ($custommer_post_title as $postTitle) {if ($postTitle->id == $cm->cstmr_post) echo $postTitle->ctm_org_semat_title;}?>
                        </option>
                        @foreach ($custommer_post_title as $postTitle)
                            <option value="{{ $postTitle->id }}">{{ $postTitle->ctm_org_semat_title }}</option>
                        @endforeach
                    </select>
                 </td>
              </tr>


                 <tr>
                   <th><label for="custommer_tel">
                      {{ Lang::get('labels.tel') }}
                   </label></th>
                   <td><input type="text" name="custommerTel" id="custommer_tel" value="{{$cm->cstmr_tel}}"  class="form-control"></td>
                 </tr>

                 <tr>
                   <th><label for="custommer_email">
                      {{ Lang::get('labels.email') }}
                   </label></th>
                   <td><input type="text" name="custommer_email" id="custommer_email" value="{{$cm->cstmr_email}}"  class="form-control"></td>
                 </tr>

                 <tr>
                   <th><label for="custommer_postalcode">
                      {{ Lang::get('labels.postalcode') }}
                   </label></th>
                   <td><input type="text" name="custommer_postalcode" id="custommer_postalcode" value="{{$cm->cstmr_postalcode}}"  class="form-control"></td>
                 </tr>

                 <tr>
                   <th><label for="custommer_address">
                      {{ Lang::get('labels.address') }}
                   </label></th>
                   <td><input type="text" name="custommer_address" id="custommer_address" value="{{$cm->cstmr_address}}"  class="form-control"></td>
                 </tr>

                 <tr>
                   <th><label for="custommer_codeghtesadi">
                      {{ Lang::get('labels.codeMelli') }}
                   </label></th>
                   <td><input type="text" name="custommer_codeghtesadi" id="custommer_codeghtesadi" value="{{$cm->cstmr_codeghtesadi}}"  class="form-control"></td>
                 </tr>
                 <tr>
                   <th><label for="custommer_Mobiletel">
                      {{ Lang::get('labels.MobileTel') }}
                   </label></th>
                   <td><input type="text" name="custommer_Mobiletel" id="custommer_Mobiletel" value="{{$cm->cstmr_Mobiletel}}"  class="form-control"></td>
                 </tr>
                 <tr>
                   <th><label for="custommer_detials">                      
                   </label></th>
                   <td><input type="hidden" name="custommer_detials" id="custommer_detials" value="{{$cm->cstmr_detials}}"  class="form-control"></td>
                 </tr>
               </tbody>
              </table>
             </form>
           <?php
          }
        }
          ?>

@endsection
