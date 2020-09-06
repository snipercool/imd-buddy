@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    @if(Auth::user())
    @if(count($tags) < 5) <div class="alert alert-warning w-50">{{__('profile.notenoughtags')}}</div>
@endif
@endif
@if(Session::has('RequestError'))
<div id="error" class="my-2 mx-0 w-50 alert alert-danger">
    {{__('errors.wrongRequest')}}.
</div>
@elseif(Session::has('RequestSuccess'))
<div id="success" class="my-2 mx-0 w-50 alert alert-success">
    {{__('app.requestSuccess')}}.
</div>
@elseif(Session::has('AcceptSuccess'))
<div id="success" class="my-2 mx-0 w-50 alert alert-success">
    {{__('app.acceptSuccess')}}
</div>
@elseif(Session::has('RefuseSuccess'))
<div id="success" class="my-2 mx-0 w-50 alert alert-success">
    {{__('app.refuseSuccess')}}.
</div>
@endif
@if(Auth::guest())
<h1 class='text-primary'>{{__('app.allusers')}}</h1>
@elseif (Auth::user()->buddy == 0)
<h1 class='text-primary'>{{__('app.hi')}}, {{__('auth.buddy')}}</h1>
@elseif (Auth::user()->buddy == 1)
<h1 class='text-primary'>{{__('app.hi')}}, {{__('auth.nobuddy')}}</h1>
@endif
@if(Session::has('searchError'))
<div id="searchError" class="my-2 mx-0 w-50 alert alert-danger">
    {{__('errors.searchError')}}.
</div>
@endif
<form action="{{ route('search', app()->getLocale()) }}" role="search">
    <div class="form-group d-inline-block">
        <input type="search" name="search" class="form-control" placeholder="{{__('app.search')}}">
    </div>
    <button type="submit" class="btn btn-primary ml-2">{{__('auth.submit')}}</button>
</form>
<div class="row">

    @foreach($data->sortBy('created_at') as $user)
    @include('partials.usercard')
    @endforeach
</div>
</div>

@endsection