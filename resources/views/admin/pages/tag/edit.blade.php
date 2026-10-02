@extends('admin.master')

@section('admin.tag.index', 'active')

 @section('content')
     <div class="paper_style1">
         <div class="title_style1 {{__('content.float')}}">
             <p class="title1">تگ محصولات - گروه اصلی - ویرایش گروه</p>
             <p class="title2">از این بخش میتوانید به لیست تگ محصولات سایت در گروه اصلی آیتم جدید اضافه نمائید</p>
         </div>
         <div class="clear"></div>
         <hr class="hr_style1 marginb20 margint20">

         @include('admin.layouts.formResult')

         <form method="post" class="form-horizontal form-contact-us-validation"
               action="{{route('admin.tag.update', ['tag' => $tag->id])}}" enctype="multipart/form-data" data-valid-form>
             {{csrf_field()}}
             {{ method_field('PATCH') }}
             <div class="form_style2">
                 <ul class="list clearfix">

                     <li class="item fright width100">
                         <p class="field_label">عنوان :<i class="required_style1">*</i></p>
                         <div class="item_inner">
                             <input type="text" name="name" value="{{ $tag->name }}" data-valid-required>
                         </div>
                     </li>

                 </ul>

                 <hr class="hr_style1 marginb20 margint20">

                 <div class="btn_group_style1">
                     <ul class="list clearfix">
                         <li class="item {{__('content.float')}}">
                             <input type="submit" name="submit" value="{{__('content.save_changes')}}"
                                    class="btn_style2 green">
                         </li>
                     </ul>
                 </div>
             </div>
         </form>
     </div>
@endsection