@extends('layouts.app')

@section('content')
<div class="d-flex login-container text-center row">
    <div class="col-md-6 col-lg-8 col-xxl-10 side-left">
    </div>
    <div class="col-md-6 col-lg-4 col-xxl-2 mt-5 mx-auto px-5">
        <img src="../images/svg/logo--blue.svg" alt="Logo" width="auto" class="mb-3" style="max-width: 330px;">
        <p class="mb-3">{{ __('app.login') }}</p>
        <form method="POST" action="{{ route('login', app()->getLocale()) }}">
            @csrf
            @include('components.input',[
            'label' => 'email',
            'labelname' => __('auth.email'),
            'type' => 'email',
            'placeholder' => 'r-nummer@student.thomasmore.be',
            ])
            @include('components.input',[
            'label' => 'password',
            'labelname' => __('auth.password'),
            'type' => 'password',
            'placeholder' => '***********',
            ])
            <div class="form-group row">
                <div class="col-md-6 offset-md-4 px-0 mb-2 mx-0">
                    <div class="form-check text-left">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('auth.remember') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <button type="submit" class="btn btn-primary w-50">
                    {{ __('app.login') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn btn-link text-left px-0" href="{{ route('password.request', app()->getLocale()) }}">
                    {{ __('auth.forgot') }}
                </a>
                @endif
                <a class="btn btn-primary" href="{{ route('register', app()->getLocale()) }}">{{__('auth.noaccount')}}</a>
            </div>
        </form>
        <div class="pt-3">
            @foreach(config('app.available_locales') as $locale)
            <a class="nav-link d-inline pb-1" @if(app()->getLocale() == $locale) style="border-bottom: 1px solid #3490dc; transition" @endif href="{{ route(Route::currentRouteName(), $locale)}}">{{ strtoupper($locale) }}</a>
            @endforeach
        </div>
        <div class="mt-4">&copy; Interactive Multimedia Design, 2020</div>
    </div>
    
</div>

@endsection