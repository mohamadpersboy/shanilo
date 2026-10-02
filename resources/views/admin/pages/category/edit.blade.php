@extends('admin.master')

@section('admin.category.index', 'active')

 @section('content')
     <div class="paper_style1">
         <div class="title_style1 {{__('content.float')}}">
             <p class="title1">دسته بندی - گروه اصلی - ویرایش گروه</p>
             <p class="title2">از این بخش میتوانید دسته بندی مورد نظر را ویرایش نمائید</p>
         </div>
         <div class="clear"></div>
         <hr class="hr_style1 marginb20 margint20">

         @include('admin.layouts.formResult')

         <form method="post" class="form-horizontal form-contact-us-validation"
               action="{{route('admin.category.update', ['category' => $category->id])}}" enctype="multipart/form-data" data-valid-form>
             {{csrf_field()}}
             {{ method_field('PATCH') }}
             <div class="form_style2">
                 <ul class="list clearfix">

                     <li class="item fright width100">
                         <p class="field_label">عنوان :<i class="required_style1">*</i></p>
                         <div class="item_inner">
                             <input type="text" name="title" value="{{ $category->title }}" data-valid-required>
                         </div>
                     </li>

                     <li class='item fright width100' id='file_cropper'>
                         <div class='clearfix'></div>
                         <div class='title_style4'>{{__('content.image')}}<i class="required_style1">*</i></div>
                         <hr class='hr_style2 margint5'/>

                         {{--<p class='field_text'>--}}
                             {{--{{__('content.minimum_width_photo')}} : 250px /--}}
                             {{--{{__('content.minimum_height_photo')}} : 110px--}}
                             {{--{{__('content.max_file_size_allowed')}} : 700KB--}}
                         {{--</p>--}}
                         <div class='file_style1 file_style'>
                             <span class='file_label'>{{__('content.choose_file')}}</span>
                             <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='1' data-y='1' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                         </div>
                         <hr class='hr_style2 margint30'/>

                         <div class='cropper ltr tcenter' id='cropper1'>
                             <div class='data_remove_file_holder'>
                                 @php $image = $category->takeImage(); @endphp
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
                             <a href="{{route('admin.category.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                         </li>
                     </ul>
                 </div>
             </div>
         </form>
     </div>
@endsection

@section('js')
    @include('admin.developer.deleteFile')
@endsection

