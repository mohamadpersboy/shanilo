<div class="form-group">
    <label for="{{$inputName}}" class="control-label col-lg-2">{{$inputLabel}}</label>
    <div class="col-lg-9">
        <input @if(isset($inputValue)) value="{{$inputValue}}" @endif  @if(isset($inputTitle)) title="{{$inputTitle}}" @endif  @if(isset($placeholder)) placeholder="{{$placeholder}}" @endif name="{{$inputName}}" id="{{$inputName}}" type="number" class="form-control">
    </div>
</div>