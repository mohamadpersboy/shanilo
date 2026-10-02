@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <form action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item fright width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">عنوان:<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input type="file" name="image">
                            <select class='select2' name="type">
                                <option value>انتخاب کنید...</option>
                                <option value="mobile">سایز موبایل</option>
                                <option value="desktop">سایز دسکتاپ</option>
                                <option value="min_image">تصویر کوچک </option>
                            </select>


                        </div>
                    <li class="item fright width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">لینک</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input type="text" name="link" placeholder="لینک"> 
                        </div>
                    </li>
                </ul>
                <hr class="hr_style1 marginb20 margint20">
                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item fright"> <input type="submit" name="submit" value="ثبت" class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </div>
        </form>
        <br>
        <hr>
        <br>
        {!! $grid !!}
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).on('click', '.delete-image', function() {
            var check = confirm('آیا از حذف این مورد اطمینان دارید ؟ ');
            if (check) {
                $.post($(this).attr('data-url'), function() {
                    window.location.reload();
                });
            }

        });

    </script>
@endsection
