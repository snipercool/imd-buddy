@extends('layouts.app')

@section('content')
<div class="text-center h-100 row" style="min-height: 100vh;overflow: hidden;">
    <div class=" col-md-12 col-lg-8 col-xxl-10 side-left">
    </div>
    <div class="col-md-12 col-lg-4 col-xxl-2 mt-5 mx-auto px-4">
        <img src="../images/svg/logo--blue.svg" alt="Logo" width="auto" class="mb-3" style="max-width: 330px;">
        <p class="mb-3">{{ __('app.register') }}</p>
        <form method="POST" action="{{ route('register', app()->getLocale()) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <img class="avatar mb-2" src="../images/jpg/default.jpg" alt="default" width="150" height="150">
                <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror my-4" name="avatar" value="{{ old('avatar') }}" required>

                @error('avatar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="name" class="col-md-12 text-md-left">{{ __('auth.firstname') }}</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="John" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="surname" class="col-md-12 text-md-left">{{ __('auth.lastname') }}</label>

                <div class="col-md-12">
                    <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" placeholder="Doe" value="{{ old('surname') }}" required autocomplete="surname">

                    @error('surname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="email" class="col-md-12 text-md-left">{{ __('auth.email') }}</label>

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="example@thomasmore.be" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div id="warning" class="alert alert-warning d-none text-left" role="alert">{{trans('auth.warningnobuddy')}}</div>
            <div id="warning2" class="alert alert-warning d-none text-left" role="alert">{{trans('auth.warningbuddy')}}</div>

            <div class="form-group mb-4">
                <label for="inputState" class="col-md-12 text-md-left">{{__('auth.year')}}</label>
                <div class="col-md-12">
                    <select id="year_id" name="year" class="form-control @error('year') is-invalid @enderror" required>
                        <option value="" selected>{{__('auth.yearstandard')}}</option>
                        <option for="year" value="1">1 IMD</option>
                        <option for="year" value="2">2 IMD</option>
                        <option for="year" value="3">3 IMD</option>
                    </select>
                </div>
            </div>

            <div class="form-group my-3">
                <div class="col-md-12 text-left">
                    <input type="radio" id="no-buddy" name="buddy" value="0" checked>
                    <label for="no-buddy">{{__('auth.nobuddy')}}</label><br>
                    <input type="radio" id="buddy" name="buddy" value="1">
                    <label for="buddy">{{__('auth.buddy')}}</label><br>
                </div>
            </div>


            <div class="form-group mb-4">
                <label for="password" class="col-md-12 text-md-left">{{ __('auth.password') }}</label>

                <div class="col-md-12">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="password-confirm" class="col-md-12 text-md-left">{{ __('auth.confirm') }}</label>

                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group mb-0">
                <div id="message">

                </div>
                <label for="types" class="col-md-12 text-md-left">{{__('auth.tags')}}</label>
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

            <div class="form-group my-4 text-left">
                <button type="submit" class="btn btn-primary w-50">
                    {{ __('app.register') }}
                </button>
            </div>

            <div class="form-group mb-4 text-left">
                <a href="{{ route('login', app()->getLocale()) }}" class="btn btn-primary">{{__('auth.account')}}</a>
            </div>
        </form>
        <div class="pt-3">
            @foreach(config('app.available_locales') as $locale)
            <a class="nav-link d-inline pb-1" @if(app()->getLocale() == $locale) style="border-bottom: 1px solid #3490dc; transition" @endif href="{{ route(Route::currentRouteName(), $locale)}}">{{ strtoupper($locale) }}</a>
            @endforeach
        </div>
        <div class="my-4">&copy; Interactive Multimedia Design, 2020</div>
    </div>
</div>
@endsection