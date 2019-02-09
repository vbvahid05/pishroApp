
{{--@inject('dashMenu', 'App\Http\Controllers\DashboardController')--}}
@section('sidebar')

@show


<div class="dashboard-right-menu">


  <div id="accordian">

    <ul>
      <!-- ///////////////////////////////////////////////-->

        {{--@foreach ($dashMenu->dashboardSideMenu() as $menu)--}}
            {{--@if ($menu->trmrel_parent ==0)--}}
            {{--<li id="dashboard" class="accMenu">--}}
                {{--<h3>--}}
                    {{--@if ($menu->trmrel_value !=null)--}}
                        {{--<a href="{{ url($menu->trmrel_value) }}" >--}}
                            {{--<i class="{{ $menu->trmrel_icon }}" aria-hidden="true"></i>--}}
                            {{--{{ Lang::get('labels.'.$menu->trmrel_lang_label) }}--}}
                        {{--</a>--}}

                    {{--@else--}}
                        {{--<i class="{{ $menu->trmrel_icon }}" aria-hidden="true"></i>--}}
                        {{--{{ Lang::get('labels.'.$menu->trmrel_lang_label) }}--}}
                        {{--@endif--}}
                {{--</h3>--}}

                {{--@foreach ($dashMenu->dashboardSideMenu() as $subMenu)--}}
                    {{--@if ($subMenu->trmrel_parent ==$menu->id)--}}
                        {{--<ul>--}}
                    {{--@endif--}}
                {{--@endforeach--}}

                    {{--@foreach ($dashMenu->dashboardSideMenu() as $subMenu)--}}
                    {{--@if ($subMenu->trmrel_parent ==$menu->id)--}}
                                    {{--<a id="{{$subMenu->trmrel_class}}" href="{{ url($subMenu->trmrel_value) }}" >--}}
                                        {{--<li >--}}
                                            {{--<i class="{{$subMenu->trmrel_icon}}" aria-hidden="true"></i>--}}
                                            {{--{{ Lang::get('labels.'.$subMenu->trmrel_lang_label) }}</li>--}}
                                    {{--</a>--}}
                    {{--@endif--}}
                    {{--@endforeach--}}

                {{--@foreach ($dashMenu->dashboardSideMenu() as $subMenu)--}}
                    {{--@if ($subMenu->trmrel_parent ==$menu->id)--}}
                    {{--</ul>--}}
                    {{--@endif--}}
                {{--@endforeach--}}


            {{--</li>--}}
            {{--@endif--}}

        {{--@endforeach--}}


      <li id="dashboard" class="accMenu">
        <h3>
            <a href="{{ url('/dashboard') }}" >
              <i class="fa fa-tachometer" aria-hidden="true"></i>
              {{ Lang::get('labels.dashboard') }}
            </a>
        </h3>
      </li>
      <!-- we will keep this LI open by default -->
      <!-- ///////////////////////////////////////////////-->



      <!-- ///////////////////////////////////////////////-->
      <li id="custommers" class="accMenu">
        <h3><i class="fa fa-user-circle-o" aria-hidden="true"></i>{{ Lang::get('labels.custommers') }}</h3>
        <ul>
            <a id="custommer" href="{{ url('/custommer') }}"><li> <i class="fa fa-address-card" aria-hidden="true"></i>{{ Lang::get('labels.newCustommer') }} </li> </a>
            <a id="all-custommers" href="{{ url('/all-custommers') }}"> <li> <i class="fa fa-address-book" aria-hidden="true"></i>  {{ Lang::get('labels.AllCustommer') }} </li> </a>
            <a id="all-orgs" href="{{ url('/all-orgs') }}"> <li>  <i class="fa fa-building" aria-hidden="true"></i> {{ Lang::get('labels.AllOrgs') }} </li> </a>
        </ul>
      </li>
      <!-- ///////////////////////////////////////////////-->

      <!-- ///////////////////////////////////////////////-->
      <li id="stockroom" class="accMenu">
        <h3><i class="fa fa-dropbox" aria-hidden="true"></i>{{ Lang::get('labels.stockroom') }}</h3>
        <ul>
            <a id="allproducts" href="{{ url('stock/allproducts') }}" ><li ><i class="fa fa-tags" aria-hidden="true"></i>{{ Lang::get('labels.newProduct') }}</li>  </a>
            <a id="AllOrders" href="{{ url('stock/AllOrders') }}" ><li><i class="fa fa-cart-plus" aria-hidden="true"></i>{{ Lang::get('labels.allOrders') }} </li></a>
            <a id="PuttingProducts" href="{{ url('stock/PuttingProducts') }}" ><li><i class="fa fa-level-down" aria-hidden="true"></i>{{ Lang::get('labels.addtoStock') }} </li></a>
            <a id="TakeOutProducts" href="{{ url('sell/TakeOutProducts') }}" ><li> <i class="fa fa-paper-plane-o" aria-hidden="true"></i>  {{ Lang::get('labels.outStock') }} </li></a>
        </ul>
      </li>
      <!-- ///////////////////////////////////////////////-->
      <li id="sell" class="accMenu">
          <h3><i class="fa fa-diamond" aria-hidden="true"></i>   {{ Lang::get('labels.sell') }}</h3>
          <ul>
              <a id="ProductStatusReport" href="{{ url('sell/ProductStatusReport') }}" >
                <li ><i class="fa fa-file-text" aria-hidden="true"></i>{{ Lang::get('labels.ProductStatusReport') }}</li>
              </a>

              <a id="stockRequest" href="{{ url('sell/stockRequest') }}" >
                <li ><i class="fa fa-cubes" aria-hidden="true"></i>{{ Lang::get('labels.stockRequest') }}</li>
              </a>

              <a id="invoice" href="{{ url('sell/invoice') }}" >
                  <li  > <i class="fa fa-money" aria-hidden="true"></i>
                      {{ Lang::get('labels.invoice') }}	</li>
              </a>


              <li><a href="#">...</a></li>
          </ul>
      </li>
      <!-- ///////////////////////////////////////////////-->
      <li id="financial" class="accMenu">
          <h3><i class="fa fa-credit-card" aria-hidden="true"></i>
              {{ Lang::get('labels.financial') }}  </h3>
          <ul>
            <li><a href="#">...</a></li>
          </ul>
      </li>
        <!-- ///////////////////////////////////////////////-->
        <li id="Settings" class="accMenu">
            <h3><i class="icon settings" aria-hidden="true"></i>
                 {{ Lang::get('labels.settings') }}  </h3>
            <ul>
                <li><a href="{{ url('setting/users') }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        {{Lang::get('labels.userSetting')}}</a></li>
            </ul>
        </li>
        <!-- ///////////////////////////////////////////////-->
        <li id="posts" class="accMenu">
            <h3><i class="icon settings" aria-hidden="true"></i>
                {{ Lang::get('labels.posts') }}  </h3>
            <ul>
                <li><a href="{{ url('all-posts/posts') }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        {{Lang::get('labels.allPosts')}}</a></li>
            </ul>
        </li>


    </ul>
  </div>









</div>
