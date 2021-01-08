@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    <h1 class='text-primary'>{{__('app.results')}} :</h1>
    @if (!$users->count())
    <div id="no_users" class="my-2 mx-0 w-50 alert alert-danger">
        {{__('app.no_users')}}.
    </div>
    @else

    @foreach($users->sortBy('created_at') as $user)
    @include('partials.usercard')
    @endforeach

    @endif
</div>
@endsection