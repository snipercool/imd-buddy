<div class="form-group text-left">
    <div id="message">

    </div>
    <label for="{{$label}}">{{trans('auth.tags')}}</label>
    <input type="text" class="form-control" id="{{$label}}" aria-describedby="{{$label}}" placeholder="{{$placeholder}}">
    <div class="suggestions">
        <ul id="suggestions" class="pl-0">

        </ul>
    </div>
    <span class="text-muted">{{trans('auth.tags')}}:
        <span id="traits"><input type="hidden" name="{{$label}}" value="" id="hiddenTags"></span>
    </span>

</div>