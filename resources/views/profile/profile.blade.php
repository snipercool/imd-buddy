@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 row profileCard mr-3">
<div class="col-md-7 mr-3 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-auto mb-3">
                    <div class="mx-auto" style="width: 140px;">
                        <div class="d-flex justify-content-center align-items-center rounded mr-3" style="height: 140px; background-image: url({{Auth::user()->avatar}}); background-size:cover;">
                        </div>
                    </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{Auth::user()->name}} {{Auth::user()->surname}}</h4>
                        @if(Session::has('success'))
                        <div id="success" class="my-2 mx-0 w-75 alert alert-success">
                            {{__('profile.image')}}
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div id="errorImage" class="my-2 mx-0 w-75 alert alert-danger">
                            {{__('errors.imageError')}}
                        </div>
                        @endif
                        
                        <form id="form1" action="{{ route('updateimage', app()->getLocale()) }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div>
                                <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror my-2 mx-0 w-75" name="avatar" value="{{ old('avatar') }}" required>
                            </div>
                            <div class="mt-3">
                                <button id="fileBtn" class="btn btn-primary" name="form1" type="submit">
                                    <span>{{__('profile.change')}}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center text-sm-right">
                        <div class="text-muted"><small>{{__('profile.joined')}} {{$created}}</small></div>
                    </div>
                </div>
            </div>
            <div class="tab-content pt-3">
                <form id="form2" action="{{ route('profile', app()->getLocale()) }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{__('auth.firstname')}}</label>
                                <input class="form-control" type="text" name="name" placeholder="{{Auth::user()->name}}" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{__('auth.lastname')}}</label>
                                <input class="form-control" type="text" name="surname" placeholder="{{Auth::user()->surname}}" value="{{ old('surname') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{__('auth.email')}}</label>
                                <input class="form-control" type="email" name="email" placeholder="{{Auth::user()->email}}" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="inputState" class="col-md-12 text-md-left">{{__('auth.year')}}</label>
                                <div class="col-md-12">
                                    <select id="year_id" name="year" class="form-control @error('year') is-invalid @enderror">
                                        <option value="" selected>{{__('auth.yearstandard')}}</option>
                                        <option for="year" value="1">1 IMD</option>
                                        <option for="year" value="2">2 IMD</option>
                                        <option for="year" value="3">3 IMD</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <div class="form-group my-3">
                                <div class="col-md-12 text-left">
                                    <input type="radio" id="no-buddy" name="buddy" value="0">
                                    <label for="no-buddy">{{__('auth.nobuddy')}}</label><br>
                                    <input type="radio" id="buddy" name="buddy" value="1">
                                    <label for="buddy">{{__('auth.buddy')}}</label><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                                <div class="mb-2"><b>{{__('auth.tags')}}</b></div>
                                @if(count($tags) < 5)
                                    <div class="alert alert-warning">{{__('profile.counttag')}}</div>
                                @endif
                                <div class="col mb-2">
                                    <label>{{__('profile.alltags')}} :</label>
                                    @foreach ($tags as $tag)
                                    {{$tag->name}},
                                    @endforeach
                                </div>
                                <div class="form-group mb-0">
                                    <div id="message">

                                    </div>
                                    <div class="col-md-12 text-md-left">
                                        <input type="text" class="form-control" id="types" aria-describedby="types" placeholder="{{__('auth.tagplaceholder')}}">
                                        <div class="suggestions">
                                            <ul id="suggestions" class="pl-0">

                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-12 text-md-left">
                                        <span class="text-muted">{{__('auth.tags')}}:
                                            <span id="traits"><input type="hidden" name="types" value="" id="hiddenTags"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div> 
                        <div class="col-md-5 mb-3">
                        @if(Session::has('PasswordChanged'))
                        <div id="success" class="my-2 mx-0 w-75 alert alert-success">
                            {{__('profile.changedPass')}}.
                        </div>
                        @endif
                        <div class="mb-2"><b>{{__('profile.changepass')}}</b></div>
                        <a href="{{ route('updatepassword', app()->getLocale()) }}" class="btn btn-primary">{{__('profile.changepass')}}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button class="btn btn-primary" id="" type="submit">{{__('auth.submit')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4 mt-5">
    <div class="card">
        <div class="card-body">
            <h3 class="text-primary">Buddy:</h3>
                @if(!Auth::user()->buddy()->count())
                    <div class="alert alert-info" role="alert">
                        {{__('app.noBuddyYet')}}
                    </div>
                @if(!Auth::user()->buddyRequests()->count())
                    <div class="alert alert-info" role="alert">
                        {{__('app.noRequest')}}
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        {{__('app.request')}} <strong>{{Auth::user()->buddyRequests()->first()->name}} {{Auth::user()->buddyRequests()->first()->surname}}</strong>
                        <form action="{{ route('userprofile',  app()->getLocale()) }}">
                        <input type="hidden" name="name" value="{{Auth::user()->buddyRequests()->first()->name}}">
                        <input type="hidden" name="surname" value="{{Auth::user()->buddyRequests()->first()->surname}}">
                        <button type="submit" class="btn btn-primary">{{__('profile.goProfile')}}</button>
                        </form>
                        <a href="{{ route('buddyaccept', ['locale' => app()->getLocale(), 'name' => Auth::user()->buddyRequests()->first()->name, 'surname' => Auth::user()->buddyRequests()->first()->surname]) }}" class="btn btn-success my-2">{{__('app.acceptRequest')}}</a>
                        <a href="{{ route('buddyrefuse', ['locale' => app()->getLocale(), 'name' => Auth::user()->buddyRequests()->first()->name, 'surname' => Auth::user()->buddyRequests()->first()->surname]) }}" class="btn btn-danger my-2">{{__('app.refuseRequest')}}</a>
                    </div>
                @endif
                @else
                <div class="row">
                <div class="rounded-circle overflow-hidden d-inline-block" style="width: 40px; height: 40px; background-image: url({{Auth::user()->buddy()->first()->avatar}}); background-size:cover;">
                </div>
                <p class="text-dark ml-1 w-75 font-weight-bold">{{Auth::user()->buddy()->first()->name}} </br> {{Auth::user()->buddy()->first()->surname}} </p>
                </div>
                <form action="{{ route('userprofile',  app()->getLocale()) }}">
                <input type="hidden" name="name" value="{{Auth::user()->buddy()->first()->name}}">
                <input type="hidden" name="surname" value="{{Auth::user()->buddy()->first()->surname}}">
                <button type="submit" class="btn btn-primary">{{__('profile.goProfile')}}</button>
                <a href="{{ route('deletebuddy', ['locale' => app()->getLocale(), 'name' => Auth::user()->buddy()->first()->name, 'surname' => Auth::user()->buddy()->first()->surname]) }}" class="btn btn-danger my-2">{{__('app.deleteBuddy')}}</a>
                </form>
                @endif
            
        </div>
    </div>
</div>
</div>
@endsection