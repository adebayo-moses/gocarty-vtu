@php
    $payments = App\Models\GateWay::where('status', 1)->latest()->get();
    $paymentData = getContent('payment.content', true);
@endphp

 <!-- partner section start -->
  <section class="pt-100 pb-100 section--bg" id="payment">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="section-header text-center">
            <h2 class="section-title">{{ __(@$paymentData->data_values->heading) }}</h2>
            <p>{{ __(@$paymentData->data_values->sub_heading) }}</p>
          </div>
        </div>
      </div><!-- row end -->
      <div class="payment-slider">

        @foreach($payments as $payment)
            <div class="single-slide">
                <div class="payment-slide">
                    <img src="{{ getImage(imagePath()['gateway']['path'] .'/'. $payment->image, '800x800') }}" alt="image">
                </div><!-- partner-item end -->
            </div>
        @endforeach

      </div>
    </div>
  </section>
  <!-- partner section end -->
