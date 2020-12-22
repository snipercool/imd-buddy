@if($errors->has('{{$errorName}}'))
<span class="invalid-feedback" role="alert">
    <strong>{{ $errors->$errorName }}</strong>
</span>
@endif