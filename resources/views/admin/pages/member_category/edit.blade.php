@extends('admin.master')
@section('content')

    @if($member_category)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_member_category')}}</p>
                <p class="title2">{{__('content.create_member_category')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.member_category.update',$member_category->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">{{__('content.title_member_category')}}:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="title" value="{{$member_category->title}}" placeholder="{{__('content.write_title_member_category')}}">
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
                                <a href="{{route('admin.member_category.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_member_categorys'))

{{--Active Menu--}}
@section('admin.member_category.index','active')
{{--End Active Menu--}}