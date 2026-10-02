<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="fa">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @if(isset($items))
            @if(count($items) > 2)
                {{$items[1]['title']}} - {{$items[2]['title']}}
            @else
                @php $lastElement = end($items); @endphp
                {{$lastElement['title']}}
            @endif
        @else
            {{__('content.site_name')}}
        @endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="{{__('content.author')}}">
    <meta name="keyword" content="{{__('content.keyword')}}">
    @include('admin.partial.no_index')
    <link rel='shortcut icon' href="{{asset('assets/front/favicon.ico')}}" type='image/x-icon'>
    <link rel='icon' href="{{asset('assets/front/favicon.ico')}}" type='image/x-icon'>
    <!-- stylesheets -->
    <link href="{{asset('assets/admin/_css/master.rtl.css')}}" rel="stylesheet" type="text/css">
    @if(__('content.direction') == "ltr")
        <link href="{{asset('assets/admin/_css/master.ltr.css')}}" rel="stylesheet" type="text/css">
    @endif
    <link href="{{asset('assets/admin/_css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/_css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/_css/core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/_css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/_css/custom.css')}}" rel="stylesheet" type="text/css">

    <!-- /stylesheets -->

    <!-- JS files -->
    <script type="text/javascript" src="{{asset('assets/admin/_js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/admin/_js/global.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/admin/_js/sidebar.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/admin/_js/bootstrap.min.js')}}"></script>
    <!-- /JS files -->
<style>
    .pointer {cursor: pointer;}
</style>
    @yield('css')

</head>
