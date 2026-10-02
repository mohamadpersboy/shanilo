@extends('admin.master')
@section('content')
    @permission('create.advertisement')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_advertisement')}}</p>
            <p class="title2">{{__('content.create_advertisement')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.advertisement.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    <div class='clearfix'></div>
                    <div class='title_style4 margint5 marginb10'>اطلاعات درخواست کننده</div>
                    <hr class='hr_style2'/>
                    
                    @if(isset($_GET['rq']))
                        <input type="hidden" name="request_id" value="{{$_GET['rq']}}">
                    @endif

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">نام:</p>
                        <div class="item_inner">
                            <input type="text" name="name" @if(isset($data['adrquest'])) value="{{ $data['adrquest']->name }}" @else value="{{ old('name') }}" @endif>
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">نام خانوادگی:</p>
                        <div class="item_inner">
                            <input type="text" name="family" @if(isset($data['adrquest'])) value="{{ $data['adrquest']->family }}" @else value="{{ old('family') }}" @endif>
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width33_3">
                        <p class="field_label">تلفن ثابت:</p>
                        <div class="item_inner">
                            <input type="text" name="tel" @if(isset($data['adrquest'])) value="{{ $data['adrquest']->tel }}" @else value="{{ old('tel') }}" @endif>
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width33_3">
                        <p class="field_label">تلفن همراه:</p>
                        <div class="item_inner">
                            <input type="text" name="mobile" @if(isset($data['adrquest'])) value="{{ $data['adrquest']->mobile }}" @else value="{{ old('mobile') }}" @endif>
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width33_3 nospace">
                        <p class="field_label">ایمیل:</p>
                        <div class="item_inner">
                            <input type="text" name="email" class="ltr tleft en_words" @if(isset($data['adrquest'])) value="{{ $data['adrquest']->email }}" @else value="{{ old('email') }}" @endif>
                        </div>
                    </li>

                    <div class='clearfix'></div>
                    <div class='title_style4 margint20 marginb10'>اطلاعات تبلیغ</div>
                    <hr class='hr_style2'/>

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">پلن:<i class="required_style1">*</i></p>
                        <div class='item_inner'>
                            <select name="ad_plan_id" class="js-example-basic-single" data-placeholder="پلن" id="category" data-change-plan>
                                <option value="">پلن</option>
                                @foreach($data['adplans'] as $adplan)
                                    <option value="{{$adplan->id}}" @if(isset($data['adrquest']) && $data['adrquest']->ad_plan_id == $adplan->id) selected="" @endif>{{$adplan->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">زمان:<i class="required_style1">*</i></p>
                        <div class='item_inner'>
                            <select name="ad_time_id" class="js-example-basic-single" data-placeholder="زمان" id="category" data-change-time>
                                <option value="">زمان</option>
                                @if(isset($data['addetails']))
                                    @foreach ($data['addetails'] as $adDetail)
                                        <option value="{{$adDetail->adtime->id}}" @if($data['adrquest']->ad_time_id == $adDetail->adtime->id) selected="" @endif>{{$adDetail->adtime->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </li>

                    <li class="width100 {{__('content.float')}}" data-price-wrapper>
                        <ul class="clearfix">
                            <li class='item width33_3 {{__('content.float')}}'>
                                <p class='field_label'>قیمت:</p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' disabled="" @if(isset($data['addetail'])) value="{{$data['addetail']->price}}" @endif class='ltr tcenter' data-show-price data-price-value data-mask="000,000,000,000,000" data-mask-reverse="true">
                                    <span class='guide_text left'>تومان</span>
                                </div>
                            </li>
                            <li class='item width33_3 {{__('content.float')}}'>
                                <p class='field_label'>درصد تخفیف:</p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' disabled="" @if(isset($data['addetail'])) value="{{$data['addetail']->discount}}" @endif class='ltr tcenter' data-show-discount data-discount-value>
                                    <span class='guide_icon left'><i class='i-percent-symbol' style='font-size:1.3rem;'></i></span>
                                </div>
                            </li>
                            <li class='item width33_3 {{__('content.float')}} nospace'>
                                <p class='field_label'>قیمت تخفیف خورده:</p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' disabled="" @if(isset($data['addetail'])) value="{{$data['addetail']->price_discount}}" @endif class='ltr tcenter' data-show-price-discount data-price-discount-value data-mask="000,000,000,000,000" data-mask-reverse="true">
                                    <span class='guide_text left'>تومان</span>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">لینک:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="link" class="ltr tleft en_words"  @if(isset($data['adrquest'])) value="{{ $data['adrquest']->link }}" @else value="{{ old('link') }}" @endif>
                        </div>
                    </li>

                </ul>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="ثبت اطلاعات و ادامه جهت آپلود عکس تبلیغات" class="btn_style2 green">
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
                        <p class="title1">{{__('content.management_advertisement')}}</p>
                        <p class="title2">{{__('content.list_of_advertisement')}}</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                @permission('delete.advertisement')
                                <a href="{{route('admin.advertisement.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
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
                            @permission('update.advertisement')
                            <th><i class="icon1 i-list-ol"></i></th>
                            @endpermission
                            @permission('delete.advertisement')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>اطلاعات درخواست</th>
                            <th>اطلاعات شخص</th>
                            <th>{{__('content.tbl_creation_date')}}</th>
                            <th>تاریخ انقضاء</th>
                            @permission('update.advertisement')
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
                        <p class="title1">{{__('content.management_advertisement')}}</p>
                        <p class="title2">{{__('content.list_of_advertisement')}}</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_advertisement')}}</div>
                        </div>
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection

{{--Active Menu--}}
@section('admin.advertisement.index','active')
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
    url :"{{route('admin.advertisement.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 5, "desc" ]],
    "columns": [
    @permission('update.advertisement')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.advertisement')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'planDetail', name: 'planDetail', orderable: false, searchable: false,class:'tright'},
    { data: 'userDetail', name: 'userDetail', orderable: false, searchable: false,class:'tright'},
    { data: 'created_at', name: 'created_at' },
    { data: 'expire_at', name: 'expire_at' },
    @permission('update.advertisement')
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

{{--Editor--}}
@section('editor')
    @include('admin.developer.tinymce')
@endsection
{{--End Editor--}}

{{--Cropper--}}
@section('cropper')
    @include('admin.developer.cropper')
@endsection
{{--End Cropper--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

@section('js')
    @include('admin.developer.choose-advertisement')
@endsection