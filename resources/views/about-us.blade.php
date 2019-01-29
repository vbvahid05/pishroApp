@extends('layouts.theme')

@section('title', 'Page Title')


@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection


@section('content')
    <p>This is my body content.</p>
    @for ($i = 0; $i < 10; $i++)
        The current value is {{ $i }}
    @endfor

@endsection

@section('TopMenu')
     <ul>
        <li>DashBoard</li>
        <li>Users</li>
        <li>Products</li>
     </ul>
@endsection
