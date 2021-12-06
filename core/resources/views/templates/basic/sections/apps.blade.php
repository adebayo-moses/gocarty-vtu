@php
    $app = getContent('apps.content', true);
@endphp

<!-- app section start -->
<section class="app-download-section pt-120" id="app">
    <div class="container">
        <div class="row align-items-end justify-content-lg-between">
        <div class="col-lg-4 col-md-6 d-md-block d-none wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.3s">
            <div class="app-thumb">
            <img src="{{ getImage( 'assets/images/frontend/apps/' .@$app->data_values->image, '768x1170') }}" alt="image">
            </div>
        </div>
        <div class="col-lg-7 col-md-6">
            <div class="app-content">
            <h2 class="title">{{ __(@$app->data_values->heading) }}</h2>
            <p class="mt-4">{{ __(@$app->data_values->sub_heading) }}</p>
            <div class="app-btn-group mt-4">
                <a href="{{ __(@$app->data_values->app_link) }}" target="_blank" class="app-btn">
                    <img src="{{ $activeTemplateTrue.'images/elements/google-paly.png' }}" alt="image">
                </a>
            </div>
            </div>
        </div>
        </div>
    </div>
</section>
<!-- app section end -->
