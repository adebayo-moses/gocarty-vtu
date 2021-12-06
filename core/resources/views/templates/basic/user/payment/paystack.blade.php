@extends($activeTemplate.'layouts.master')

@section('content')

<section class="pt-120 pb-120 section--bg">
  <div class="container">

        <div class="withdraw-preview">
            <div class="row justify-content-center mb-30-none">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card main-card p-1">

                    <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST">
                        <div class="card-body">
                            <div class="bank-logo">
                                <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="withdraw">
                            </div>

                            <div class="data text-center">
                                <p>
                                    @lang('Please Pay'):
                                    {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}
                                </p>
                                <p>
                                    @lang('To Get'):
                                    {{getAmount($deposit->amount)}}  {{__($general->cur_text)}}
                                </p>
                            </div>

                        </div>

                        <div class="card-footer border-0 text-center">
                            <button type="button" id="btn-confirm" class="bg-primary cmn-btn w-100" data-toggle="modal">
                                @lang('Pay Now')
                            </button>
                        </div>
                        <script
                            src="//js.paystack.co/v1/inline.js"
                            data-key="{{ $data->key }}"
                            data-email="{{ $data->email }}"
                            data-amount="{{$data->amount}}"
                            data-currency="{{$data->currency}}"
                            data-ref="{{ $data->ref }}"
                            data-custom-button="btn-confirm"
                        >
                        </script>
                    </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
