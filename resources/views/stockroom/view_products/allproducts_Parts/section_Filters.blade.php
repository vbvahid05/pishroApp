@section('section_Filters')
    <form action="allproducts" method="get">
        <div class="filters ui search">
            <div class="ui icon input">
            <input  name="searchBox"  class="prompt" type="text" value="{{ Request::get('searchBox')}}" >
            <i class="search icon"></i>
            </div>
            <button type="submit" class="btn btn-default"  >search</button>
        </div>
    </form>
    <!-- pagination -->

@endsection

