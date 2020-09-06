@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    <h1 class="text-primary">{{__('app.talkwith')}} {{$buddy[0]->name}}</h1>
    <div class="card">
        <div class="card-body minh">

        </div>
    </div>
    <div>
        <div class="input-group mb-3 mt-2">
            <input type="text" class="form-control" placeholder="{{__('app.message')}}" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary rounded-right rounded-0" type="button" id="button-addon2">{{__('auth.submit')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection