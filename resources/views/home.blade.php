@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <a href="/dashboard" class="btn btn-success">ورود به داشبود </a>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif



                    <div class="col-md-12"></div>
                    <div class="panel-heading col-md-6 pull-right">آموزش</div>
                    <div class="panel-heading col-md-6">مستندات </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
