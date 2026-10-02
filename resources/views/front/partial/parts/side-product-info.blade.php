<div class="product_info">
    <div class="title_style8"><span>اطلاعات محصول</span></div>
    <ul class="step no_bullet">
        <li class="item flex">
            <div class="rate_style1 pointer_event">
                @include('front.partial.items.rate',['rate'=>$product->rate])
                <div class="rate_text">امتیاز ثبت شده میان
                    <span>{{$product->comments()->parents()->count()}}</span> نفر
                </div>
            </div>
        </li>
        <li class="item flex">
            <span class="icon"><i class="i-011-eye"></i></span>
            <span class="title">تعداد بازدید</span>
            <span class="content">{{$product->views}}</span>
        </li>
        <li class="item flex">
            <span class="icon"><i class="i-009-shopping-cart"></i></span>
            <span class="title">تعداد فروخته شده</span>
            <span class="content">{{$product->sell_count}}</span>
        </li>
        <li class="item flex">
            <span class="icon"><i class="i-016-bubble"></i></span>
            <span class="title">تعداد نظرات</span>
            <span class="content">{{$product->comments->count()}}</span>
        </li>
        <li class="item flex">
            <span class="icon"><i class="i-027-clock"></i></span>
            <span class="title">تاریخ انتشار</span>
            <span class="content">{{ShowDate($product->created_at)}}</span>
        </li>
    </ul>
    @if(Route::current()->getName()=='front.profile.product.edit')
        <div class="title_style8"><span>گالری تصاویر محصول</span></div>
        <div class="add_gallery_product">
            {!! Form::open([
                'url'=>route('front.profile.product.gallery.store',$product),
                'data-ajax',
                'dataType'=>'json',
                'data-on-success'=>'add-node',
                'data-on-error'=>'alert-message',
                'data-parent'=>'#product-gallery-container',
                'data-clear'=>'true'
            ]) !!}
            {!! Form::hidden('product_id',$product->id) !!}
            {!! Form::hidden('product_sid',bcrypt($product->id)) !!}
            <input id="gallery-input" type='file' class="frm_file" name='pic' data-run-cropper='' data-x='2' data-y='1'
                   data-element='#cropper30'
                   onChange='preview(this,$(".add_gallery_product .cropper .cropper_holder"));'>
            <div class='cropper ltr' id='cropper30'>
                                                    <span class='small_img'
                                                          onClick="$('.add_gallery_product input.frm_file').click();">
                                                        <span class='pic_inner cropper_preview'></span>
                                                    </span>
                <div class='cropper_holder'></div>
                <input data-crop-x type='hidden' name='cropper[x]' value=''>
                <input data-crop-y type='hidden' name='cropper[y]' value=''>
                <input data-crop-w type='hidden' name='cropper[w]' value=''>
                <input data-crop-h type='hidden' name='cropper[h]' value=''>
                <input type='hidden' name='old_image' value=''>
            </div>
            <button class="btn_style6">ثبت و آپلود عکس بعدی</button>
            {!! Form::close() !!}
            <div id="product-gallery-container" class="add_gallery_product_box flex">
                @foreach($product->attachments->where('slug','gallery') as $index=>$galleryImage)
                    @include('front.partial.ajax.product-gallery-image')
                @endforeach
                <div class="box triggerer box_add" data-event="click" data-element="#gallery-input">+</div>
                <div class="gap"></div>
                <div class="gap"></div>
            </div>
        </div><!-- add product gallery -->
    @endif
    <div class="panel_content">

        <div class="single-ticket">
            <div class="single-ticket__head">
                <div class="single-ticket__head_content">
                    <h3 class="single-ticket__head_content__title">پیام های مربوط به  محصول</h3>
                    <span></span>
                </div>
            </div>
            @if(!empty($productMessages) && $productMessages->count() > 0)
                <div class="single-ticket__items" style="overflow: scroll ;max-height: 300px">

                    @foreach($productMessages as $productMessage)
                        <div class="single-ticket__item">
                            <div class="single-ticket__item__head">
                                <div class="single-ticket__item_img">
                                    <a href="#">
                                        <img src="{{ $productMessage->user ? $productMessage->user->takeImage('avatar','60/60','user.png') : '_images/bg/app_icon.png' }}" alt="">
                                    </a>
                                </div>
                                <div class="single-ticket__item_title">
                                    <h4>
                                        <a href="#">
                                            {{ optional($productMessage->user)->name.' '.optional($productMessage->user)->family }}
                                        </a>
                                    </h4>
                                    <span>{{ \Morilog\Jalali\jDate::forge($productMessage->created_at)->format('Y-m-d H:i') }}</span>
                                </div>
                            </div>

                            <div class="single-ticket__item__content">
                                <p>{{ $productMessage->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="single-ticket__send">
                <form class="single-ticket__send_form" action="{{ route('product_message_front.store') }}" method="post">
                    {!! csrf_field() !!}
                    <textarea name="description" id="" rows="5" placeholder="پیام شما"></textarea>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="single-ticket__send_form__grid">
                        <button class="single-ticket__send_btn">ارسال پاسخ</button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
