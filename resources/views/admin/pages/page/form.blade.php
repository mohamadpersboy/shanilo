<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">عنوان:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('title',null,['placeholder'=>'عنوان صفحه را وارد نمایید.']) !!}
            </div>
        </li>
        @role('atlas-administrator')
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">اسلاگ:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('slug',null,['placeholder'=>'اسلاگ صفحه را وارد نمایید.']) !!}
            </div>
        </li>
        @endrole
        <li class="item {{__('content.float')}} width100">
            <hr class="hr_style2 margint15">
            <p class="title_style4">خلاصه:</p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::textarea('summery',null,['placeholder'=>'خلاصه متن را وارد نمایید.']) !!}
            </div>
        </li>
     {{--   @if(isset($edit) && count($page->details))
            @foreach($page->details as $index=>$detail)
                <li class='item width100 {{__('content.float')}} dynamic-field'>
                    <ul class='width100 {{__('content.float')}}'>
                        <li class='item width50 {{__('content.float')}}'>
                            <div class='item_inner'>
                                {!! Form::text('option_title[]',$detail->title,['placeholder'=>__('content.option_title'),'class'=>'form-control input-lg']) !!}
                            </div>
                        </li>
                        <li class='item width50 {{__('content.float')}} nospace'>
                            <div class='item_inner'>
                                {!! Form::text('option_value[]',$detail->value,['placeholder'=>__('content.option_value'),'class'=>'form-control input-lg']) !!}
                            </div>
                        </li>
                    </ul>
                    @if($index>0)
                        <i class='i-minus-square marginr15 minus_style1 remove-dynamic-field {{__('content.float')}}'></i>
                    @endif
                    <i class='i-plus-square plus_style1 add-dynamic-field {{__('content.float')}}'></i>
                </li>
            @endforeach
        @else
            <li class='item width100 {{__('content.float')}} dynamic-field'>
                <ul class='width100 {{__('content.float')}}'>
                    <li class='item width50 {{__('content.float')}}'>
                        <div class='item_inner'>
                            {!! Form::text('option_title[]',null,['placeholder'=>__('content.option_title'),'class'=>'form-control input-lg']) !!}
                        </div>
                    </li>
                    <li class='item width50 {{__('content.float')}} nospace'>
                        <div class='item_inner'>
                            {!! Form::text('option_value[]',null,['placeholder'=>__('content.option_value'),'class'=>'form-control input-lg']) !!}
                        </div>
                    </li>
                </ul>
                <i class='i-plus-square plus_style1 add-dynamic-field {{__('content.float')}}'></i>
            </li>
        @endif--}}

        <li class="item {{__('content.float')}} width100">
            <hr class="hr_style2 margint15">
            <p class="title_style4">توضیحات:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::textarea('description',null,['placeholder'=>'توضیحات صفحه را وارد نمایید.','data-tinymce']) !!}
            </div>
        </li>

        <li class='item fright width100' id='file_cropper'>
            <div class='clearfix'></div>
            <div class='title_style4'> {{__('content.main_image')}} <i class="required_style1">*</i></div>
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
                       data-pic-default="{{isset($edit)?$page->takeImage('main',\App\Http\Controllers\Admin\Base\PageController::THUMBNAIL_SIZES[0]):asset('assets/admin/_images/default/default.png')}}"
                       data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                    <span class='pic_style1' onClick="$('input[name=pic]').click();"><span class='inner cropper_preview' style="background-image:url({{isset($edit)?$page->takeImage('main',\App\Http\Controllers\Admin\Base\PageController::THUMBNAIL_SIZES[0]):asset('assets/admin/_images/default/default.png')}});width:296px;height:200px;"></span></span>
                </div><!--data_remove_file_holder-->
                <div class='cropper_holder' style='width:500px;max-height:190px;'></div>
                <input data-crop-x type='hidden' name='cropper_main[x]' value=''>
                <input data-crop-y type='hidden' name='cropper_main[y]' value=''>
                <input data-crop-w type='hidden' name='cropper_main[w]' value=''>
                <input data-crop-h type='hidden' name='cropper_main[h]' value=''>
            </div>
        </li>
    {{--    @if(isset($edit))
            <!--group btn-->
            <li class='item' data-select-file-wrapper>
                <div class='clearfix'></div>
                <hr class='hr_style2 margint20'/>
                <div class='title_style4 noselect'>{{__('content.gallery_photos')}}</div>
                <hr class='hr_style2 margint15'/>
                <div class='file_style1 file_style uploadifive'>
                    <div class='file_btns'>
                        <a href="{{route('admin.product.galleryDestroy')}}" data-token="{{csrf_token()}}" class='btn_style5 bg_red hover_opac' data-remove-selected-file='data-select-file' style='display:none;'>
                            <i class='i-cancel icon'></i> {{__('content.gallery_remove_chosen_files')}}
                        </a>
                    </div>
                    <span class='file_label'>{{__('content.choose_file')}}</span>
                    <input id='uploadifive_gallery' type='file' name='pic_gallery' multiple='multiple' />
                </div>
                <hr class='hr_style2 margint30'/>

                <div class='pic_style2 tcenter'>
                    @foreach($page->attachments->where('slug','gallery') as $gallery)
                        <span class='pic_item' style='background-image:url({{$page->takeImageWithName($gallery->file_name)}});'
                              data-file-item data-view-pic-preview='{{$page->takeImageWithName($gallery->file_name)}}'>
                        <label class='checkradio_style3 noselect select_file'><input type='checkbox' name='id[]' value='{{$gallery->id}}' data-select-file><span class='box'></span></label>
                    </span>
                    @endforeach
                </div>
            </li>
        @endif--}}
    </ul>
    <hr class="hr_style1 marginb20 margint20">
   {{-- @if(isset($edit))
        <!--======================== MODAL : PIC_PREVIEW ==========================-->
        <div class='modal modal_over'>
            <div class='modal_scroll'>
                <div class='modal_dynamic'></div><!--modal_dynamic-->

                <div class='modal_static'>

                    <div class='window modalwin_style1' id='view_pic_preview'>
                        <i class='modal_close'>X</i>
                        <div class='inner'>
                            <div class='pic_preview' style="height: 300px;background-size: contain;background-repeat: no-repeat;"></div>
                        </div><!--inner-->
                    </div>

                </div><!--modal_static-->
            </div><!--modal_scroll-->
        </div><!--modal-->

    @endif--}}
    <div class="btn_group_style1">
        <ul class="list clearfix">
            <li class="item {{__('content.float')}}">
                <input type="submit" name="submit" value="{{__('content.submit')}}" class="btn_style2 green">
            </li>
        </ul>
    </div>
</div>
