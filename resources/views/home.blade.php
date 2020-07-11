@extends('layouts.app')

@include('partials.navbar')

@section('content')
    @if(Auth::guest())
        @include('auth.auth')
    @else
        @include('auth.logout')
    @endif
    
@endsection
