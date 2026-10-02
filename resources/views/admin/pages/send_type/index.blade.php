@extends('admin.master')
@section('content')

    <div class='paper_style1'>
        <div class='title_style1'>
            <p class='title1'>تعرفه سرویس های ارسال سفارشات سبد خرید</p>
            <p class='title2'>هزینه سرویس های ارسال سفارشات سبد خرید را از این قسمت میتوانید ویرایش نمائید</p>
        </div><!--title_style1-->


        <hr class='hr_style1 margint20 marginb15' />

        <form id='frm_tariff_send_cart' method='post' action='' class='form_validation'>
            <hr class='hr_style1 margint20' />

            <div class='table_style2'>
                <table class='price_list width100 margin_auto'>
                    <thead>
                    <tr>
                        <th class='time width15 cl_blue'>عنوان</th>
                        <th class='time width45 cl_blue'>توضیحات</th>
                        <th class='price width10 cl_blue'>رایگان برای بالاتر از </th>
                        <th class='price width20 cl_blue'>استان - شهر</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data['objects'] as $object)
                            <tr>
                                <td><span class='cl_blue'> <img src='{{$object->takeImage()}}' style='width:40px;opacity:0.75;'/> <br> {{$object->title}}</span></td>
                                <td><textarea name='description[]' class='text1 autosize'>{{$object->description}}</textarea></td>
                                <td>
                                    <input type='text' name='free_from[]' value='{{$object->free_from}}' class='tcenter input1 number_format letter1 show_money_value_with_comma' placeholder='هزینه- تومان' style='width:100px;' />
                                    <input type="hidden" name="send_type_id[]" value="{{$object->id}}">
                                </td>
                                <td>

                                    <a href='#' class='btn_style2 marginb5' data-title="{{$object->title}}" data-id="{{$object->id}}" data-view-state style='font-size:1.1rem;'>استانهای تحت پوشش</a>
                                    <a href='#' class='btn_style2' data-title="{{$object->title}}" data-id="{{$object->id}}" data-view-city style='font-size:1.1rem;'>شـهرهای تحت پوشش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!--table_style2-->

            <hr class='hr_style1 marginb15 margint30' />
            <div class='btn_group_style1'>
                <ul class='list clearfix'>
                    <li class='item fright'>
                        <a data-submit-send-type class='btn_style2 green'>ویرایش تعرفه سرویس ها</a>
                    </li>
                </ul>
            </div><!--btn_group_style1-->
        </form>
    </div><!--paper_style-->

    @role('atlas-administrator')
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">{{__('content.management_send_type')}}</p>
                </div>

                <div class="title_style1 {{__('content.floatr')}} margint10" >
                    <a href="{{route('admin.send_type.create')}}" class=" btn btn-info btn-labeled btn_style2 green"><b><i class="icon-plus2"></i></b>{{__('content.create_send_type')}}</a>
                </div>

            </div>

            <hr class="hr_style2 margint30">

            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item">
                            @permission('delete.sendtype')
                            <a href="{{route('admin.send_type.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                            <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                            <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                            @endpermission
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="hr_style2 margint20">
            <div class="table_style1">
                <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        @permission('update.sendtype')
                        <th><i class="icon1 i-list-ol"></i></th>
                        @endpermission
                        @permission('delete.sendtype')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>عنوان</th>
                        <th>{{__('content.tbl_creation_date')}}</th>
                        <th>{{__('content.tbl_date_modified')}}</th>
                        @permission('update.sendtype')
                        <th>{{__('content.status')}}</th>
                        <th>{{__('content.edit')}}</th>
                        @endpermission
                    </tr>
                    </thead>
                </table>
            </div><!--table_style1-->
        </div>
    @endrole

    <!--======================== MODAL ==========================-->
    <div class='modal modal_over'>
        <div class='modal_scroll'>
            <div class='modal_dynamic'></div><!--modal_dynamic-->

            <div class='modal_static'>

                <div class='window modalwin_style2' id='view_state' style='max-width:500px;'>
                    <form method='post'>
                        <i class='modal_close'>X</i>
                        <div class='inner'>
                            <div class='title_style1'>
                                <p class='title1'><span class='cl_blue send_type_name'></span> - استان های تحت پوشش</p>
                                <p class='title2'>از این بخش می توانید استان های تحت پوشش را مدیریت نمائید.</p>
                            </div><!--title_style1-->

                            <hr class='hr_style2 margint15' />
                            <div class="clearfix">
                                <div class="btn_group_style1">
                                    <p class="result_report tcenter"><span class="text"></span></p>
                                    <ul class="list clearfix">
                                        <li class="item">
                                            <a href="#" class="btn_style2 green" data-submit-state>ویرایش اطلاعات</a>
                                        </li>
                                    </ul>
                                </div><!--btn_group_style1-->
                            </div>

                            <hr class='hr_style2 margint10' />

                            <div class="table_style1 type2">
                                <table>
                                    <thead>

                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table></div>

                            <hr class='hr_style2 margint20' />

                            <div class="clearfix">
                                <div class="btn_group_style1">
                                    <p class="result_report tcenter"><span class="text"></span></p>
                                    <ul class="list clearfix">
                                        <li class="item">
                                            <a href="#" class="btn_style2 green" data-submit-state>ویرایش اطلاعات</a>
                                        </li>
                                    </ul>
                                </div><!--btn_group_style1-->
                            </div>
                            <input type='hidden' name='send_type_id' value='' />
                        </div><!--inner-->
                    </form>
                </div>

                <div class='window modalwin_style2' id='view_city' style='max-width:500px;'>
                    <form method='post'>
                        <i class='modal_close'>X</i>
                        <div class='inner'>
                            <div class='title_style1'>
                                <p class='title1'><span class='cl_blue send_type_name'></span> - شهرهای تحت پوشش</p>
                                <p class='title2'>از این بخش می توانید شهرهای تحت پوشش و هزینه ارسال به هرکدام را مدیریت نمائید.</p>
                            </div><!--title_style1-->

                            <hr class='hr_style2 margint15' />

                            <div class='form_style2'>
                                <ul class='list clearfix'>
                                    <li class="item width100 nospace">
                                        <div class="item_inner has_guide clearfix">
                                            <div class='select_style2 select_style fleft tcenter' style='width:60%;border:0 none;'>
                                                <i class='select_arrow i-angle-down'></i>
                                                <span class='select_label'>-- انتخاب نمائید--</span>
                                                <select data-select-style name='state_id'>
                                                    <option value=''>-- انتخاب نمائید--</option>
                                                    @foreach($data['states'] as $state)
                                                        <option value='{{$state->id}}'>{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!--select_box_style1-->
                                            <span class="guide_text right width40 tcenter fontsize12">انتخاب استان</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div data-show-city_wrapper>

                                <div class="clearfix">
                                    <div class="btn_group_style1">
                                        <p class="result_report tcenter"><span class="text"></span></p>
                                        <ul class="list clearfix">
                                            <li class="item">
                                                <a href="#" class="btn_style2 green" data-submit-city>ویرایش اطلاعات</a>
                                            </li>
                                        </ul>
                                    </div><!--btn_group_style1-->
                                </div>

                                <hr class='hr_style2 margint10' />

                                <div class="table_style1 type2">
                                    <table>
                                        <thead>

                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table></div>

                                <hr class='hr_style2 margint20' />

                                <div class="clearfix">
                                    <div class="btn_group_style1">
                                        <p class="result_report tcenter"><span class="text"></span></p>
                                        <ul class="list clearfix">
                                            <li class="item">
                                                <a href="#" class="btn_style2 green" data-submit-city>ویرایش اطلاعات</a>
                                            </li>
                                        </ul>
                                    </div><!--btn_group_style1-->
                                </div>
                            </div>
                        </div><!--inner-->

                        <input type='hidden' name='send_type_id' value='' />
                    </form>
                </div>

            </div><!--modal_static-->
        </div><!--modal_scroll-->
    </div><!--modal-->

@endsection


@section('PageHeading',__('content.management_send_type'))

{{--Active Menu--}}
@section('admin.send_type.index','active')
{{--End Active Menu--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

@section('js')
    <script>
        $(document).ready(function(){
            $("#view_state").on('keyup',"input[name='price_all']",function(){
                var price = $(this).val();
                price.replace("/,/g","");
                $("#view_state td.price input").val(number_format(price));
            });

            $("#view_city").on('keyup',"input[name='price_all']",function(){
                var price = $(this).val();
                price.replace("/,/g","");
                $("#view_city td.price input").val(number_format(price));
            });

            $("[data-view-state]").click(function(){
                var $this = $(this);
                var $modal = $("#view_state");
                var send_type_id = $this.data("id");
                var title = $this.data("title");
                $modal.find(".send_type_name").text(title);
                $modal.find("input[name='send_type_id']").val(send_type_id);
                $modal.find(".table_style1 table thead,.table_style1 table tbody").empty();
                modal_box('#view_state');

                var _token = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData();
                formData.append('send_type_id', send_type_id);
                formData.append('_token', _token);
                $.ajax({
                    url : "{{route('admin.send_type.ShowState')}}",
                    type : "post",
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success : function(data) {
                        var price = 0;
                        var checked = "";
                        var counter = 0;
                        $modal.find(".table_style1 table thead,.table_style1 table tbody").empty();
                        $("#view_state .table_style1 table thead").html(data.thead);
                        if (data.states != null){
                            data.states.forEach(function (state) {
                                if(state['city_status'] == 0){
                                    checked = "";
                                } else {
                                    checked = 'checked';
                                }
                                counter++;
                                $("#view_state .table_style1 table tbody").append($('<tr><td class="row_num">'+counter+'</td><td><label class="checkradio_style1 type2"><input type="checkbox" name="state[]" data-id="'+state['id']+'" data-select-row1 value="1" '+checked+'><span class="box"></span></label></td><td>'+state['name']+'</td><td class="price"><input type="text" name="price[]" value="0" class="tcenter input1 number_format letter1" placeholder="هزینه- تومان" style="width:100px;"></td></tr>'));
                            });
                        }
                    },
                    error: function() {
                        //
                    }
                });
            });

            $("#view_state").on('click','[data-submit-state]',function(e){
                var send_type_id = $("#view_state").find("input[name='send_type_id']").val();
                e.preventDefault();
                var $this_click = $(this);
                var prices = [];
                $("#view_state input[name='price[]']").each(function() {
                    prices.push($(this).val().replace(",", ""));
                });
                var states = [];
                var statesid = [];
                $("#view_state input[name='state[]']").each(function() {
                    statesid.push($(this).data('id'));
                    if($(this).is(':checked')){
                        states.push(1);
                    } else {
                        states.push(0);
                    }
                });

                var _token = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData();
                formData.append('send_type_id', send_type_id);
                formData.append('prices', prices);
                formData.append('states', states);
                formData.append('statesid', statesid);
                formData.append('_token', _token);
                $.ajax({
                    url : "{{route('admin.send_type.StatePrice')}}",
                    type : "post",
                    data: formData,
//                        dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#view_state .result_report').removeClass('error').addClass('success').find('.text').html('<img src="{{asset('assets/front/_images/loading/loader3.gif')}}">');
                    },
                    success : function() {
                        $('#view_state .result_report').removeClass('error').addClass('success').find('.text').text('عملیات با موفقیت انجام گردید.');
                    },
                    error: function() {
                        $('#view_state .result_report').removeClass('success').addClass('error').find('.text').text("عملیات ناموفق بود.");
                    }
                });
            });




            $("[data-view-city]").click(function(){
                var $this = $(this);
                var $modal = $("#view_city");
                var send_type_id = $this.data("id");
                var title = $this.data("title");
                $modal.find(".send_type_name").text(title);
                $modal.find("input[name='send_type_id']").val(send_type_id);
                $("[data-show-city_wrapper]").hide();
                $modal.find(".table_style1 table thead,.table_style1 table tbody").empty();
                $modal.find("select[name='state_id'] option:selected").removeAttr('selected');
                $modal.find("select[name='state_id'] option[value='']").attr('selected','selected');
                $modal.find("select[name='state_id']").closest(".select_style").find(".select_label").text("-- انتخاب نمائید --");
                modal_box('#view_city');
            });

            $("#view_city select[name='state_id']").change(function(){
                var send_type_id = $("#view_city").find("input[name='send_type_id']").val();
                var $modal = $("#view_city");
                var state_id = $(this).val();
                if(state_id == ""){
                    $("[data-show-city_wrapper]").hide();
                    $modal.find(".table_style1 table thead,.table_style1 table tbody").empty();
                } else {
                    var $this_state = $(this);
                    $this_state.closest(".select_style").addClass("loading_ajax");

                    var _token = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData();
                    formData.append('send_type_id', send_type_id);
                    formData.append('state_id', state_id);
                    formData.append('_token', _token);
                    $.ajax({
                        url : "{{route('admin.send_type.StateChange')}}",
                        type : "post",
                        data: formData,
                        dataType: "json",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            var price = 0;
                            var checked = "";
                            var counter = 0;
                            var i = "";
                            $modal.find(".table_style1 table thead,.table_style1 table tbody").empty();
                            $this_state.closest(".select_style").removeClass("loading_ajax");
                            $("#view_city .table_style1 table thead").html(data.thead);
                            $("[data-show-city_wrapper]").fadeIn();
                            if (data.cities != null){
                                data.cities.forEach(function (city) {
                                    if(city['send_types'].length == 0){
                                        price = 0;
                                        checked = "";
                                    } else {
                                        price = 0;
                                        checked = "";
                                        for (i = 0; i < city['send_types'].length; i++) {
                                            if(city['send_types'][i]['pivot']['send_type_id'] == send_type_id){
                                                price = city['send_types'][i]['pivot']['price'];
                                                checked = 'checked';
                                                break
                                            }
                                        }
                                    }
                                    counter++;
                                    $("#view_city .table_style1 table tbody").append($('<tr><td class="row_num">'+counter+'</td><td><label class="checkradio_style1 type2"><input type="checkbox" name="city[]" data-id="'+city['id']+'" data-select-row1 value="1" '+checked+'><span class="box"></span></label></td><td>'+city['name']+'</td><td class="price"><input type="text" name="price[]" value="'+number_format(price)+'" class="tcenter input1 number_format letter1" placeholder="هزینه- تومان" style="width:100px;"></td></tr>'));
                                });
                            }
                        },
                        error: function() {
                            //
                        }
                    });
                }
            });

            $("#view_city").on('click','[data-submit-city]',function(e){
                var send_type_id = $("#view_city").find("input[name='send_type_id']").val();
                var $modal = $("#view_city");
                e.preventDefault();
                var $this_click = $(this);
                var prices = [];
                $("#view_city input[name='price[]']").each(function() {
                    prices.push($(this).val().replace(",", ""));
                });
                var cities = [];
                var citiesid = [];
                $("#view_city input[name='city[]']").each(function() {
                    citiesid.push($(this).data('id'));
                    if($(this).is(':checked')){
                        cities.push(1);
                    } else {
                        cities.push(0);
                    }
                });

                var _token = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData();
                formData.append('send_type_id', send_type_id);
                formData.append('prices', prices);
                formData.append('cities', cities);
                formData.append('citiesid', citiesid);
                formData.append('_token', _token);
                $.ajax({
                    url : "{{route('admin.send_type.CityPrice')}}",
                    type : "post",
                    data: formData,
//                        dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#view_city .result_report').removeClass('error').addClass('success').find('.text').html('<img src="{{asset('assets/front/_images/loading/loader3.gif')}}">');
                    },
                    success : function() {
                        $('#view_city .result_report').removeClass('error').addClass('success').find('.text').text('عملیات با موفقیت انجام گردید.');
                    },
                    error: function() {
                        $('#view_city .result_report').removeClass('success').addClass('error').find('.text').text("عملیات ناموفق بود.");
                    }
                });
            });

            $('[data-submit-send-type]').click(function (e) {
                e.preventDefault();
                var description = [];
                $("table.price_list textarea[name='description[]']").each(function() {
                    description.push($(this).val().replace());
                });
                var free_from = [];
                $("table.price_list input[name='free_from[]']").each(function() {
                    free_from.push($(this).val().replace(/,/g, ""));
                });
                var send_type_id = [];
                $("table.price_list input[name='send_type_id[]']").each(function() {
                    send_type_id.push($(this).val().replace());
                });
                var _token = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData();
                formData.append('description', description);
                formData.append('free_from', free_from);
                formData.append('send_type_id', send_type_id);
                formData.append('_token', _token);
                $.ajax({
                    url : "{{route('admin.send_type.ChangeContent')}}",
                    type : "post",
                    data: formData,
//                        dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success : function() {
                        show_notif('', 'ویرایش با موفقیت انجام شد.', 's', 5000);
                    },
                    error: function() {
                        show_notif('', "متاسفانه عملیات با موفقیت انجام نشد.", 'e', false)
                    }
                });
            })

        });
    </script>
@endsection

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
    url :"{{route('admin.send_type.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.sendtype')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.sendtype')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'title', name: 'title' },
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    @permission('update.sendtype')
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