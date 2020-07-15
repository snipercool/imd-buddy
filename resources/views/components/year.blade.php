<div class="form-group text-left">
    <label for="inputState">
        {{ Form::label($label, $placeholder ) }}
    </label>
    <select id="{{$id}}" name="{{$label}}" class="form-control">
        <option value="" selected>{{ $standard }}</option>
        <option for="{{$label}}" value="1">1 IMD</option>
        <option for="{{$label}}" value="2">2 IMD</option>
        <option for="{{$label}}" value="3">3 IMD</option>
    </select>
</div>