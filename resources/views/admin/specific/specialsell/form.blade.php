<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">پلن :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select  name="plan_id" class="js-example-basic-single">
                    <option value="">انتخاب کنید</option>
                    @foreach($plans as $index=>$plan)
                        <option  value="{{$plan->id}}">{{$plan->title}}</option>
                    @endforeach
                </select>
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">فروشگاه :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select
                        name="shop_id"
                        data-url="{{route('admin.shop.getProducts')}}"
                        data-child="#product_id"
                        class="select-auto-fill js-example-basic-single">
                    <option value="">انتخاب کنید</option>
                    @foreach($shops as $index=>$shop)
                        <option  value="{{$shop->id}}">{{$shop->title}}</option>
                    @endforeach
                </select>
            </div>
        </li>
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">محصول :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select name="product_id"
                        id="product_id"
                        data-loading=":: صبر کنید ::"
                        data-default="انتخاب کنید"
                        data-url="{{route('admin.shop.getProductDetails')}}"
                        data-child="#product_detail_id"
                        class="select-auto-fill js-example-basic-single">
                    <option value="">انتخاب کنید</option>
                </select>
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">زیر محصول :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select name="product_detail_id" id="product_detail_id" data-loading=":: صبر کنید ::" data-default="انتخاب کنید" class="js-example-basic-single">
                    <option value="">انتخاب کنید</option>
                </select>
            </div>
        </li>
    </ul>
    <hr class="hr_style1 marginb20 margint20">
    <div class="btn_group_style1">
        <ul class="list clearfix">
            <li class="item {{__('content.float')}}">
                <input type="submit" name="submit" value="{{__('content.submit')}}" class="btn_style2 green">
            </li>
        </ul>
    </div>
</div>
