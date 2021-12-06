@if(request()->routeIs('home'))

@php
    $banner = getContent('banner.content', true);
@endphp

<!-- hero start -->
<section class="hero bg_img" data-background="{{ getImage( 'assets/images/frontend/banner/' .@$banner->data_values->image, '1920x1080') }}">
<div id="particles-js"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="hero__title text-white wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                    {{ __(@$banner->data_values->heading) }}
                </h2>
                <p class="mt-3 text-white wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    {{ __(@$banner->data_values->sub_heading) }}
                </p>
            </div>
        </div>
    </div>
</section>
<!-- hero end -->
@else

@php
    $breadCumb = getContent('breadcrumb.content', true);
@endphp

<!-- inner hero section start -->
<section class="inner-hero bg_img" data-background="{{ getImage( 'assets/images/frontend/breadcrumb/' .@$breadCumb->data_values->image, '1920x1080') }}">
    <div id="particles-js"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="inner-hero-content text-center">
                <h2 class="inner-hero__title text-white">{{ __($page_title) }}</h2>
                <ul class="page-breadcrumb justify-content-center">
                    <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                    <li>{{ __($page_title) }}</li>
                </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- inner hero section end -->
@endif
