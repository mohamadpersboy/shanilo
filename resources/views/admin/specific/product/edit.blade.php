@extends('admin.master')
@section('css')
    <style>
        .form_style2 .tokenfield .token-input {
            padding-right: 10px !important;
            padding-left: 0 !important;
            direction: rtl !important;
            margin-top: 1px !important;
            border-radius: 2px;
            /*position: absolute;
            right: 0;
            top: 0;*/
        }

        .tokenfield.form-control {
            border: 1px solid #e5e5e5;
            border-radius: 2px;
        }

        .select_style2.height36 {
            height: 40px;
        }

        /*.form_style2 .tokenfield {
            height: 39px !important;
            overflow: hidden !important;
        }*/

        /*  .token.bg-teal {
              position: relative;
              z-index: 2;
              width: 97%;
          }*/
    </style>
@endsection
@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">ویرایش وضعیت محصول</p>
            <p class="title2">{{$product->title}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        {!! Form::model($product,['url'=>route('admin.product.update',$product->id),'method'=>'PATCH','class'=>'form-horizontal form-contact-us-validation','files'=>true]) !!}
        {!! Form::hidden('id',$product->id) !!}
        @include('admin.specific.product.form')
        {!! Form::close() !!}

    </div>
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">ارسال پیام به کاربر محصول</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation"
              action="{{route('product_message.store')}}"
              enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">متن پیام</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input type="hidden" name="receiver_id" value="{{$product->shop->user_id}}">
                            <textarea name="message" class="autosize">{{ old('message') }}</textarea>
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                        </div>
                    </li>
                </ul>

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="ثبت پاسخ" class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.ticket.index')}}"
                               class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>

    </div>
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">نمایش پیام ها</p>
        </div>
        <hr class="hr_style1 marginb20 margint20">
        {!! $grid !!}
    </div>
@endsection

{{--Active Menu--}}
@section('admin.product.index','active')
{{--End Active Menu--}}
@section('js')
    @include('admin.developer.select2')
@endsection





