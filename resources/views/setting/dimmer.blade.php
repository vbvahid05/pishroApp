
@include('setting.users.users_parts.Dmr_New_Edit_Roles')
@include('setting.users.users_parts.Dmr_new_edit_user_roles')


@section('section_dimmerPage')

    <div  id="Dimmer_page"   class="ui page dimmer">
        <div class="content">
            <div class="center">
                <div class="ui text container">
                    <div  class="ui segments">
                        @section('Dmr_new_edit_user_roles') @show
                        @section('Dmr_New_Edit_Roles') @show


                        {{--@section('section_Test') @show--}}
                        {{--@section('section_add_A_PartToChassis') @show--}}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection