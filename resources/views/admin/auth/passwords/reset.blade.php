<!DOCTYPE html>
<html lang="{{__('content.language')}}" dir="{{__('content.direction')}}">
@include('admin.partial.header')

<body class="login-container login-cover">

<section class='login_part1'>
    <div class='container'>
        <div class='inner'>
            <div class='form_style1'>
                <form method="post" action="{{ route('admin.password.reset') }}" class="form-validate">
                    {{csrf_field()}}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class='inner_form'>
                        <div class='logo_atlas' style="background-image:url({{asset('assets/admin/_images/logo/atlas_logo.png')}});"></div><!--logo_atlas-->
                        <div class='title'>{{__('content.login_to_your_account')}} <small class="display-block">{{__('content.your_credentials')}}</small></div><!--title-->

                        <ul class='list step1'>

                            <li class='item'>
                                <div class='item_inner'>
                                    <span class='field_icon'><i class='i-person'></i></span>
                                    <input type='text' name='email' value='{{ old('email') }}' class='ltr en_words' required="required"/>
                                </div><!--item_inner-->
                            </li>

                            <li class='item'>
                                <div class='item_inner'>
                                    <span class='field_icon'><i class='i-unlock-alt'></i></span>
                                    <input type='password' name='password' class='ltr' placeholder="{{__('content.password')}}" required="required"/>
                                </div><!--item_inner-->
                            </li>

                            <li class='item'>
                                <div class='item_inner'>
                                    <span class='field_icon'><i class='i-unlock-alt'></i></span>
                                    <input type='password' name='password_confirmation' class='ltr' placeholder="{{__('content.password_confirm')}}" required="required"/>
                                </div><!--item_inner-->
                            </li>

                            <li class='item submit'>
                                <input type='submit' name='go_login' value='{{__('content.change_password')}}' class='btn_style1' />
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