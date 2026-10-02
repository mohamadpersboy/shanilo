@extends('admin.master')

@section('admin.category2.index', 'active')

 @section('content')

     <div class="paper_style1">
         <div class="title_style1 {{__('content.float')}}">
             <p class="title1">دسته بندی محصولات - زیر گروه ها - ویرایش گروه</p>
             <p class="title2">از این بخش میتوانید زیر گروه های دسته بندی محصولات سایت را ویرایش نمائید</p>
         </div>
         <div class="clear"></div>
         <hr class="hr_style1 marginb20 margint20">

         @include('admin.layouts.formResult')

         <form method="post" class="form_validationn" action="{{route('admin.category2.update', ['category' => $category->id])}}" enctype="multipart/form-data" data-valid-form>
             {{csrf_field()}}
             {{ method_field('PATCH') }}
             <div class="form_style2">
                 <ul class="list clearfix">

                     <li class='item fright width100 pos_rel '>
                         <p class='field_label'>گروه اصلی :<i class="required_style1">*</i></p>
                         <div class='item_inner'>
                             <div class='select_style3 select_style tcenter '>
                                 <i class='select_arrow i-angle-down'></i>
                                 <select data-select-box name='parent_id' data-valid-required>
                                     <option value=''>-- انتخاب گروه اصلی --</option>
                                     @foreach($data['categoriesFirstLevel'] as $categoryItem)
                                         <option value='{{ $categoryItem->id }}' @if($categoryItem->id == $category->parent_id) selected="selected" @endif>{{ $categoryItem->name }}</option>
                                     @endforeach
                                 </select>
                             </div><!--select_style3-->
                         </div>
                     </li>

                     <li class="item fright width100">
                         <p class="field_label">عنوان :<i class="required_style1">*</i></p>
                         <div class="item_inner">
                             <input type="text" name="name"  value="{{ $category->name }}" data-valid-required>
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