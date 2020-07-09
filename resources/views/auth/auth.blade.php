<ul class=" nav justify-content-end">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login', app()->getLocale()) }}">{{__('app.login')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register', app()->getLocale()) }}">{{__('app.register')}}</a>
    </li>
</ul>