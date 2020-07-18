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
                    @php
                    $skills = DB::table('user_tags')->where('user_id', $user->id)->get()
                    ->map(function ($tags) {
                    return [
                    'id' => $tags->id,
                    'value' => $tags->tag_id,
                    ];
                    });
                    foreach ($skills as $tag => $value)
                    $tags[] = Db::table('tags')->where('id', $value)->first();
                    foreach ($tags as $tag){
                    echo $tag->name . ', ';
                    }
                    @endphp
                </div>
            </div>
            <div class="row mt-2">
            <div class="col-md-10 mx-auto">
                <form action="{{ route('userprofile',  app()->getLocale()) }}">
                <input type="hidden" name="name" value="{{$user->name}}">
                <input type="hidden" name="surname" value="{{$user->surname}}">
                <button type="submit" class="btn btn-primary">{{__('profile.goProfile')}}</button>
                </form>
                <a href="#" class="btn btn-primary my-2">{{__('app.sendRequest')}}</a>
            </div>
            </div>
        </div>
    </div>