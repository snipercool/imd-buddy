@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-4 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    <div class="card">
        <div class="card-body">
            <h4>{{__('profile.changepass')}}</h4>
            <div class="tab-content pt-3">
                <form id="form2" action="{{ route('updatepassword', app()->getLocale()) }}" method="post">
                    @csrf
                        <div class="col-md-12 mb-2">
                        @if(Session::has('CurrentError'))
                        <div id="success" class="my-2 mx-0 alert alert-danger">
                            {{__('profile.CurrentError')}}
                        </div>
                        @endif
                        @if(Session::has('SameError'))
                        <div id="success" class="my-2 mx-0 alert alert-danger">
                            {{__('profile.SameError')}}
                        </div>
                        @endif
                            <div class="form-group">
                                <label>{{__('profile.currentpass')}}</label>
                                <input class="form-control" type="password" name="current-password" placeholder="••••••••" required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                        @if(Session::has('NewSameError'))
                        <div id="success" class="my-2 mx-0 alert alert-danger">
                            {{__('profile.NewSameError')}}
                        </div>
                        @endif
                            <div class="form-group">
                                <label>{{__('profile.newpass')}}</label>
                                <input class="form-control" type="password" name="new-password" placeholder="••••••••" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('profile.confirmpass')}}</label>
                                <input class="form-control" type="password" name="new-password_confirmation" placeholder="••••••••" required>
                            </div>
                    <div class="row">
                        <div class="col d-flex mt-4">
                            <button class="btn btn-primary" id="" type="submit">{{__('auth.submit')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection