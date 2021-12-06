@extends($activeTemplate.'layouts.master')

@section('content')


<section class="pt-100 pb-100 section--bg">
    <div class="container">

        <!--  Deposit Method Section  -->
        <div class="deposit-section">

            <div class="row justify-content-center">

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="deposit-item">
                        <div class="deposit-thumb">
                            <img src="{{ $data->gateway_currency()->methodImage() }}" alt="deposit">
                        </div>
                        <div class="deposit-content fs-sm mt-2">
                            <ul class="text-center">
                                <li>
                                    @lang('Amount') : {{getAmount($data->amount)}} {{__($general->cur_text)}}
                                </li>
                                <li>
                                    @lang('Charge') : {{getAmount($data->charge)}} {{__($general->cur_text)}}
                                </li>
                                <li>
                                    @lang('Payable') : {{getAmount($data->amount + $data->charge)}} {{__($general->cur_text)}}
                                </li>
                                <li>
                                    @lang('Conversion Rate') : 1 {{__($general->cur_text)}} = {{getAmount($data->rate)}}  {{__($data->baseCurrency())}}
                                </li>

                                @if($data->gateway->crypto==1)
                                <li>
                                    @lang('Conversion with')
                                    <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')
                                </li>
                                @endif

                            </ul>
                            <div class="mt-2">
                                @if( 1000 >$data->method_code)
                                    <a href="{{route('user.deposit.confirm')}}" class="btn bg-primary btn-lg text-white btn-block">@lang('Pay Now')</a>
                                @else
                                    <a href="{{route('user.deposit.manual.confirm')}}" class="btn bg-primary btn-large text-white btn-block">@lang('Pay Now')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--  Deposit Method Section  -->
    </div>
</section>


<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white custom--bg">
                <strong class="modal-title method-name" id="depositModal"></strong>
                <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form action="{{route('user.deposit.insert')}}" method="post">
                @csrf
                <div class="modal-body">
                    <p class="text-dark depositLimit" style="font-weight: bold;"></p>
                    <p class="text-dark depositCharge" style="font-weight: bold;"></p>
                    <div class="form-group">
                        <input type="hidden" name="currency" class="edit-currency" value="">
                        <input type="hidden" name="method_code" class="edit-method-code" value="">
                    </div>
                    <div class="form-group">
                        <label for="amount" style="font-weight: bold; color:black;">@lang('Enter Amount'):</label>
                        <div class="input-group">
                            <input id="amount" type="text" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" id="amount" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}">
                            <div class="input-group-prepend">
                                <span class="input-group-text currency-addon addon-bg custom--bg text-white">{{__($general->cur_text)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn custom--sbg text-white w-100" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn custom--bg text-white w-100">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop
