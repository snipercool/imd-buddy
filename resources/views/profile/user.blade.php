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
                        <div>
                            <a href="#" class="btn btn-primary my-2">{{__('app.sendRequest')}}</a>
                        </div>
                    </div>
                    <div class="text-center text-sm-right">
                        <div class="text-muted"><small>{{__('profile.joined')}} {{$created}}</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection