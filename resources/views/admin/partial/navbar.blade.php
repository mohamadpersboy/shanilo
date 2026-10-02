<header class='header_style1'>
    <div class='container'>
        <div class='inner clearfix'>
            <div class='rightside'>
                <div class='date_time letter0_5'>
                    <span class='day'>{{NowDay()}}</span>
                    <span class='date'>{{NowDate()}}</span>
                </div><!--date_time-->
                {{--<div class='lang_style lang_style1'>--}}
                    {{--<span class='active_lang noselect clearfix cursor_pointer'>--}}
                        {{--<i class='flag' style="background-image:url({{asset('assets/admin/_images/flag/'.__('content.language').'.png')}})"></i>--}}
                        {{--<i class='lang'>{{__('content.language')}}</i>--}}
                    {{--</span>--}}
                    {{--<div class='lang_list'>--}}
                        {{--<ul class='list'>--}}
                            {{--<li class='lang_item clearfix cursor_pointer'>--}}
                                {{--<a href="{{route('admin.language','fa')}}">--}}
                                    {{--<i class='flag' style="background-image:url({{asset('assets/admin/_images/flag/fa.png')}})"></i>--}}
                                    {{--<i class='lang'>fa</i>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class='lang_item clearfix cursor_pointer'>--}}
                                {{--<a href="{{route('admin.language','en')}}">--}}
                                    {{--<i class='flag' style="background-image:url({{asset('assets/admin/_images/flag/en.png')}})"></i>--}}
                                    {{--<i class='lang'>en</i>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div><!--lang_style1-->--}}
            </div><!--rightside-->
            <div class='leftside'>
                <div class='left_part1'>
                    <ul class='list step1'>
                        <li class='item preview'>
                            <a href="{{route('front.home.index')}}" class='link' target='_blank' data-viewsite>
                                <i class='icon i-external-link'></i><span class='text'>{{__('content.visit_site')}}</span>
                            </a>
                        </li>
                        {{--<li class='item logout'>--}}
                            {{--<a href="{{route('admin.auth.logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class='link'><i class='icon i-power-2'></i></a>--}}
                            {{--<form id="logout-form" action="{{route('admin.auth.logout')}}" method="POST" style="display: none;">--}}
                                {{--{{ csrf_field() }}--}}
                            {{--</form>--}}
                        {{--</li>--}}
                    </ul>
                </div><!--left_part1-->
                <div class='left_part2'>
                    @include('admin.partial.breadcrumb')
                </div><!--left_part2-->
            </div><!--leftside-->
        </div><!--inner-->
    </div><!--container-->
</header><!--header_style1-->