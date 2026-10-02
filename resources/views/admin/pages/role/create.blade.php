@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="marginb100">
            <div class="title_style1 {{__('content.float')}}">
                <p class="title1">{{$header['create']['title']}}</p>
                <p class="title2">{{$header['create']['description']}}</p>
            </div>
        </div>

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.role.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">{{__('content.title_role')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="name" value="{{ old('name') }}">
                        </div>
                    </li>
                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">{{__('content.slug_role')}} ({{__('content.only_english')}}):<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="slug" value="{{ old('slug') }}" class="ltr tcenter en_words">
                        </div>
                    </li>

                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.description_role')}}</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea name="description">{{ old('description') }}</textarea>
                        </div>
                    </li>

                </ul>

                <hr class='hr_style2 margint10' />
                <div class='title_style4'>{{__('content.level_access')}}</div>
                <hr class='hr_style2 margint20' />

                <div class='picklist_style1 clearfix'>
                    <div class='picklist picklist_from'>
                        <select name='remove_permission[]' multiple='multiple' id='picklist'>
                            @foreach($data['permissions'] as $permission)
                                @if(!empty($permission->slug))
                                    <optgroup label="{{__('permission.'.$permission->name)}}" class="opt">
                                        @role('atlas-administrator')
                                            <option value='{{"create".'.'.$permission->name}}'>{{__('permission.create').' '.__('permission.'.$permission->name)}}</option>
                                            <option value='{{"update".'.'.$permission->name}}'>{{__('permission.update').' '.__('permission.'.$permission->name)}}</option>
                                            <option value='{{"view".'.'.$permission->name}}'>{{__('permission.view').' '.__('permission.'.$permission->name)}}</option>
                                            <option value='{{"delete".'.'.$permission->name}}'>{{__('permission.delete').' '.__('permission.'.$permission->name)}}</option>
                                        @else
                                            @foreach($permission->slug as $key => $value)
                                                <option value='{{$key.'.'.$permission->name}}'>{{__('permission.'.$key).' '.__('permission.'.$permission->name)}}</option>
                                            @endforeach
                                        @endrole
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                    </div><!--piclist_source-->

                    <div class='picklist_btn'>
                        @if(__('content.direction') == "rtl")
                            <button type='button' class='item left_all'><i class='i-angle-double-left-1'></i></button>
                            <button type='button' class='item left_selected'><i class='i-angle-left'></i></button>
                            <button type='button' class='item right_selected'><i class='i-angle-right'></i></button>
                            <button type='button' class='item right_all'><i class='i-angle-double-right'></i></button>
                        @else
                            <button type='button' class='item left_all'><i class='i-angle-double-right'></i></button>
                            <button type='button' class='item left_selected'><i class='i-angle-right'></i></button>
                            <button type='button' class='item right_selected'><i class='i-angle-left'></i></button>
                            <button type='button' class='item right_all'><i class='i-angle-double-left-1'></i></button>
                        @endif
                    </div><!--piclist_btn-->

                    <div class='picklist picklist_to'>
                        <select name='add_permission[]' multiple='multiple'>
                        </select>
                    </div><!--piclist_destination-->
                </div>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="{{__('content.save_and_continue')}}" class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.role.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection

{{--Active Menu--}}
@section('admin.role.create','active')
{{--End Active Menu--}}

{{--Pick_list--}}
@section('pick_list')
    @include('admin.developer.pick_list')
@endsection
{{--End Pick_list--}}