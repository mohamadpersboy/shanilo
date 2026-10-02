@extends('admin.master')
@section('content')
    @permission('create.addetail')
    <div class="paper_style1">
        <div class="marginb100">
            <div class="title_style1 {{__('content.float')}}">
                <p class="title1">{{$header['create']['title']}}</p>
                <p class="title2">{{$header['create']['description']}}</p>
            </div>
        </div>

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.addetail.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">پلن:<i class="required_style1">*</i></p>
                        <div class='item_inner'>
                            <select name="ad_plan_id" class="js-example-basic-single" data-placeholder="پلن" id="category">
                                <option value="">پلن</option>
                                @foreach($data['adplans'] as $adplan)
                                    <option value="{{$adplan->id}}" @if($adplan->id == old('ad_plan_id')) selected="selected"  @endif>{{$adplan->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">زمان:<i class="required_style1">*</i></p>
                        <div class='item_inner'>
                            <select name="ad_time_id" class="js-example-basic-single" data-placeholder="زمان" id="category">
                                <option value="">زمان</option>
                                @foreach($data['adtimes'] as $adtime)
                                    <option value="{{$adtime->id}}" @if($adtime->id == old('ad_time_id')) selected="selected"  @endif>{{$adtime->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>

                    <li class="width100 {{__('content.float')}}" data-price-wrapper>
                        <ul class="clearfix">
                            <li class='item width33_3 {{__('content.float')}}'>
                                <p class='field_label'>قیمت:<i class='required_style1'>*</i></p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' name='price' value='{{ old('price') }}' class='ltr tcenter' data-price-value data-mask="000,000,000,000,000" data-mask-reverse="true">
                                    <span class='guide_text left'>تومان</span>
                                </div>
                            </li>
                            <li class='item width33_3 {{__('content.float')}}'>
                                <p class='field_label'>درصد تخفیف:</p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' name='discount' value='{{ old('discount') }}' class='ltr tcenter' data-discount-value>
                                    <span class='guide_icon left'><i class='i-percent-symbol' style='font-size:1.3rem;'></i></span>
                                </div>
                            </li>
                            <li class='item width33_3 {{__('content.float')}} nospace'>
                                <p class='field_label'>قیمت تخفیف خورده:<i class='required_style1'>*</i></p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' name='price_discount' value='{{ old('price_discount') }}' class='ltr tcenter' data-price-discount-value data-mask="000,000,000,000,000" data-mask-reverse="true">
                                    <span class='guide_text left'>تومان</span>
                                </div>
                            </li>
                        </ul>
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

    @if(isset($data['addetails']) && !$data['addetails']->isEmpty())
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
                            @permission('delete.addetail')
                            <a href="{{route('admin.addetail.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
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
                        @permission('update.addetail')
                        <th><i class="icon1 i-list-ol"></i></th>
                        @endpermission
                        @permission('delete.addetail')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>جزئیات</th>
                        <th>{{__('content.tbl_creation_date')}}</th>
                        <th>{{__('content.tbl_date_modified')}}</th>
                        @permission('update.addetail')
                        <th>{{__('content.status')}}</th>
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
@section('admin.addetail.index','active')
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
    url :"{{route('admin.addetail.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.addetail')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.addetail')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'detail', name: 'detail', orderable: false, searchable: false,class:'tright'},
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    @permission('update.addetail')
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

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

{{--Price Discount--}}
@section('PriceDiscount')
    @include('admin.developer.price_discount')
@endsection
{{--End Price Discount--}}