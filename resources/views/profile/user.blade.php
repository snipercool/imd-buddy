@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-auto mb-3">
                    <div class="mx-auto" style="width: 140px;">
                        <div class="d-flex justify-content-center align-items-center rounded mr-3" style="height: 140px; background-image: url({{$user->avatar}}); background-size:cover;">
                        </div>
                    </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{$user->name}} {{$user->surname}}</h4>
                        <div>
                            {{__('auth.isin')}} {{$user->year}}IMD
                        </div>
                        <div>
                            {{__('auth.tags')}}:
                            @foreach ($tags as $tag)
                            {{$tag->name}},
                            @endforeach
                        </div>
                        <div>
                        @if(!$user->buddy()->count())
                            @if(Auth::user()->hasbuddyRequestPending($user))
                            <button type="button" class="btn btn-info text-white" disabled>{{__('app.pending')}}</button>
                            @elseif (Auth::user()->hasbuddyRequestReceived($user))
                            <a href="{{ route('buddyaccept', ['locale' => app()->getLocale(), 'name' => $user->name, 'surname' => $user->surname]) }}" class="btn btn-success my-2">{{__('app.acceptRequest')}}</a>
                            <a href="{{ route('buddyrefuse', ['locale' => app()->getLocale(), 'name' => $user->name, 'surname' => $user->surname]) }}" class="btn btn-danger my-2">{{__('app.refuseRequest')}}</a>
                            @elseif (Auth::user()->buddyRefused($user))
                            <button type="button" class="btn btn-info text-white" disabled>{{__('app.refused')}}</button>
                            @elseif ($user->buddyRefused(Auth::user()))
                            <button type="button" class="btn btn-info text-white" disabled>{{__('app.youRefused')}}</button>
                            @else
                            <a href="{{ route('buddyadd', ['locale' => app()->getLocale(), 'name' => $user->name, 'surname' => $user->surname]) }}" class="btn btn-primary my-2">{{__('app.sendRequest')}}</a>
                            @endif
                            @elseif (Auth::user()->isBuddyWith($user))
                            <button type="button" class="btn btn-info text-white text-left" disabled>{{__('app.yourBuddy')}}!</button>
                            @elseif (!Auth::user()->buddy()->count())
                            <button type="button" class="btn btn-info text-white text-left" disabled>{{__('app.alreadyBuddy')}}!</button>
                            @elseif (Auth::user()->noMoreBuddy()->count())
                            <button type="button" class="btn btn-info text-white text-left" disabled>{{__('app.noMoreBuddy')}}!</button>
                            @else
                            <button type="button" class="btn btn-secondary text-left" disabled>{{__('app.alreadyBuddy')}}</button>
                            @endif
                        </div>
                    </div>
                    <div class="text-center text-sm-right">
                        <div class="text-muted"><small>{{__('profile.joined')}} {{$created}}</small></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <h4 class="text-primary">{{$user->name}}&lpar;'s&rpar; buddy:</h4>
                @if(!$user->buddy()->count())
                <div class="alert alert-info w-50" role="alert">
                    {{__('app.noBuddyYet')}}
                </div>
                @else
                <div class="alert alert-info w-50" role="alert">
                    {{__('app.userbuddy')}} {{$user->buddy()->first()->name}} {{$user->buddy()->first()->surname}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection