<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('partials.seo')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/vendor/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/main.css') }}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/bootstrap-fileinput.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color)}}">

    @stack('style-lib')

    @stack('style')

</head>

<body>

@php echo loadFbComment() @endphp

    <div class="preloader">
        <div class="preloader-container">
        <span class="animated-preloader"></span>
        </div>
    </div>

    <!-- scroll-to-top start -->
    <div class="scroll-to-top">
        <span class="scroll-icon">
            <i class="las la-angle-up"></i>
        </span>
    </div>

    <!-- scroll-to-top end -->
    <div class="page-wrapper">

        @include($activeTemplate.'partials.header')

        <div class="main-wrapper">

            @include($activeTemplate.'partials.banner')

            @yield('content')

        </div>

        @include($activeTemplate.'partials.footer')

    </div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset($activeTemplateTrue.'js/vendor/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue.'js/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue.'js/vendor/slick.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue.'js/vendor/wow.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue.'js/app.js') }}"></script>
<script src="{{ asset($activeTemplateTrue.'js/vendor/particles.js') }}"></script>
<script src="{{ asset($activeTemplateTrue.'js/vendor/app.js') }}"></script>

<script src="{{ asset($activeTemplateTrue.'/js/bootstrap-fileinput.js') }}"></script>

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('admin.partials.notify')

<script>
    (function ($) {

        "use strict";

        $(document).on("change", ".langSel", function() {
            window.location.href = "{{url('/')}}/change/"+$(this).val() ;
        });

        let currentRoute = '{{ Route::currentRouteName() }}'

        let anchor = $('#navbarSupportedContent li a');

        let sectionArray = [];

        $.each(anchor, function(key, value) {
          let href = $(value).attr('href');
          let firstChar = href.charAt(0);

          if(firstChar == '#'){
            sectionArray[key] = href;
          }
          
        });

        if(currentRoute != 'home'){
            let links = $('#linkItem a');

            links.on('click', function(){

                let section = $(this).attr('href');
                let base = '{{ route('home') }}';

                if(sectionArray.includes(section)){
                    window.location = base+section;
                }

            });
        }

    })(jQuery);
</script>

</body>
</html>
