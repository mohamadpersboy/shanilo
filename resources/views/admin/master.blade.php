<!DOCTYPE html>
<html lang="{{__('content.language')}}" dir="{{__('content.direction')}}">
@include('admin.partial.header')

<body>

<!-- Main navbar -->
@include('admin.partial.navbar')
<!-- /main navbar -->


<div id='all_page_container' class='container clearfix'>
    <div id='all_page_container_bg'></div>

    <!-- Main sidebar -->
@include('admin.partial.sidebar')
<!-- /main sidebar -->

    <div class='mainside_style1'>
        @yield('content')
    </div>

</div>


<!-- All Script Sources -->
@include('admin.developer.global_js')
@include('admin.partial.scripts')

<!-- Reza Sarlak -->
@include('admin.layouts.delete_all')
@yield('script')
</body>
</html>
