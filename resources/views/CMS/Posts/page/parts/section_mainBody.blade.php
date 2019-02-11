@section('section_mainBody')
    <div class="ui form">

        <div class="field">
            <input id="post_Title" type="text" value="@if ($hasValue)  {{$dataList[0]->post_title}} @endif">
            <?php //var_dump($dataList) ?>
        </div>
        <div class="field">
            <textarea id="post_content" name="mainBodyEditor">
                @if ($hasValue)  {{$dataList[0]->post_content}} @endif
            </textarea>
                <script>
                    CKEDITOR.replace( 'mainBodyEditor' , {
                        contentsLangDirection: 'rtl' ,
                    });
                </script>
        </div>
    </div>

@endsection