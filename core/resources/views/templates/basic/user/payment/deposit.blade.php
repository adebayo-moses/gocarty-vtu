@extends($activeTemplate.'layouts.master')

@section('content')

<section class="pt-50 pb-100 section--bg">
    <div class="container">

        <!--  Deposit Method Section  -->
        <div class="deposit-section">
            <div class="transaction-title d-flex justify-content-end align-items-center">
                <a href="{{ route('user.deposit.history') }}" class="cmn-btn btn-sm">@lang('Deposit History') <i class="las la-arrow-right"></i></a>
            </div>
            <div class="row mb-30-none justify-content-center">

            @foreach($gatewayCurrency as $data)
                <div class="col-lg-3 col-md-4 col-sm-6 mt-4">
                    <div class="deposit-item">
                        <div class="deposit-thumb">
                            <img src="{{$data->methodImage()}}" alt="deposit">
                        </div>
                        <div class="deposit-content fs-sm">
                            <div class="mt-1">
                                <a href="javascript:void(0)"
                                    data-id="{{$data->id}}" data-resource="{{$data}}"
                                    data-min_amount="{{getAmount($data->min_amount)}}"
                                    data-max_amount="{{getAmount($data->max_amount)}}"
                                    data-base_symbol="{{$data->baseSymbol()}}"
                                    data-fix_charge="{{getAmount($data->fixed_charge)}}"
                                    data-percent_charge="{{getAmount($data->percent_charge)}}"
                                class="btn-light deposit text-center w-100"
                                data-toggle="modal" data-target="#depositModal">@lang('Deposit Now')</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            </div>
        </div>
        <!--  Deposit Method Section  -->
    </div>
</section>


<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
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
                                <span class="input-group-text currency-addon addon-bg bg-primary text-white">{{__($general->cur_text)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn bg-primary text-white">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop


@push('script')
    <script>
        "use strict";

        (function($){

            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{__($general->cur_text)}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${result.name}`);
                $('.currency-addon').text(baseSymbol);

                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.method_code);
            });

        })(jQuery);

    </script>
@endpush
