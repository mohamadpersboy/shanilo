<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">{{__('content.site_content_image_title')}}:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('title',null,['placeholder'=>__('content.site_content_image_title_plc')]) !!}
            </div>
        </li>
        @role('atlas-administrator')
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">{{__('content.site_content_image_name')}}:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('name',null,['placeholder'=>__('content.site_content_image_name_plc')]) !!}
            </div>
        </li>
        @endrole
        <li class="item {{__('content.float')}} width100">
            <hr class="hr_style2 margint15">
            <p class="title_style4">{{__('content.site_content_image_url')}}:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('url',null,['placeholder'=>__('content.site_content_image_url_plc')]) !!}
            </div>
        </li>
        <li class='item fright width100' id='file_cropper'>
            <div class='clearfix'></div>
            <div class='title_style4'> {{__('content.site_content_image')}} <i class="required_style1">*</i></div>
            <hr class='hr_style2 margint5'/>

            <p class='field_text'>
                {{__('content.minimum_width_photo')}} : 320px /
                {{__('content.minimum_height_photo')}} : 200px
                {{--                            {{__('content.max_file_size_allowed')}} : 700KB--}}
            </p>
            <div class='file_style1 file_style'>
                <span class='file_label'>{{__('content.choose_file')}}</span>
                <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic'
                       data-image-info data-width='0' data-height='0' data-file-style data-run-cropper
                       data-x='' data-y='' data-element='#cropper1'
                       onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
            </div>
            <hr class='hr_style2 margint30'/>

            <div class='cropper ltr tcenter' id='cropper1'>
                <div class='data_remove_file_holder'>
                    <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file
                       data-scope='#file_cropper' data-input-name='pic' data-table=''
                       data-pic-place='.cropper_preview'
                       data-pic-default="{{isset($edit)?$siteContentImage->takeImage('main','300/200'):asset('assets/admin/_images/default/default.png')}}"
                       data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                    <span class='pic_style1' onClick="$('input[name=pic]').click();"><span
                                class='inner cropper_preview'
                                style="background-image:url({{isset($edit)?$siteContentImage->takeImage('main','300/200'):asset('assets/admin/_images/default/default.png')}});width:296px;height:200px;"></span></span>
                </div><!--data_remove_file_holder-->
                <div class='cropper_holder' style='width:500px;max-height:190px;'></div>
                <input data-crop-x type='hidden' name='cropper_main[x]' value=''>
                <input data-crop-y type='hidden' name='cropper_main[y]' value=''>
                <input data-crop-w type='hidden' name='cropper_main[w]' value=''>
                <input data-crop-h type='hidden' name='cropper_main[h]' value=''>
            </div>
        </li>

    </ul>
    <hr class="hr_style1 marginb20 margint20">
    <div class="btn_group_style1">
        <ul class="list clearfix">
            <li class="item {{__('content.float')}}">
                <input type="submit" name="submit" value="{{__('content.submit')}}" class="btn_style2 green">
            </li>
        </ul>
    </div>
</div>
