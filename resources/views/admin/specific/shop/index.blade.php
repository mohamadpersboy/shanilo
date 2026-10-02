@extends('admin.master')
@section('content')
    @if(isset($shops) && $shops)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت مدیریت فروشگاها</p>
                    <p class="title2">لیست فروشگاها</p>
                </div>
            </div>
            <hr class="hr_style2 margint30">
            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            @permission('delete.shop')
                            <a href="#" data-colspan="6" data-url="{{ route('admin.shop.destroy','all') }}"
                               class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i
                                        class="icon i-trash-o"></i></a>
                            @endpermission
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="hr_style2 margint20">
            <div class="table_style1">
                {!! $view !!}
            </div><!--table_style1-->
        </div>
    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">مدیریت محصولات وبسایت</p>
                <p class="title2">نمایش محصولات</p>
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

