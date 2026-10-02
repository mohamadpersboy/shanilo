<li class="item width100 {{__('content.float')}} editor_style">
    <hr class="hr_style2 margint15">
    <p class="title_style4">{{$inputLabel}}<i class="required_style1">*</i></p>
    <hr class="hr_style2 margint15">
    <div class="item_inner">
        <textarea @if(isset($placeholder)) placeholder="{{$placeholder}}" @endif cols="" @if(isset($inputRow)) rows="{{$inputRow}}" @endif @if(isset($inputTitle)) title="{{$inputTitle}}" @endif name="{{$inputName}}" id="{{$inputName}}" class="autosize">@if(isset($inputValue)){{$inputValue}}@endif</textarea>
    </div>
</li>