@php
    $overView = getContent('overview.content', true);
    $overViews = getContent('overview.element');
@endphp
 <!-- overview section start -->
  <section class="overview-section bg_img" data-background="{{ getImage( 'assets/images/frontend/overview/' .@$overView->data_values->image, '1920x1080') }}">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-5 wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.3s">
          <div class="overview-content">
            <h2 class="title text-white">{{ __(@$overView->data_values->heading) }}</h2>
            <p class="text-white mt-3">{{ __(@$overView->data_values->sub_heading) }}</p>
          </div>
        </div>
        <div class="col-xl-6 col-lg-7 mt-lg-0 mt-4">
          <div class="row mx-0">

            @foreach($overViews as $singleOverView)
                <div class="col-6 overview-item">
                    <div class="overview-card">
                        <div class="overview-card__icon">
                            @php echo $singleOverView->data_values->icon @endphp
                        </div>
                        <div class="overview-card__content">
                            <div class="counter-amount">{{ __($singleOverView->data_values->text) }}</div>
                            <span class="caption">{{ __($singleOverView->data_values->heading) }}</span>
                        </div>
                    </div><!-- overview-card end -->
                </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- overview section end -->
