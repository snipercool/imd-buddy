<ul class=" nav justify-content-end mt-3">
    <li class="nav-item">
        <a class="btn btn-primary" href="{{ route('login', app()->getLocale()) }}">{{__('app.login')}}</a>
    </li>
    <li class="nav-item">
        <a class="btn btn-primary mx-4" href="{{ route('register', app()->getLocale()) }}">{{__('app.register')}}</a>
    </li>
</ul>