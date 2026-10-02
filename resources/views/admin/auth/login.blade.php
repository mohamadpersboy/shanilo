<!DOCTYPE html>
<html lang="{{__('content.language')}}" dir="{{__('content.direction')}}">
    @include('admin.partial.header')

    <body class="login-container login-cover">

        <section class='login_part1'>
            <div class='container'>
                <div class='inner'>
                    <div class='form_style1'>
                        <form method="post" action="{{ route('auth.login') }}" class="form-validate">
                            {{csrf_field()}}

                            <div class='inner_form'>
                                {{-- <div class='lang_style lang_style1'>
                                    <span class='active_lang noselect clearfix cursor_pointer'>
                                        <i class='flag' style="background-image:url({{asset('assets/admin/_images/flag/'.__('content.language').'.png')}})"></i>
                                        <i class='lang'>{{__('content.language')}}</i>
                                    </span>
                                    <div class='lang_list'>
                                        <ul class='list'>
                                            <li class='lang_item clearfix cursor_pointer'>
                                                <a href="{{route('admin.auth.language','fa')}}">
                                                    <i class='flag' style="background-image:url({{asset('assets/admin/_images/flag/fa.png')}})"></i>
                                                    <i class='lang'>fa</i>
                                                </a>
                                            </li>
                                            <li class='lang_item clearfix cursor_pointer'>
                                                <a href="{{route('admin.auth.language','en')}}">
                                                    <i class='flag' style="background-image:url({{asset('assets/admin/_images/flag/en.png')}})"></i>
                                                    <i class='lang'>en</i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!--lang_style1--> --}}
                                <div class='logo_atlas admin_login_logo'></div><!--logo_atlas-->
                                <div class='title'>{{__('content.login_to_your_account')}} <small class="display-block">{{__('content.your_credentials')}}</small></div><!--title-->

                                <ul class='list step1'>
                                    <li class='item'>
                                        <div class='item_inner'>
                                            <span class='field_icon'><i class='i-person'></i></span>
                                            <input type='text' name='email' value='' class='ltr en_words' required="required"/>
                                        </div><!--item_inner-->
                                    </li>
                                    <li class='item'>
                                        <div class='item_inner'>
                                            <span class='field_icon'><i class='i-unlock-alt'></i></span>
                                            <input type='password' name='password' class='ltr' required="required"/>
                                        </div><!--item_inner-->
                                    </li>
                                    <li class="item {{__('content.float')}} width50">
                                        <input type="checkbox" name="remember" class="styled" checked="checked">
                                        {{__('content.remember_me')}}
                                    </li>
                                    <li class="item {{__('content.floatr')}} width50 nospace">
                                        <a href="{{ route('admin.password.request') }}">{{__('content.forgot_password')}}</a>
                                    </li>

                                    <li class='item submit'>
                                        <input type='submit' name='go_login' value='{{__('content.login')}}' class='btn_style1' />
                                    </li>

                                    @if (count($errors) > 0)
                                        @foreach ($errors->all() as $error)
                                            <li class='item'>
                                                <div class="result_style2 disable_max_width sign e">
                                                    <div class="text icon">{{$error}}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                    @if(Session::has('err'))
                                        <li class='item'>
                                            <div class="result_style2 disable_max_width sign e">
                                                <div class="text icon">{{session('err')}}</div>
                                            </div>
                                        </li>
                                    @endif
                                    @if(Session::has('msg'))
                                        <li class='item'>
                                            <div class="result_style2 disable_max_width sign s">
                                                <div class="text icon">{{session('msg')}}</div>
                                            </div>
                                        </li>
                                    @endif


                                </ul>
                            </div><!--inner_form-->
                        </form>
                    </div><!--form_style1-->
                </div><!--inner-->
            </div><!--container-->
        </section><!--login_part1-->

    @include('admin.partial.login-scripts')

    </body>

</html>