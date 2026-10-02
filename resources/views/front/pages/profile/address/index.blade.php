@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
                <div class="container">
                    <div class="inner">
                        <div class='panel_style1 other_page_section'>

                            @include('front.partial.dashboard')
                            <div class='panel_content'>
                                <div class="title_style8"><span>افزودن آدرس گیرنده جدید</span></div>
                                <div class="add_style1 flex add_address_btn"><i class="i-019-placeholder"></i><span class="title">افزودن آدرس جدید</span></div>
                                <div class="add_address_part" style="display: none;">
                                    @include('front.partial.ajax.create-address')
                                </div>
                                <div class="panel_section1">
                                    <ul class="step no_bullet">
                                        @forelse($addresses as $index=>$address)
                                            <li id="address-{{$address->id}}" class="item">
                                                <label for="rdo-address-{{$address->id}}">
                                                    <div class="table_style2">
                                                        <table>
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="2" width="220">
                                                                    اطلاعات تماس به نام
                                                                    <span>{{$address->name}}</span>
                                                                </td>
                                                                <td colspan="2" width="220">
                                                                    {{$address->address}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>استان {{$address->state->name}}</td>
                                                                <td>شهر {{$address->city->name}}</td>
                                                                <td>{{$address->mobile}}</td>
                                                                <td>{{$address->phone}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table><!-- close .table1 -->
                                                    </div>
                                                </label>
                                                <div class="option_part">
                                                    <div class="option_btn edit btn-edit-address"
                                                         data-url="{{route('front.profile.address.edit',$address)}}">
                                                        <span class="icon"><i class="i-013-gear"></i></span>
                                                        <span class="tooltip">ویرایش</span>
                                                    </div>
                                                    <div class="option_btn delete btn-delete" data-block="#address-{{$address->id}}"
                                                         data-url="{{route('front.profile.address.destroy',$address)}}">
                                                        <span class="icon"><i class="i-031-trash"></i></span>
                                                        <span class="tooltip">حذف</span>
                                                    </div>
                                                </div><!-- .option_part -->
                                            </li>
                                        @empty
                                            <li class="item">
                                                <div class="noItem_style2 flex">در حال حاضر هیچ آدرسی اضافه نشده است!</div>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div><!--clsoe .panel_content-->
                        </div>
                    </div><!-- .inner -->
                </div><!-- .container -->
        </div><!-- .user_page -->
    </section>

    @include('front.partial.upload-img-profile')

@endsection

@section('js')


    <script>

        $(document).ready(function () {
            $(document.body).on('click','.add_address_part .close_btn',function(){
                $('.add_address_part').slideUp(300);
            });
        });//document ready

    </script>

@endsection