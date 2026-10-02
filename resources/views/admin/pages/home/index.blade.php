@extends('admin.master')

@section('content')
    <div class="set_admin_part1">
        <div class="paper_style1 clearfix">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">{{$header['list']['title']}}</p>
                    <p class="title2">{{$header['list']['description']}}</p>
                </div>
            </div>

            <div class="width50 {{__('content.float')}}">
                <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.admin.changePassword')}}">
                    {{csrf_field()}}
                    <div class="form_style2 clearfix">
                        <ul class="list">
                            <li class="item">
                                <p class="field_label">{{__('content.tbl_username')}}<i class="required_style1">*</i></p>
                                <div class="item_inner">
                                    <input type="text" name="email" value="{{Auth::guard('admins')->user()->email}}" class="ltr en_words">
                                </div>
                            </li>
                            <li class="item">
                                <p class="field_label">{{__('content.current_password')}}</p>
                                <div class="item_inner" data-toggle-pass="">
                                    <input type="password" name="current_password" class="ltr en_words">
                                    <span data-toggle-pass-icon="" class=""></span>
                                </div>
                            </li>
                            <li class="item">
                                <p class="field_label">{{__('content.password_new')}}</p>
                                <div class="item_inner" data-toggle-pass="">
                                    <input type="password" name="password" class="ltr en_words">
                                    <span data-toggle-pass-icon="" class=""></span>
                                </div>
                            </li>
                            <li class="item">
                                <p class="field_label">{{__('content.password_confirm')}}</p>
                                <div class="item_inner" data-toggle-pass="">
                                    <input type="password" name="password_confirmation" class="ltr en_words">
                                    <span data-toggle-pass-icon="" class=""></span>
                                </div>
                            </li>
                        </ul>
                    </div><!--form_style2-->
                    <hr class="hr_style1 marginb20 margint20">
                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}"><input type="submit" name="go_set_admin" value="{{__('content.save_changes')}}" class="btn_style2 green"></li>
                            <li class="item {{__('content.float')}}"><input type="reset" value="{{__('content.clearance_form')}}" class="btn_style2"></li>
                        </ul>
                    </div><!--btn_group_style1-->
                </form>
            </div>
            <div class="set_admin_bg {{__('content.floatr')}} width50"></div>
        </div><!--paper_style-->
    </div><!--set_admin_part1-->
@endsection