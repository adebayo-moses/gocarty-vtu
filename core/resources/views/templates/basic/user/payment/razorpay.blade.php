@extends($activeTemplate.'layouts.master')

@section('content')
<section class="pt-120 pb-120 section--bg">
  <div class="container">

        <div class="withdraw-preview">
            <div class="row justify-content-center mb-30-none">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card main-card border-top-0">

                    <form action="{{$data->url}}" method="{{$data->method}}">
                        <div class="card-body">
                            <div class="bank-logo my-3">
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

                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >
                            </script>
                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
                    </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection


@push('script')
    <script>
       (function($){

        "use strict";
        
            $('input[type="submit"]').addClass("btn w-100 bg-primary text-white");

        })(jQuery);
    </script>
@endpush
