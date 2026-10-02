@php
    $froot=url('assets/front').'/';
    $pageTitle=isset($pageTitle)?$pageTitle:'شبکه تجاری شانیلو ';
@endphp
<!-- <title>█░░{{$pageTitle}}█░░</title> -->
<title>{{$pageTitle}}</title>

<!-- Meta_Tags -->
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<base href="{{$froot}}">

<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="description" content=""/>
<meta name="theme-color" content="#973e8f">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<meta name="csrf-token" content="{{csrf_token()}}">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

<link rel='stylesheet' type='text/css' href='_css/fonts/so-shop/styles.css'>
<link rel='stylesheet' type='text/css' href='_css/animate.css'>
<link rel="stylesheet" type="text/css" href="_css/master.css?ver=37">
<link rel="stylesheet" type="text/css" href="_css/media.css?ver=12">
<link rel="stylesheet" type="text/css" href="_css/toastr.min.css">
<link rel="stylesheet" type="text/css" href="_css/newstyle.css">
<link rel="stylesheet" type="text/css" href="_css/ticket.css">
<link rel="stylesheet" type="text/css" href="_css/responsive.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<meta name="yn-tag" id="e72ff50f-4e35-4723-bc75-ac6c906b5d96">

<meta name="enamad" content="586330"/>

<script src="_js/jquery-1.11.1.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
{{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-130627148-1"></script>--}}
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-130627148-1');
</script>
<script type="text/javascript">
    window.$crisp = [];
    window.CRISP_WEBSITE_ID = "c8f6c7e4-9e81-4c83-9324-03fe4e131786";
    (function () {
        d = document;
        s = d.createElement("script");
        s.src = "https://client.crisp.chat/l.js";
        s.async = 1;
        d.getElementsByTagName("head")[0].appendChild(s);
    })();
</script>

<script>
    //اسکریپت یکتا نت
    !function (t, e, n) {
        t.yektanetAnalyticsObject = n, t[n] = t[n] || function () {
            t[n].q.push(arguments)
        }, t[n].q = t[n].q || [];
        var a = new Date,
            r = a.getFullYear().toString() + "0" + a.getMonth() + "0" + a.getDate() + "0" + a.getHours(),
            c = e.getElementsByTagName("script")[0],
            s = e.createElement("script");
        s.id = "ua-script-yn-15491-adv";
        s.dataset.analyticsobject = n;
        s.async = 1;
        s.type = "text/javascript";
        s.src = "https://cdn.yektanet.com/rg_woebegone/scripts_v2/yn-15491-adv/rg.complete.js?v=" + r, c.parentNode.insertBefore(s, c)
    }(window, document, "yektanet");


    // home slider
    const handleSlide = (path, link) => {
        return `<a href="${link}" class="home-slider__item">
					<img src="${path}" alt="">
				</a>`
    }
    $.ajax({
        url: "/sliders",
        type: "GET",
        cache: false,
        success: function (slides) {
            slides.sliders.forEach(slide => {
                if (slide.type === 'desktop' && window.innerWidth > 768) {
                    $("#homeSlider").append(handleSlide(slide.path, slide.link));
                }
                if (slide.type === 'mobile' && window.innerWidth < 768) {
                    $("#homeSlider").append(handleSlide(slide.path, slide.link));
                }
                if (slide.type === 'min_image') {
                    $("#minImageSlider").append(`<div class="right_part user_pic" style="background-image: url(${slide.path});"></div>`)
                }
            });
        }
    });
</script>
