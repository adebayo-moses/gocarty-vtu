@php
    $data = getContent('partner.content', true);
    $partners = getContent('partner.element');
@endphp

<!-- Partner Section -->
<section class="pt-100 pb-100" id="partner">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="section-header text-center">
            <h2 class="section-title">{{ __($data->data_values->heading) }}</h2>
            <p>{{ __($data->data_values->sub_heading) }}</p>
            </div>
        </div>
        </div><!-- row end -->
        <div class="row">
            <div class="col-lg-12">
                <div class="client-slider">

                @foreach($partners as $partner)
                    <div class="single-slide">
                        <div class="client-item">
                            <img src="{{ getImage( 'assets/images/frontend/partner/' .@$partner->data_values->image, '228x128') }}" alt="image">
                        </div>
                    </div><!-- single-slide end -->
                @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Partner Section -->
