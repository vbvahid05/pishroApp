@section('section_mainBody')
    <div class="ui form">

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



                {{--<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>--}}
                {{--<script>tinymce.init({ selector:'#post_content' });</script>--}}

            {{--<input id="post_content"   value="@if ($hasValue)  {{$dataList[0]->post_content}} @endif">--}}




            <textarea id="post_content" name="mainBodyEditor">
                @if ($hasValue)  {{$dataList[0]->post_content}} @endif
            </textarea>
                <script>
                    CKEDITOR.replace( 'mainBodyEditor' , {

                    });
                </script>
        </div>
    </div>

@endsection