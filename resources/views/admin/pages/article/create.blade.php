@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_article')}}</p>
            <p class="title2">{{__('content.create_article')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.article.store')}}"
              enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">{{__('content.title_article')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{ old('title') }}"
                                   placeholder="{{__('content.write_title_article')}}">
                        </div>
                    </li>
                    {{--  <li class="item {{__('content.float')}} width50 nospace">
                          <p class="field_label">{{__('content.article_category')}}:<i class="required_style1">*</i></p>
                          <div class="item_inner">
                              <select name="article_category_id" id="article_category_id" class="js-example-basic-single">
                                  @foreach($categories as $index=>$category)
                                      <option value="{{$category->id}}">{{$category->title}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </li>--}}

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">{{__('content.source_article')}}:</p>
                        <div class="item_inner">
                            <input type="text" name="source" value="{{ old('source') }}"
                                   placeholder="{{__('content.write_source_article')}}">
                        </div>
                    </li>
                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">{{__('content.source_link_article')}} ({{__('content.only_english')}}
                            ):</p>
                        <div class="item_inner">
                            <input type="text" name="link" value="{{ old('link') }}" class="ltr tcenter en_words"
                                   placeholder="{{__('content.write_source_link_article')}}">
                        </div>
                    </li>
                    <li class="item {{__('content.float')}} width100">
                        <hr class="hr_style2 margint15">
                        <p class="field_label">مقالات مرتبط:</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <select name="related_articles[]" id="related_articles" class="js-example-basic-single"
                                    multiple="true">
                                @foreach($relatedArticles as $index=>$relatedArticle)
                                    <option value="{{$relatedArticle->id}}">{{$relatedArticle->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.article_summery')}}</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea name="summery" class="autosize"
                                      placeholder="{{__('content.write_summery')}}">{{ old('summery') }}</textarea>
                        </div>
                    </li>

                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.content_article')}}</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea data-tinymce name="description">{{ old('description') }}</textarea>
                        </div>
                    </li>

                    <li class='item fright width100' id='file_cropper'>
                        <div class='clearfix'></div>
                        <div class='title_style4'>{{__('content.image_article')}}</div>
                        <hr class='hr_style2 margint5'/>

                        <p class='field_text'>
                            {{__('content.minimum_width_photo')}} : 250px /
                            {{__('content.minimum_height_photo')}} : 110px
                            {{--                            {{__('content.max_file_size_allowed')}} : 700KB--}}
                        </p>
                        <div class='file_style1 file_style'>
                            <span class='file_label'>{{__('content.choose_file')}}</span>
                            <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic'
                                   data-image-info data-width='0' data-height='0' data-file-style data-run-cropper
                                   data-x='8.4' data-y='4' data-element='#cropper1'
                                   onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                        </div>
                        <hr class='hr_style2 margint30'/>

                        <div class='cropper ltr tcenter' id='cropper1'>
                            <div class='data_remove_file_holder'>
                                <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file
                                   data-scope='#file_cropper' data-input-name='pic' data-table=''
                                   data-pic-place='.cropper_preview'
                                   data-pic-default="{{asset('assets/admin/_images/default/default.png')}}"
                                   data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                <span class='pic_style1' onClick="$('input[name=pic]').click();">
                                    <span class='inner cropper_preview'
                                          style="background-image:url({{asset('assets/admin/_images/default/default.png')}});background-size: contain;width:300px;height:228px;"></span>
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
                            <input type="submit" name="submit" value="{{__('content.save_and_continue')}}"
                                   class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.article.index')}}"
                               class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('PageHeading',__('content.management_article'))

{{--Active Menu--}}
@section('admin.article.create','active')
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