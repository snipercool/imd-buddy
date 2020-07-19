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
                            <a href="#" class="btn btn-primary my-2">{{__('app.acceptRequest')}}</a>
                            @else
                            @if(Session::has('RequestError'))
                            <div id="success" class="my-2 mx-0 w-100 alert alert-danger">
                                {{__('errors.wrongRequest')}}.
                            </div>
                            @elseif(Session::has('RequestSuccess'))
                            <div id="success" class="my-2 mx-0 w-100 alert alert-success">
                                {{__('app.requestSuccess')}}.
                            </div>
                            @endif

                            @if(Session::has('AcceptError'))
                            <div id="success" class="my-2 mx-0 w-100 alert alert-danger">
                                {{__('errors.wrongAccept')}}.
                            </div>
                            @elseif(Session::has('AcceptSuccess'))
                            <div id="success" class="my-2 mx-0 w-100 alert alert-success">
                                {{__('app.acceptSuccess')}}
                            </div>
                            @endif
                            @if(Auth::user()->hasbuddyRequestPending($user))
                            <button type="button" class="btn btn-info text-white" disabled>{{__('app.pending')}}</button>
                            @elseif (Auth::user()->hasbuddyRequestReceived($user))
                            <a href="{{ route('buddyaccept', ['locale' => app()->getLocale(), 'name' => $user->name, 'surname' => $user->surname]) }}" class="btn btn-primary my-2">{{__('app.acceptRequest')}}</a>
                            @else
                            <a href="{{ route('buddyadd', ['locale' => app()->getLocale(), 'name' => $user->name, 'surname' => $user->surname]) }}" class="btn btn-primary my-2">{{__('app.sendRequest')}}</a>
                            @endif
                            @endif
                            @elseif (Auth::user()->isBuddyWith($user)) 
                            <button type="button" class="btn btn-info text-white text-left" disabled>{{__('app.yourBuddy')}}!</button>
                            @elseif (Auth::user()->isBuddyWith($user)) 
                            <button type="button" class="btn btn-secondary text-white text-left" disabled>{{__('app.refused')}}!</button>
                            @else
                            <button type="button" class="btn btn-secondary" disabled>{{__('app.alreadyBuddy')}}</button>
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