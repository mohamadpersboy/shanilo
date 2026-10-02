@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <form method="POST" action="{{ route('social_network.store') }}" accept-charset="UTF-8"
            enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item fright width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">عنوان</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input placeholder="عنوان" name="title" type="text" value="{{ old('title') }}">
                        </div>
                    </li>
                    <li class="item fright width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">لینک</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input placeholder="لینک" name="link" type="text" value="{{ old('link') }}">
                        </div>
                    </li>
                    <li class="item fright width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">تعداد فالوور</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input placeholder="فالوور" name="follower" type="text" value="{{ old('follower') }}">
                        </div>
                    </li>
                    <li class="item fright width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">ایکون</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input name="icon" type="file">
                        </div>
                    </li>

                </ul>
                <hr class="hr_style1 marginb20 margint20">
                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item fright">
                            <input type="submit" name="submit" value="ثبت" class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </div>
        </form>
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
