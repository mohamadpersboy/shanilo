@extends('admin.master')
@section('content')
    @permission('create.bank')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_bank')}}</p>
            <p class="title2">{{__('content.create_bank')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.bank.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item fright width50">
                        <p class="field_label">نام بانک:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name='title' value="{{old('title')}}" placeholder='به طور مثال پارسیان'>
                        </div>
                    </li>

                    <li class="item fright width50 nospace">
                        <p class="field_label">نام صاحب حساب:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name='name' value="{{old('name')}}" placeholder='نام صاحب حساب'>
                        </div>
                    </li>

                    <li class="item fright width50">
                        <p class="field_label">شماره حساب:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" class="ltr tleft" name='account_number' value="{{old('account_number')}}" placeholder='5404953584'>
                        </div>
                    </li>

                    <li class="item fright width50 nospace">
                        <p class="field_label">شماره کارت:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" class="ltr tleft" name='account_card' value="{{old('account_card')}}" placeholder='5022-2910-0131-4531' data-mask="0000-0000-0000-0000">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">شماره شبا:</p>
                        <div class="item_inner">
                            <input type="text" name="account_shaba" class="ltr tleft en_words" value="{{ old('account_shaba') }}" placeholder="IR040120020000005404953584">
                        </div>
                    </li>

                    <li class='item fright width100'>
                        <p class='field_label'> لوگو بانک :<i class='required_style1'>*</i></p>
                        <div class='file_style1 file_style'>
                            <span class='file_label'>--> انتخاب فایل</span>
                            <input type='file' accept='image/png' name='pic' data-file-style  data-image-info data-width='0' data-height='0' onChange='preview(this,$(".pic_preview_style1"));' class='valid_group1'/>
                        </div>
                        <hr class='hr_style2 margint25'/>
                        <div class='pic_preview_style1 img_width300 tcenter cursor_pointer' onClick='$("input[name=pic]").click();'></div>
                    </li>
                </ul>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="ثبت اطلاعات" class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    @endpermission

    @if(isset($data['objects']))
        @if(!$data['objects']->isEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">{{__('content.management_bank')}}</p>
                        <p class="title2">{{__('content.list_of_bank')}}</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                @permission('delete.bank')
                                <a href="{{route('admin.bank.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
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
                    <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            @permission('update.bank')
                            <th><i class="icon1 i-list-ol"></i></th>
                            @endpermission
                            @permission('delete.bank')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>نام بانک</th>
                            <th>نام صاحب حساب</th>
                            <th>{{__('content.tbl_creation_date')}}</th>
                            <th>{{__('content.tbl_date_modified')}}</th>
                            @permission('update.bank')
                            <th>{{__('content.tbl_status')}}</th>
                            <th>{{__('content.edit')}}</th>
                            @endpermission
                        </tr>
                        </thead>
                    </table>
                </div><!--table_style1-->
            </div>

        @else
                <div class="paper_style1">
                    <div class="title_style1">
                        <p class="title1">{{__('content.management_bank')}}</p>
                        <p class="title2">{{__('content.list_of_bank')}}</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_bank')}}</div>
                        </div>
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection


@section('PageHeading',__('content.management_bank'))

{{--Active Menu--}}
@section('admin.bank.index','active')
{{--End Active Menu--}}

{{--Delete Selected--}}
@section('delete_selected')
    @include('admin.developer.delete_selected')
@endsection
{{--End Delete Selected--}}

{{--Switchery--}}
@section('switching')
    @include('admin.developer.switching')
@endsection
{{--End Delete Selected--}}

{{--DataTable--}}
@section('datatable_url')
    url :"{{route('admin.bank.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.bank')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.bank')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'title', name: 'title' },
    { data: 'name', name: 'name' },
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    @permission('update.bank')
    { data: 'display', name: 'display'},
    { data: 'edit', name: 'edit', orderable: false, searchable: false},
    @endpermission
    ],
@endsection
@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}

{{--Sortable--}}
@section('sortable')
    @include('admin.developer.sortable')
@endsection
{{--End Sortable--}}
