@extends('master')

@section('title', 'iWallet')

@section('content')

<navbar-component></navbar-component>
<router-view></router-view>

@endsection
@section('pagescript')
<script src="js/app.js"></script>
@stop
