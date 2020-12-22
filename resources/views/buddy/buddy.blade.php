@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    <h1 class="text-primary">{{__('app.talkwith')}} {{$buddy[0]->name}}</h1>
    <chat-component 
    placeholder="{{__('app.message')}}" 
    submit="{{__('auth.submit')}}" 
    buddyId="{{$buddy[0]->id}}" 
    buddyName="{{$buddy[0]->name}}"
    userName="{{Auth::user()->name}}"></chat-component>
</div>
@endsection
