<div class="col-md-4 card border-0 d-inline-block mr-2" style='background: #E0F2F9'>
        <div class="card-body rounded px-2">
            <div class="mx-auto rounded-circle" style="height: 140px; width: 140px; background-image: url({{$user->avatar}}); background-size:cover;">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center mt-2"><strong>{{$user->name}} {{$user->surname}}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <p>{{$user->year}} IMD</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 mx-auto">
                   
                    @foreach ($tags as $t)
                     {{$t->name . ', '}}
                    @endforeach
                    
                </div>
            </div>
            <div class="row mt-2">
            <div class="col-md-10 mx-auto">
                <form action="{{ route('userprofile',  app()->getLocale()) }}">
                <input type="hidden" name="name" value="{{$user->name}}">
                <input type="hidden" name="surname" value="{{$user->surname}}">
                <button type="submit" class="btn btn-primary">{{__('profile.goProfile')}}</button>
                </form>
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
                    @elseif (Auth::user()->noMoreBuddy($user)) 
                    <button type="button" class="btn btn-info text-white text-left" disabled>{{__('app.noMoreBuddy')}}!</button>
                    @else
                    <a href="{{ route('buddyadd', ['locale' => app()->getLocale(), 'name' => $user->name, 'surname' => $user->surname]) }}" class="btn btn-primary my-2">{{__('app.sendRequest')}}</a>
                    @endif
                @elseif (Auth::user()->isBuddyWith($user)) 
                    <button type="button" class="btn btn-info text-white text-left" disabled>{{__('app.yourBuddy')}}!</button>

                @elseif (Auth::user()->noMoreBuddy($user)) 
                    <button type="button" class="btn btn-info text-white text-left" disabled>{{__('app.noMoreBuddy')}}!</button>
                @else
                    <button type="button" class="btn btn-secondary text-left" disabled>{{__('app.alreadyBuddy')}}</button>
                @endif
            </div>
            </div>
        </div>
    </div>