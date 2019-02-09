<html>
    <head>
         @include('layouts.parts.head')
    </head>
    <body>
      <div class="headerBar col-md-11">
        @include('layouts.parts.header')
      </div>
      <div class="col-md-1 ">
      </div>
    <div class="col-md-12">



          <div class="content-side col-md-11">
    <!-- ------------ ---------- -->
            @section('alerts')

               @yield('showalerts')

             @show

    <!-- ---------------------- -->

            @section('content')
             @show
             
             @include('layouts.parts.loading')
          </div>
          <div class="left-sidebar col-md-1 ">
              @include('layouts.parts.sidebar')
          </div>
    </div>


      <div class="footer col-md-12 ">

          @include('layouts.parts.footer')
      </div>



    </body>
</html>
