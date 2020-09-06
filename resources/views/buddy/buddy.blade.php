@extends('layouts.app')

@include('partials.navbar')

@section('content')
<div class="col-md-10 mr-3 mt-5" style="margin-left: 7rem; max-width: 900px;">
    <h1 class="text-primary">{{__('app.talkwith')}} {{$buddy[0]->name}}</h1>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body minh overflow-auto">

                </div>
            </div>
            <div class="mt-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="{{__('app.message')}}" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="messageField">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="button-addon2">{{__('auth.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const app = new Vue({
        el: '#app',
        data: {
            messages: {},
            messageField: '',
        },
        mounted(){
            this.getMessagess();
        },
        methods: {
            getMessagess() {
                axios.get('/api/messagefetch')
                    .then((response) => {
                        this.messages = response.data
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            postMessage() {
                axios.post('/api/messagesend', {
                    api_token: this.user.api_token,
                    message: this.messageField
                })
                .then((response) => {
                    this.message.push(response.data);
                    this.messageField = '';
                })
                .catch(function (error) {
                    console.log(error);
                    
                });
                    
            }
        }
    });
</script>
@endsection