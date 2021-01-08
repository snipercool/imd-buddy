<div class="form-group mb-3 text-left">
    <label class="mb-1" for="{{$label}}">{{$labelname}}</label>
    <input type="{{$type}}" class="form-control @error('{{$type}}') is-invalid @enderror" name="{{$label}}" id="{{$label}}" value="{{ old('$label') }}" placeholder="{{$placeholder}}" required>
</div>