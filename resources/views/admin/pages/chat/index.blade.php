@extends('admin.master')

@section('content')

    @permission('create.chat')
        <div class="paper_style1">

            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">{{$header['create']['title']}}</p>
                    <p class="title2">{{$header['create']['description']}}</p>
                </div>
            </div>

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.chat.store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">

                        <li class="item width100 {{__('content.float')}}">
                            <div class='item_inner'>
                                <select name="user_id" class="js-example-basic-single" data-placeholder="انتخاب کاربر">
                                    <option value="">انتخاب کاربر</option>
                                    @foreach($data['allUsers'] as $user)
                                        <option value="{{$user->id}}">{{$user->fullName()}} - {{$user->mobile}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="body" class="autosize">{{ old('body') }}</textarea>
                            </div>
                        </li>

                    </ul>

                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" value="ارسال پیام" class="btn_style2 green">
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    @endpermission

    @if($data['chats'])

        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">{{$header['list']['title']}}</p>
                    <p class="title2">{{$header['list']['description']}}</p>
                </div>
            </div>

            <hr class="hr_style2 margint30">

            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            @permission('delete.chat')
                            <a href="{{route('admin.chat.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                            @endpermission
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                            <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="hr_style2 margint20">
            <div class="table_style1">
                <div data-loading='loadingDataTable'><div id='as-preloading-wrapper'><div class='as-preloader'><span></span><span></span><span></span><span></span><span></span><span></span></div></div></div>
                <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        @permission('delete.chat')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>عکس کاربر</th>
                        <th>اطلاعات کاربر</th>
                        <th>تاریخ آخرین بروزرسانی</th>
                        <th>وضعیت</th>
                        @permission('update.chat')
                        <th>مشاهده پیام</th>
                        @endpermission
                    </tr>
                    </thead>
                </table>
            </div><!--table_style1-->
        </div>

    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{$header['list']['title']}}</p>
                <p class="title2">{{$header['list']['description']}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <div class="form_style2">
                <div class="result_style2 disable_max_width sign i">
                    <div class="text icon">هیچ موردی یافت نشد.</div>
                </div>
            </div><!--paper_style-->
        </div>
    @endif
@endsection

{{--Active Menu--}}
@section('admin.message','active')
@section('admin.chat.index','active')
{{--End Active Menu--}}

{{--Delete Selected--}}
@section('delete_selected')
    @include('admin.developer.delete_selected')
@endsection
{{--End Delete Selected--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

{{--DataTable--}}
@section('datatable_url_data')
    url :"{{route('admin.chat.DataTable')}}",
    data: function (d) {
        d.status = $('select[name=status]').val();
        d.user_id = $('select[name=user_id]').val();
        d.code = $('select[name=code]').val();
        d.priority = $('select[name=priority]').val();
        d._token = _token;
    },
@endsection
@section('datatable_source')
    "order": [],
    "columns": [
    @permission('delete.chat')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'userImage', name: 'userImage', orderable: false, searchable: false},
    { data: 'users', name: 'users', orderable: false, searchable: false,class:'tright'},
    { data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
    { data: 'status', name: 'status', orderable: false, searchable: false,class:'color_bg_change'},
    @permission('update.chat')
    { data: 'edit', name: 'edit', orderable: false, searchable: false},
    @endpermission
    ],
@endsection
@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}