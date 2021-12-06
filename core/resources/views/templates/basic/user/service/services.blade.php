@extends($activeTemplate.'layouts.master')
@section('content')

<section class="pt-50 pb-100 section--bg">
    <div class="container">

        <div class="transaction-title d-flex justify-content-end align-items-center">
            <a href="{{ route('user.history.service') }}" class="btn bg-primary text-white">@lang('Service History')</a>
        </div>

        <div class="row justify-content-center mb-none-30 pt-50">

            @forelse($services as $index => $data)
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="d-widget">

                        <h3 class="text-center">
                            {{ __($data->name) }} <small>( {{ __($data->category->name) }} )</small>
                        </h3>

                        <div class="mt-4 mb-4 text-center">
                            <ul>
                                <li>
                                    <span class="font-weight-bold">@lang('Processing Time')</span>
                                    <span class="">{{ __($data->delay) }}</span>
                                </li>
                                <li>
                                    <span class="font-weight-bold">@lang('Fixed Charge')</span>
                                    <span class="">{{ getAmount($data->fixed_charge) }} {{ __($general->cur_text) }}</span>
                                </li>
                                <li>
                                    <span class="font-weight-bold">@lang('Parcent Charge')</span>
                                    <span class="">{{ getAmount($data->percent_charge) }} %</span>
                                </li>
                            </ul>
                        </div>

                        <div class="price-footer">
                            <a href="javascript:void(0)" class="cmn-btn bg-primary w-100 text-center apply" data-toggle="modal" data-target="#applyModal"
                            data-id="{{$data->id}}"
                            data-fix_charge="{{getAmount($data->fixed_charge)}}"
                            data-percent_charge="{{getAmount($data->percent_charge)}}"
                            data-category="{{ __($data->category->name) }}"
                            data-service="{{ __($data->name) }}"
                            >@lang('Continue')</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty mt-5">
                    <h3>@lang('Data Not Found')!</h3>
                </div>
            @endforelse 

        </div>

        {{ $services->links() }}

    </div>
</section>

<div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white bg-primary">
                <strong class="modal-title method-name" id="depositModal"></strong>
                <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form action="{{route('user.service.apply')}}" method="post">
                @csrf
                <div class="modal-body">
                    <p class="text-dark service" style="font-weight: bold;"></p>
                    <p class="text-dark charge" style="font-weight: bold;"></p>
                    <input type="hidden" name="id">
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <label for="amount" style="font-weight: bold; color:black;">@lang('Amount'):</label>
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

@endsection

@push('script')
    <script>

        (function($){

        "use strict";

            $('.apply').on('click', function () {
                var modal = $('#applyModal');
                modal.find('input[name=id]').val($(this).data('id'));
                var baseSymbol = "{{__($general->cur_text)}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');
                var category = $(this).data('category');
                var service = $(this).data('service');
                $('.method-name').text(`@lang('Enter Amount of ') ${category}`);
                var service = `@lang('Service'): ${service}`;
                $('.service').text(service);
                var charge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.charge').text(charge);
            });

        })(jQuery);

    </script>
@endpush
