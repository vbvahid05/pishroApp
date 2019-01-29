@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="border-top: 4px solid #3197d1;">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                </div>

                <div class="panel-body">
                    <img src="/img/logo.png" style="
                        width:  25%;
                        display:  block;
                        margin:  auto;
                        margin-bottom:  45px;
                     ">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label pull-right">{{Lang::get('labels.email')}}</label>

                            <div class="col-md-6 pull-right">
                                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-3 control-label pull-right ">{{Lang::get('labels.password')}}</label>

                            <div class="col-md-6 pull-right">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" style="margin-right: -30px;" {{ old('remember') ? 'checked' : '' }}>  {{Lang::get('labels.Remember_Me')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <hr/>
                            <div class="col-md-5 col-md-offset-3">
                                <button type="submit" class="btn btn-primary" style="width:  230px;">
                                    <i class="fa fa-key" aria-hidden="true"></i>
                                    {{Lang::get('labels.login')}}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{Lang::get('labels.repass')}}
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div style="display:  block;margin:  auto;width: 40%;margin-right:  250px;">
                {{Lang::get('labels.slog')}}
            </div>

        </div>
    </div>
</div>
@endsection
