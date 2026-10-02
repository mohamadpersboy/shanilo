<div class="form-group">
    <label for="{{$inputName}}" class="control-label col-lg-2">{{$inputLabel}}</label>
    <div class="col-lg-9">
        <input  @if(isset($placeholder)) placeholder="{{$placeholder}}" @endif @if(isset($inputTitle)) title="{{$inputTitle}}" @endif name="{{$inputName}}" id="{{$inputName}}" type="password" class="form-control">
    </div>
</div>