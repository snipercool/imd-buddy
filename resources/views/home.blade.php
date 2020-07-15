@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    @if(Auth::user())

    @endif
    @if(Auth::guest())
    <h1 class='text-primary'>{{__('app.allusers')}}</h1>
    @elseif (Auth::user()->buddy == 0)
    <h1 class='text-primary'>{{__('app.hi')}}, {{__('auth.buddy')}}</h1>
    @elseif (Auth::user()->buddy == 1)
    <h1 class='text-primary'>{{__('app.hi')}}, {{__('auth.nobuddy')}}</h1>
    @endif
    @foreach($data->sortBy('created_at') as $user)
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
        </div>
    </div>
    @endforeach
</div>

@endsection