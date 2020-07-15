<ul class=" nav justify-content-end">
    <li class="nav-item">
        <a class="btn btn-primary mt-3 mx-4" href="{{ route('logout', app()->getLocale()) }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">{{trans('app.logout')}}</a>

        <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>