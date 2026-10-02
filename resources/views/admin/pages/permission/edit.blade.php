@extends('admin.master')
@section('content')

    <div class="paper_style1">
        <div class="marginb100">
            <div class="title_style1 {{__('content.float')}}">
                <p class="title1">{{$header['edit']['title']}}</p>
                <p class="title2">{{$header['edit']['description']}}</p>
            </div>
        </div>

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.permission.update',$permission->id)}}" enctype="multipart/form-data">
            {{method_field('PATCH')}}
            {{csrf_field()}}
            <div class="form_style2">

                <ul class="list clearfix">
                    <li class="item {{__('content.float')}} width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.title_permission')}} ({{__('content.only_english')}}):<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input type="text" name="name" value="{{$permission->name}}" class="ltr tleft en_words" placeholder="{{__('content.write_title_permission')}}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.slug_permission')}} ({{__('content.only_english')}}):<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            @php $show = ""; $array_size = count($permission->slug);@endphp
                            @foreach($permission->slug as $key => $value)
                                @php
                                    if($array_size != 1){
                                        $show .= $key.",";
                                    } else {
                                        $show .= $key;
                                    }
                                    $array_size--;
                                @endphp
                            @endforeach
                            <input type="text" name="slug" class="form-control tokenfield input-lg" value="{{$show}}">
                         </div>
                     </li>

                 </ul>

                 <hr class="hr_style1 marginb20 margint5">

                 <div class="btn_group_style1">
                     <ul class="list clearfix">
                         <li class="item {{__('content.float')}}">
                             <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                         </li>
                         <li class="item {{__('content.float')}}">
                             <a href="{{route('admin.permission.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                         </li>
                     </ul>
                 </div>
             </div>
         </form>
     </div>

 @endsection

 {{--Active Menu--}}
 @section('admin.permission.index','active')
 {{--End Active Menu--}}

 {{--Delete Selected--}}
 @section('tag_input')
     @include('admin.developer.tag_manager')
 @endsection
 {{--End Delete Selected--}}