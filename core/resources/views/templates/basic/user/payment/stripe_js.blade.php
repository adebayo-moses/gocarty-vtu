@extends($activeTemplate.'layouts.master')
@section('content')
<section class="pt-50 pb-120 section--bg">
  <div class="container">

        <div class="withdraw-preview">
            <div class="row justify-content-center mb-30-none">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card main-card">
                        <form action="{{$data->url}}" method="{{$data->method}}">
                        <div class="card-body">
                            <div class="bank-logo">
                                <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="withdraw">
                            </div>

                            <div class="data text-center">
                                <p style="font-size:25px; font-weight: bold;">
                                    @lang('Please Pay'):
                                    {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}
                                </p>

                                <p style="font-size:25px; font-weight: bold;">
                                    @lang('To Get'):
                                    {{getAmount($deposit->amount)}}  {{__($general->cur_text)}}
                                </p>
                            </div>

                        </div>

                        <div class="card-footer text-center">
                            <script
                                src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>
                        </div>

                </div>
            </div>
        </div>

    </div>
</section>
@endsection
@push('style')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
            padding-left: 0px !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($){

        "use strict";

            $('.stripe-button-el').addClass("btn text-white w-100 bg-primary").removeClass('stripe-button-el');
            
        })(jQuery);
    </script>
@endpush
