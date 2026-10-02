@extends('admin.master')
@section('content')

    @if($news)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_news')}}</p>
                <p class="title2">{{__('content.create_news')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.news.update',$news->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">{{__('content.title_news')}}:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="title" value="{{$news->title}}" placeholder="{{__('content.write_title_news')}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">{{__('content.source_news')}}:</p>
                            <div class="item_inner">
                                <input type="text" name="source" value="{{$news->source}}" placeholder="{{__('content.write_source_news')}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">{{__('content.source_link_news')}} ({{__('content.only_english')}}):</p>
                            <div class="item_inner">
                                <input type="text" name="link" value="{{$news->link}}" class="ltr tcenter en_words" placeholder="{{__('content.write_source_link_news')}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width100">
                            <hr class="hr_style2 margint15">
                            <p class="field_label">اخبار مرتبط:</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <select name="related_news[]" id="related_news" class="js-example-basic-single"
                                        multiple="true">
                                    @foreach($relatedNews as $index=>$relatedNew)
                                        <option value="{{$relatedNew->id}}" {{in_array($relatedNew->id,$relatedNewIds)?'selected':''}}>{{$relatedNew->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}}">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">{{__('content.news_summery')}}</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="summery" placeholder="{{__('content.write_news_summery')}}">{{$news->summery}}</textarea>
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">{{__('content.content_news')}}</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea data-tinymce name="description">{{$news->description}}</textarea>
                            </div>
                        </li>

                        <li class='item fright width100' id='file_cropper'>
                            <div class='clearfix'></div>
                            <div class='title_style4'>{{__('content.image_news')}}</div>
                            <hr class='hr_style2 margint5'/>

                            <p class='field_text'>
                                {{__('content.minimum_width_photo')}} : 250px /
                                {{__('content.minimum_height_photo')}} : 110px
                                {{--                            {{__('content.max_file_size_allowed')}} : 700KB--}}
                            </p>
                            <div class='file_style1 file_style'>
                                <span class='file_label'>{{__('content.choose_file')}}</span>
                                <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='8.4' data-y='4' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                            </div>
                            <hr class='hr_style2 margint30'/>

                            <div class='cropper ltr tcenter' id='cropper1'>
                                <div class='data_remove_file_holder'>
                                    @php $image = $news->takeImage(); @endphp
                                    <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file data-scope='#file_cropper' data-input-name='pic' data-table='' data-pic-place='.cropper_preview' data-pic-default="{{$image}}" data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                    <span class='pic_style1' onClick="$('input[name=pic]').click();">
                                        <span class='inner cropper_preview' style="background-image:url({{$image}});background-size: contain;width:296px;height:200px;"></span>
                                    </span>
                                </div><!--data_remove_file_holder-->
                                <div class='cropper_holder' style='width:500px;max-height:190px;'></div>
                                <input data-crop-x type='hidden' name='cropper[x]' value=''>
                                <input data-crop-y type='hidden' name='cropper[y]' value=''>
                                <input data-crop-w type='hidden' name='cropper[w]' value=''>
                                <input data-crop-h type='hidden' name='cropper[h]' value=''>
                            </div>
                        </li>


                    </ul>

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="{{route('admin.news.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_newss'))

{{--Active Menu--}}
@section('admin.news.index','active')
{{--End Active Menu--}}

{{--Editor--}}
@section('editor')
    @include('admin.developer.tinymce')
@endsection
{{--End Editor--}}

{{--Cropper--}}
@section('cropper')
    @include('admin.developer.cropper')
@endsection
{{--End Cropper--}}
{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}