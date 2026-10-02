<li class="item {{__('content.float')}} width100">
    <p class="field_label">{{$inputLabel}}:<i class="required_style1">*</i></p>
    <div class="item_inner">
        <input type="text" @if(isset($inputClass)) class="{{$inputClass}}" @endif name="{{$inputName}}" @if(isset($inputValue)) value="{{$inputValue}}" @endif @if(isset($placeholder)) placeholder="{{$placeholder}}" @endif>
    </div>
</li>