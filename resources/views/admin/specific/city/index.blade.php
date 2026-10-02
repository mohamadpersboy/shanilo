@extends('admin.master')
@section('content')
    @if(isset($cities) && $cities)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت شهرها</p>
                    <p class="title2">نمایش شهرها</p>
                </div>
            </div>
            <hr class="hr_style2 margint30">
            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                            <a href="#" class="btn_style2 green data_table_load hide"><img
                                        src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}"/></a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="hr_style2 margint20">
            <div class="table_style1">
                <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        @permission('update.city')
                        <th><i class="icon1 i-list-ol"></i></th>
                        @endpermission
                        <th>{{__('content.tbl_title')}}</th>
                        <th>استان</th>
                        <th style="width: 20%;">کد شهر</th>
                        <th style="width: 20%;">کد استان</th>
                        @permission('update.city')
                        <th>ویرایش</th>
                        @endpermission
                    </tr>
                    </thead>
                </table>
            </div><!--table_style1-->
        </div>
    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">مدیریت شهرها</p>
                <p class="title2">نمایش شهرها</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <div class="form_style2">
                <div class="result_style2 disable_max_width sign i">
                    <div class="text icon">در حال حاضر هیچ آیتمی وجود ندارد.</div>
                </div>
            </div><!--paper_style-->
        </div>
    @endif
@endsection

{{--Active Menu--}}
@section('admin.city.index','active')
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
{{--End Switchery--}}

{{--DataTable--}}
@section('datatable_url')
    url :"{{route('admin.city.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.city')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    { data: 'name', name: 'name' },
    { data: 'state_id', name: 'state.name' },
    { data: 'code', name: 'code' },
    { data: 'state_code', name: 'state_code' },
    @permission('update.city')
    { data: 'update_button', name: 'update_button', orderable: false, searchable: false},
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

@section('js')
    @include('admin.developer.select2')

    <script>
        var updateUrl = "{{url('/adminforshanilo/city')}}/";
        $(function () {
            $(document.body).on('click', '.btn-update', function () {
                var id = $(this).closest('tr').data('itemid'),code=$(this).closest('tr').find("[name='code']").val(),state_code=$(this).closest('tr').find("[name='state_code']").val(), url = updateUrl + id, data = {
                    code:code ,
                    state_code:state_code ,
                    _token: $("[name='csrf-token']").attr('content'),
                    _method: 'PATCH'
                };
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                       alert(response.message);
                    }, error: function (error) {
                        alert('خطا');
                    }, complete: function () {

                    }
                });
            });


        });
    </script>
@endsection