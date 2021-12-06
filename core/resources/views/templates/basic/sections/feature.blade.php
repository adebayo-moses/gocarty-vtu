@php
    $features = getContent('feature.element');
    $feature = getContent('feature.content', true);
@endphp

<!-- features section start -->
<section class="pt-100 pb-100" id="feature">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="section-header text-center">
            <div class="section-top-title">{{ __(@$feature->data_values->heading) }}</div>
            <h2 class="section-title">{{ __(@$feature->data_values->sub_heading) }}</h2>
            </div>
        </div>
        </div><!-- row end -->
        <div class="row justify-content-between align-items-center">
        <div class="col-lg-4 d-lg-block d-none wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.3s">
            <div class="feature-thumb">
            <img src="{{ getImage( 'assets/images/frontend/feature/' .@$feature->data_values->image, '1230x1060') }}" alt="image">
            </div>
        </div>
            <div class="col-lg-8 ">
                <div class="row mb-none-50">

                @foreach($features as $singleFeature)
                    <div class="col-sm-6 mb-50">
                        <div class="feature-card d-flex flex-wrap">
                        <div class="feature-card__icon">
                            @php echo $singleFeature->data_values->icon; @endphp
                        </div>
                        <div class="feature-card__content">
                            <h5 class="title">{{ __($singleFeature->data_values->heading) }}</h5>
                            <p>{{ __($singleFeature->data_values->text) }}</p>
                        </div>
                        </div><!-- feature-card end -->
                    </div>
                @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- features section end -->
