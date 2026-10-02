@extends('admin.master')

@section('content')

    @if($user)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_user')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.user.update',$user->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item">
                            <div class="clearfix"></div>
                            <div class="title_style4 noselect">اطلاعات کاربر</div>
                            <hr class="hr_style2 margint5">
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">نام:</p>
                            <div class="item_inner">
                                <input type="text" name="name" value="{{$user->name}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">نام خانوادگی:</p>
                            <div class="item_inner">
                                <input type="text" name="family" value="{{$user->family}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">ایمیل:</p>
                            <div class="item_inner">
                                <input type="text" name="email" value="{{$user->email}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">موبایل:</p>
                            <div class="item_inner">
                                <input type="text" name="mobile" value="{{$user->mobile}}">
                            </div>
                        </li>
                        @role('atlas-administrator|administrator')
                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">موجودی:</p>
                            <div class="item_inner">
                                <input type="text" name="credit" value="{{$user->credit}}">
                            </div>
                        </li>
                        @endrole
                        <li class="item">
                            <div class="clearfix"></div>
                            <hr class="hr_style2 margint20">
                            <div class="title_style4 noselect">تغییر رمز عبور</div>
                            <hr class="hr_style2 margint5">
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">رمز عبور جدید:</p>
                            <div class="item_inner">
                                <input type="password" name="password">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">تکرار رمز عبور جدید :</p>
                            <div class="item_inner">
                                <input type="password" name="password_confirmation">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">تایید شده توسط ادمین؟</p>
                            <div class="item_inner">
                                <select name="confirmed_by_admin" id="" class="js-example-basic-single">
                                    <option {{$user->confirmed_by_admin==0?'selected':''}} value="0">خیر</option>
                                    <option {{$user->confirmed_by_admin==1?'selected':''}} value="1">بله</option>
                                </select>
                            </div>
                        </li>
                        @if($user->admin_addresses->count())
                            <li class="item">
                                <div class="clearfix"></div>
                                <hr class="hr_style2 margint20">
                                <div class="title_style4 noselect">اطلاعات پستی</div>
                                <hr class="hr_style2 margint5">
                            </li>

                            <li class='postinfo_boxes'>
                                <ul>

                                    @foreach($user->admin_addresses as $index=> $address)
                                        <li class='item postinfo_box'>
                                            <div class='clearfix'></div>
                                            <hr class='hr_style2 margint5'/>
                                            <div class='title_style4 noselect postinfo_show'>
                                                <a href='#'>آدرس شماره {{$index+1}}</a>
                                                @if($address->deleted == 1)
                                                    <a href="#" class="deleted_address">(این آدرس توسط کاربر حذف شده است)</a>
                                                @endif
                                                <a href='#' class='arrow1 cl_red hover_opac'><i class='i-angle-down'></i></a>
                                            </div>
                                            <hr class='hr_style2 margint5'/>

                                            <ul class='clearfix pointer_events_none noselect postinfo_detail' style="display: none;">
                                                <li class='item fright width100'><hr class='hr_style2 margint5'/></li>
                                                <li class='item width50 fright'>
                                                    <p class='field_label'>نام:</p>
                                                    <div class='item_inner'>
                                                        <input type='text' value='{{$address->name}}' class='tcenter'>
                                                    </div>
                                                </li>
                                                <li class='item width50 fright nospace'>
                                                    <p class='field_label'>نام خانوادگی:</p>
                                                    <div class='item_inner'>
                                                        <input type='text' value='{{$address->family}}' class='tcenter'>
                                                    </div>
                                                </li>
                                                <li class='item width50 fright'>
                                                    <p class='field_label'>ایمیل:</p>
                                                    <div class='item_inner'>
                                                        <input type='text' value='{{$address->email}}' class='ltr en_words tcenter'>
                                                    </div>
                                                </li>
                                                <li class='item width50 fright nospace'>
                                                    <p class='field_label'>موبایل:</p>
                                                    <div class='item_inner'>
                                                        <input type='text' value='{{$address->mobile}}' class='ltr en_words tcenter'>
                                                    </div>
                                                </li>
                                                <li class='item width50 fright'>
                                                    <p class='field_label'>استان:</p>
                                                    <div class='item_inner'>
                                                        <input type='text' value='{{$address->state->name}}' class='tcenter' class='tcenter'>
                                                    </div>
                                                </li>
                                                <li class='item width50 fright nospace'>
                                                    <p class='field_label'>شهر:</p>
                                                    <div class='item_inner'>
                                                        <input type='text' value='{{$address->city->name}}' class='tcenter' class='tcenter'>
                                                    </div>
                                                </li>

                                                <li class='item width100 fright nospace'>
                                                    <p class='field_label'>آدرس:</p>
                                                    <div class='item_inner'>
                                                        <textarea class="autosize">{{$address->address}}</textarea>
                                                    </div>
                                                </li>

                                                @if($address->latlong != null)
                                                    <li class='item width100 fright nospace'>
                                                        <p class='field_label'>Address:</p>
                                                        <div class='item_inner'>
                                                            <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q={{$address->latlong}}&amp;z=15&amp;ie=UTF8&amp;&amp;output=embed&amp;iwloc=near&amp;key=AIzaSyDZaZOS9IPKn3EhAlGWW0O7Hf43FKaH4Yw"></iframe>
                                                        </div>
                                                    </li>
                                                @endif
                                            </ul>

                                        </li>
                                    @endforeach
                                </ul>
                            </li><!--postinfo_boxes-->
                        @endif

                    </ul>

                    <hr class="hr_style1 marginb20 margint20">
                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" id="edit_user" value="{{__('content.save_changes')}}" class="btn_style2 green">
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="{{route('admin.user.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_users'))

{{--Active Menu--}}
@section('admin.user','active')
@section('admin.user.index','active')
{{--End Active Menu--}}

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
    
    <script>
        $(document).ready(function() {
            //////////////////////////////////////////////////
            // select State
            $('select[name=state_id]').change(function(){
                var id = $(this).val();
                var _token = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData();
                formData.append('id', id);
                formData.append('_token', _token);
                $.ajax({
                    url : "{{route('admin.state.change')}}",
                    type : "post",
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success : function(data) {
                        $('#city').find('option').remove().end().append($('<option>', {
                            value: "",
                            text: "- انتخاب شهر -"
                        }));
                        if (data.cities != null){
                            data.cities.forEach(function (city) {
                                $('#city').append($('<option>', {
                                    value: city['id'],
                                    text: city['name']
                                }));
                            });
                        }
                    },
                    error: function() {
                        //
                    }
                });
            });

            //////////////////////////////////////////
            // SHOW USER POST INFO
            $(".postinfo_show").click(function(){
                var $postinfo_box = $(this).closest(".postinfo_box");
                var $target = $(this).siblings(".postinfo_detail");
                var $arrow = $(this).find('.arrow1');
                var $postinfo_details = $(".postinfo_boxes .postinfo_detail").not($target);
                var $arrows = $(".postinfo_boxes .title_style4 .arrow1").not($arrow);

                // reset
                $postinfo_details.stop().slideUp(200);
                $arrows.removeClass("toggle");

                // set
                $target.stop().slideToggle(200);
                $arrow.toggleClass("toggle");
            });

        });//document ready

    </script>
@endsection