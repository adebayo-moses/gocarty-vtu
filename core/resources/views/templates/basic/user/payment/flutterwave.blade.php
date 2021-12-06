@extends($activeTemplate.'layouts.master')

@section('content')
<section class="pt-120 pb-120 section--bg">
    <div class="container">

        <div class="withdraw-preview">
            <div class="row justify-content-center mb-30-none">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card main-card">

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

                        <div class="card-footer border-0 text-center">
                            <button type="button" onClick="payWithRave()" id="btn-confirm" class="bg-primary w-100 cmn-btn" id="btn-confirm">
                                @lang('Pay Now')
                            </button>
                        </div>

                        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                        <script>

                            var btn = document.querySelector("#btn-confirm");
                            btn.setAttribute("type", "button");
                            const API_publicKey = "{{$data->API_publicKey}}";

                            function payWithRave() {
                                var x = getpaidSetup({
                                    PBFPubKey: API_publicKey,
                                    customer_email: "{{$data->customer_email}}",
                                    amount: "{{$data->amount }}",
                                    customer_phone: "{{$data->customer_phone}}",
                                    currency: "{{$data->currency}}",
                                    txref: "{{$data->txref}}",
                                    onclose: function () {
                                    },
                                    callback: function (response) {
                                        var txref = response.tx.txRef;
                                        var status = response.tx.status;
                                        var chargeResponse = response.tx.chargeResponseCode;
                                        if (chargeResponse == "00" || chargeResponse == "0") {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        } else {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        }
                                            // x.close(); // use this to close the modal immediately after payment.
                                        }
                                    });
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
