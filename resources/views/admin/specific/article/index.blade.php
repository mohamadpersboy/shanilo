@extends('admin.master')
@section('content')
    @if (isset($articles) && $articles)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{ __('content.float') }}">
                    <p class="title1">مدیریت مقالات وبسایت</p>
                    <p class="title2">نمایش مقالات</p>
                </div>
            </div>
            <hr class="hr_style2 margint100">
            <div class="clearfix">
                <div class="btn_group_style1 {{ __('content.float') }}">
                    <ul class="list clearfix">
                        <li class="item fright">
                            <a class="active-article-button btn_style2 green">فعال کردن</a>
                        </li>
                        <li class="item fright">
                            <a class="deactive-article-button btn_style2 danger">غیر فعال کردن</a>
                        </li>
                        <li class="item {{ __('content.float') }}">
                            @permission('delete.article')
                                <a href="{{ route('admin.article.destroy', 'all') }}" data-colspan="6"
                                    class="btn_style4 red delete_from_list">{{ __('content.remove_items') }}<i
                                        class="icon i-trash-o"></i></a>
                                @endpermission
                            </li>
                            <li class="item {{ __('content.float') }}">
                                <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                                <a href="#" class="btn_style2 green data_table_load hide"><img
                                        src="{{ asset('assets/admin/_images/loading/ajax-loader.gif') }}" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="hr_style2 margint20">
                <div class="table_style1">
                    <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                @permission('update.article')
                                    <th><i class="icon1 i-list-ol"></i></th>
                                    @endpermission
                                    @permission('delete.article')
                                        <th><label class="checkradio_style1 type2"><input type="checkbox" name=""
                                                    data-select-all="data-select-row"><span class="box"></span></label></th>
                                        @endpermission
                                        <th>{{ __('content.tbl_image') }}</th>
                                        <th>{{ __('content.tbl_title') }}</th>
                                        <th>کاربر</th>
                                        <th>فروشگاه</th>
                                        <th>{{ __('content.tbl_creation_date') }}</th>
                                        <th>{{ __('content.tbl_date_modified') }}</th>
                                        @permission('update.article')
                                            <th>{{ __('content.status') }}</th>
                                            <th>نمایش</th>
                                            @endpermission
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!--table_style1-->
                        </div>
                    @else
                        <div class="paper_style1">
                            <div class="title_style1">
                                <p class="title1">مدیریت مقالات وبسایت</p>
                                <p class="title2">نمایش مقالات</p>
                            </div>
                            <!--title_style1-->
                            <hr class="hr_style1 marginb20 margint20">
                            <div class="form_style2">
                                <div class="result_style2 disable_max_width sign i">
                                    <div class="text icon">در حال حاضر هیچ آیتمی وجود ندارد.</div>
                                </div>
                            </div>
                            <!--paper_style-->
                        </div>
                    @endif

@endsection

{{--Active Menu--}}
@section('admin.article.index', 'active')
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
url :"{{ route('admin.article.DataTable') }}",
@endsection
@section('datatable_source')
"order": [[ 0, "asc" ]],
"columns": [
@permission('update.article')
{ data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
@endpermission
@permission('delete.article')
{ data: 'check', name: 'check', orderable: false, searchable: false},
@endpermission
{ data: 'image', name: 'image', orderable: false, searchable: false},
{ data: 'title', name: 'title' },
{ data: 'shop_id', name: 'shop.title' },
{ data: 'user_id', name: 'user.mobile' },
{ data: 'created_at', name: 'created_at' },
{ data: 'updated_at', name: 'updated_at' },
@permission('update.article')
{ data: 'display', name: 'display'},
{ data: 'show', name: 'show', orderable: false, searchable: false},
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

@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    $(document).on('click', '.active-article-button', function() {
        var activeArticle = [];
        $('.active-article:checked').each(function() {
            activeArticle.push($(this).val());
        })
        if (activeArticle.length === 0) {
            alert('ابتدا یک یا چند مورد را انخاب نمایید ');
        } else {


            $.post("{{ route('article.active') }}", $('.active-article:checked').serializeArray(), function(
                response) {
                if (response.status == 200) {
                    alert(response.msg);
                    window.location.reload();
                }
            });
        }
    });

    $(document).on('click', '.deactive-article-button', function() {
        var activeArticle = [];
        $('.active-article:checked').each(function() {
            activeArticle.push($(this).val());
        })
        if (activeArticle.length === 0) {
            alert('ابتدا یک یا چند مورد را انخاب نمایید ');
        } else {
            $.post("{{ route('article.deactive') }}", $('.active-article:checked').serializeArray(), function(
                response) {
                if (response.status == 200) {
                    alert(response.msg);
                    window.location.reload();
                }
            });
        }
    });

</script>
@endsection
