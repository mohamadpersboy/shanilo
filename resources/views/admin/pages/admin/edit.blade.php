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

        <form method="post" class="form-horizontal form-contact-us-validation"
              action="{{route('admin.admin.update',$data['admin']->id)}}" enctype="multipart/form-data">
            {{method_field('PATCH')}}
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">{{__('content.tbl_name')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="name" value="{{ $data['admin']->name }}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">{{__('content.tbl_family_name')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="family" value="{{ $data['admin']->family }}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">{{__('content.tbl_username_email')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="email" class="ltr en_words" value="{{ $data['admin']->email }}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">{{__('content.tbl_password')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner" data-toggle-pass="">
                            <input type="password" name="password" class="ltr en_words valid" id="pass" aria-required="true" aria-invalid="false">
                            <span data-toggle-pass-icon="" class=""></span>
                        </div>
                    </li>

                    <li class='item select width100 fright margint5'>
                        <hr class="hr_style2 margint10">
                        <div class="title_style4">{{__('content.choose2')}} {{__('content.tbl_role_admin')}}</div>
                    </li>

                    @php
                        $array = array();
                        foreach($data['admin']->getRoles() as $key => $value){ array_push($array,$key); }
                    @endphp
                    <li class='item select width100 fright margint5'>
                        <div class='item_inner'>
                            <select name="role[]" class="js-example-basic-single" multiple="multiple" data-placeholder="{{__('content.choose2')}} {{__('content.tbl_role_admin')}}">
                                @foreach($data['roles'] as $role)
                                    <option value="{{$role->id}}" {{ (in_array($role->id,$array) ? "selected":"") }}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>

                </ul>

                <hr class="hr_style1 marginb20 margint5">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="{{__('content.save_and_continue')}}" class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.admin.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection

{{--Active Menu--}}
@section('admin.admin.index','active')
{{--End Active Menu--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}