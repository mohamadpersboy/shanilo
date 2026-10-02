<li class="item width100 {{__('content.float')}} editor_style">
    <hr class="hr_style2 margint15">
    <p class="title_style4">{{$inputLabel}}</p>
    <hr class="hr_style2 margint15">
    <div class="item_inner">
        <textarea data-tinymce name="{{$inputName}}">@if(isset($inputValue)){{$inputValue}}@endif</textarea>
    </div>
</li>