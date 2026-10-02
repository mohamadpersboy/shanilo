@extends('admin.master')

@section('content')
    @if(isset($data['tickets']) && !$data['tickets']->isEmpty())
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">جستجوی پیشرفته</p>
            </div><!--title_style1-->
            <hr class="hr_style1 margint5 marginb15">
            <form method="POST" id="search-form" class="form-inline" role="form">
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item fright width33_3">
                            <div class='item_inner'>
                                <select name="user_id" class="js-example-basic-single" data-placeholder="انتخاب کاربر">
                                    <option value="">انتخاب کاربر</option>
                                    @foreach($data['users'] as $user)
                                        <option value="{{$user->id}}">{{getUsersFullName($user)}} - {{$user->mobile}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li class="item fright width33_3">
                            <div class="item_inner">
                                <select name="code" class="js-example-basic-single" data-placeholder="انتخاب شماره درخواست">
                                    <option value="">انتخاب شماره درخواست</option>
                                    @foreach($data['tickets'] as $ticket)
                                        <option value="{{$ticket->code}}">{{$ticket->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li class="item fright width33_3 nospace">
                            <div class="item_inner">
                                <select name="priority" class="js-example-basic-single" data-placeholder="بر اساس اولویت">
                                    <option value="">بر اساس اولویت</option>
                                    <option value="1">پایین</option>
                                    <option value="2">متوسط</option>
                                    <option value="3">فوری و مهم</option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div><!--form_style2-->
                <hr class="hr_style1 margint5 marginb10">
                <div class="btn_group_style1" id="viewport1">
                    <ul class="list clearfix">
                        <li class="item fright">
                            <input type="submit" value="جستجو نمائید" class="btn_style2 green search_button">
                        </li>
                        <li class="item fright"><button type="reset" class="btn_style2" onclick="clear_search()">لغو جستجو</button></li>
                    </ul>
                </div><!--btn_group_style1-->
            </form>
        </div>

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
                            @permission('delete.ticket')
                            <a href="{{route('admin.ticket.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                            @endpermission
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                            <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                        </li>
                        <li class="item {{__('content.float')}}">
                            <form id='frm_page_status' method='get'>
                                <div class='select_style select_style2 height36'>
                                    <span class='select_label'>در انتظار پاسخ</span>
                                    <i class='select_arrow i-angle-down'></i>
                                    <select name='status'>
                                        <option value='1' selected="selected" data-change-bgcolor='#e7f3fd'>در انتظار پاسخ</option>
                                        <option value='2' data-change-bgcolor='#e7fdeb'>پاسخ داده شده</option>
                                        <option value='99' data-change-bgcolor='#fde7e7'>حذف شده</option>
                                        <option value='4' data-change-bgcolor='#fff'>همه موارد</option>
                                    </select>
                                </div><!--select_style2-->
                            </form>
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
                        @permission('delete.ticket')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>شماره درخواست</th>
                        <th>ارسال کننده</th>
                        <th>موضوع درخواست</th>
                        <th>تاریخ آخرین بروزرسانی</th>
                        <th>اولویت</th>
                        <th>وضعیت</th>
                        @permission('update.ticket')
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
@section('admin.ticket.index','active')
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
    url :"{{route('admin.ticket.DataTable')}}",
    data: function (d) {
        d.status = $('select[name=status]').val();
        d.user_id = $('select[name=user_id]').val();
        d.code = $('select[name=code]').val();
        d.priority = $('select[name=priority]').val();
        d._token = _token;
    },
@endsection
@section('datatable_source')
    "order": [[ 4, "desc" ]],
    "columns": [
    @permission('delete.ticket')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'code', name: 'code' },
    { data: 'user_id', name: 'user_id', orderable: true, searchable: true,class:'tright'},
    { data: 'title', name: 'title' },
    { data: 'updated_at', name: 'updated_at' },
    { data: 'priority', name: 'priority' },
    { data: 'status', name: 'status', orderable: false, searchable: false,class:'color_bg_change'},
    @permission('update.ticket')
    { data: 'edit', name: 'edit', orderable: false, searchable: false},
    @endpermission
    ],
@endsection
@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}