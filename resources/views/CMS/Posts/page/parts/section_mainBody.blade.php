@section('section_mainBody')
    <div class="ui form">
        <input id="local" ng-model="local" type="hidden" value="{{$local}}">
        <div class="TitleSection field row">
            <div class="title col-md-6 pull-right">
                <input id="post_Title" type="text" value="@if ($hasValue)  {{$dataList[0]->post_title}} @endif">
            </div>
            <div class="slog col-md-6 pull-right">
                <label >@if ($hasValue)  {{$dataList[0]->post_slug}} @endif</label>
            </div>

            <?php //var_dump($dataList) ?>
        </div>
        <div class="field">
        <div class="row" style="margin-right: 0px;margin-bottom: 5px;">
            <div class="btn btn-default" ng-click="showMediaCenter('postContentAtachments')">
                <i class="fa fa-photo"></i>    {{lang::get('labels.addMultimediaToContent')}}
            </div>

            <input  type="hidden" id="postContentAtachments">
        </div>

            <textarea id="post_content" name="mainBodyEditor">
                @if ($hasValue)  {{$dataList[0]->post_content}} @endif
            </textarea>
                <script>
                    editor =   CKEDITOR.replace( 'mainBodyEditor' , {
                    });
                        editor.addCommand("mySimpleCommand", { // create named command
                            exec: function (edt) {
                            }
                        });
                      function CKEDITOR_insert_file_to_content() {
                         string="";
                        var obj = JSON.parse($("#postContentAtachments").val());
                        console.log(obj.length);
                        for (i = 0; i < obj.length; i++) {
                            string=string+'<img src="{{ url('/') }}/storage/mediaCenter/'+obj[i]['id']+'/thumb/'+obj[i]['mdiac_filename']+'" >'
                        }
                        editor.insertHtml(string);
                    }
                    editor.ui.addButton('SuperButton', { // add new button and bind our command
                        label: "Click me",
                        command: 'mySimpleCommand',
                        toolbar: 'insert',
                        icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
                    });
                </script>
        </div>
    </div>

@endsection