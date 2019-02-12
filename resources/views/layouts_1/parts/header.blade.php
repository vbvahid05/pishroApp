
<div class="navbarx">
    <div class="navbar-innerx">
        <a id="logo" href="/"><img class="dashboard-logo" src="{{URL::asset('/img/pishro.png')}}" alt="profile Pic" style="width:10px;"></a>
        <a href="/lab" alt="Laboratuvar" ><i class="icon settings" style="float:  left;"></i> </a>

        @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">RegisterX</a></li>
        @else
            <ul class="dashboard_user_menu">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;
                    {{ Auth::user()->name }}

                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" style="margin-top: 1px !important;">
                    <li style="background:  #fff;">
                        <a href="/editUser">
                            {{Lang::get('labels.ChangePassword')}}
                        </a>
                    </li>
                    <li style="background:  #fff;">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{Lang::get('labels.logOut')}}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
            </ul>
        @endguest
    </div>
</div>
