@extends($activeTemplate.'layouts.master')
@section('content')

<section class="pt-120 pb-120 section--bg">
  <div class="container">

        <div class="withdraw-preview">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card main-card">
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

                        <div class="card-footer text-center">
                            <button type="button" id="btn-confirm" class="w-100 bg-primary cmn-btn" id="btn-confirm">
                                @lang('Pay Now')
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
@push('script')
    <script src="//voguepay.com/js/voguepay.js"></script>
    <script>
        "use strict";
        var closedFunction = function() {
        }
        var successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        var failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5af93ca2913fd',
                store_id:"{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        $(document).ready(function () {
            $(document).on('click', '#btn-confirm', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });
        });
    </script>
@endpush
