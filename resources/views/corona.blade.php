@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    <h1 class="text-primary mb-5">Corona update:</h1>
    <table class="table table-hover">
        <thead class="bg-primary text-white">
            <tr>
                <th scope="col">{{__('app.country')}}</th>
                <th scope="col">{{__('app.confirmed')}}:</th>
                <th scope="col">{{__('app.dead')}}:</th>
                <th scope="col">{{__('app.recovered')}}:</th>
            </tr>
        </thead>
        <tbody id="corona">
            <tr>
                <th scope="col">Global</th>
                <th scope="col">{{$data['confirmed']}}</th>
                <th scope="col">{{$data['dead']}}</th>
                <th scope="col">{{$data['recovered']}}</th>
            </tr>
        </tbody>
    </table>
</div>
@endsection