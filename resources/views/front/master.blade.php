<!DOCTYPE html>
<html lang="fa">
<head>
    @yield('v2-front-style')
    @include('front.partial.begin')
    @yield('v1-front-style')
</head>
<body>
{!! Form::open(['url'=>route('front.auth.logout'),'id'=>'frm_logout']) !!}
{!! Form::close() !!}
{!! Form::open([
    'url'=>'',
    'id'=>'frm_delete',
    'data-ajax-delete',
    'data-type'=>'json',
    'data-on-success'=>'delete-node',
    'data-on-error'=>'alert-message',
    'method'=>'delete'
]) !!}
{!! Form::close() !!}
<main class="container_style1">

    @include('front.partial.header')

    @include('front.partial.breadcrumb')

    @yield('section')

    @include('front.partial.footer')

    <input id="short-link-code" type="text" value="" style="border: 1px">
</main>
@include('front.partial.end')

<!--all script in this page-->

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    myVar = null;

    function getShortLink(link) {
        $.post("{{ route('front.short.link') }}", function (response) {
            $('#' + link).val(response.code);
        });
    }


</script>
@yield('js')

{{--<script>
    $(function () {
        var customer={
            Username:"09197499970",
            Email:"mohamadpersboy@gmail.com",
            Password:"99709970"
        };

        $.ajax({
            type:"POST",
            url:"https://postbar.ir/api/login",
            dataType:"json",
            contentType:"application/json",
            data:customer,
            success:function(response){
                console.log(response);
            },
            error:function(error){
                console.log(error);
            }
        });
    });
</script>--}}
<script>
    function ticketFileName() {
        var filename = $('input[type=file]').val().split('\\').pop();
        $('.single-ticket__send_upload_input').attr('value', filename)
    }
</script>
</body>
</html>
