

@section('sidebar')

@show


<div class="dashboard-right-menu">


  <div id="accordian">
    <ul>
      <!-- ///////////////////////////////////////////////-->
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

        <li id="Settings" class="accMenu">
            <h3><i class="icon settings" aria-hidden="true"></i>
                 {{ Lang::get('labels.settings') }}  </h3>
            <ul>
                <li><a href="{{ url('setting/users') }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        {{Lang::get('labels.userSetting')}}</a></li>
            </ul>
        </li>

    </ul>
  </div>









</div>
