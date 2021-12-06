@php
    $services = getContent('service.element');
    $service = getContent('service.content', true);
@endphp

<!-- service section start -->
<section class="pt-100 pb-100 section--bg" id="service">
    <div class="container">
        <div class="row">
        <div class="col-lg-6">
            <div class="section-header">
            <div class="section-top-title">{{ __(@$service->data_values->heading) }}</div>
            <h2 class="section-title">{{ __(@$service->data_values->sub_heading) }}</h2>
            </div>
        </div>
        </div><!-- row end -->
        <div class="row justify-content-center mb-none-30">
        @foreach($services as $singleService)
            <div class="col-md-6 mb-30 wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.3s">
                <div class="service-card hover--effect-1 d-flex flex-wrap">
                    <div class="service-card__icon">
                        @php echo $singleService->data_values->icon; @endphp
                    </div>
                    <div class="service-card__content">
                        <h4 class="title">{{ __($singleService->data_values->heading) }}</h4>
                        <p class="mt-3">{{ __($singleService->data_values->text) }}.</p>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</section>
<!-- service section end -->
