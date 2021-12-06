@extends($activeTemplate.'layouts.master')

@section('content')

    <!-- dashboard start -->
    <section class="pt-50 pb-120 section--bg">
      <div class="container">

        <div class="rank__card">
           <div class="input-group">
              <input type="text" readonly="" value="{{ route('user.refer.register', $user->username) }}" class="form-control text-center" aria-label="Referral Link" aria-describedby="basic-addon2" id="link">
              <div class="input-group-append">
                <span class="input-group-text bg-primary text-white" id="basic-addon2" onclick="copyRefLink()" style="cursor: pointer;">
                    <i class="las la-copy"></i>
                </span>
              </div>
            </div>
        </div>

        <div class="row justify-content-center mb-none-30 pt-50">
          <div class="col-lg-4 col-md-6 mb-30">
            <div class="d-widget d-flex flex-wrap align-items-center border-radius--8">
              <div class="d-widget__content">
                <h3 class="d-number">
                    {{ $general->cur_sym }}{{ getAmount($user->balance, 2) }}
                </h3>
                <span class="caption">@lang('Total Balance')</span>
              </div>
              <div class="d-widget__icon border-radius--100">
                <i class="las la-wallet"></i>
              </div>
            </div><!-- d-widget end -->
          </div>
          <div class="col-lg-4 col-md-6 mb-30">
            <div class="d-widget d-flex flex-wrap align-items-center border-radius--8">
              <div class="d-widget__content">
                <h3 class="d-number">
                    {{ $general->cur_sym }}{{ getAmount($widgets['total_deposit'], 2) }}
                </h3>
                <span class="caption">@lang('Total Deposit')</span>
              </div>
              <div class="d-widget__icon border-radius--100">
                <i class="las la-hand-holding-usd"></i>
              </div>
            </div><!-- d-widget end -->
          </div>
          <div class="col-lg-4 col-md-6  mb-30">
            <div class="d-widget d-flex flex-wrap align-items-center border-radius--8">
              <div class="d-widget__content">
                <h3 class="d-number">
                    {{ getAmount($widgets['total_trx'], 2) }}
                </h3>
                <span class="caption">@lang('Transactions')</span>
              </div>
              <div class="d-widget__icon border-radius--100">
                <i class="las la-exchange-alt"></i>
              </div>
            </div><!-- d-widget end -->
          </div>
          <div class="col-lg-4 col-md-6 mb-30">
            <div class="d-widget style--two d-flex flex-wrap align-items-center border-radius--8">
              <div class="d-widget__content">
                <h3 class="d-number">{{ $widgets['count_apply_service'] }}</h3>
                <span class="caption">@lang('Service Purchase')</span>
              </div>
              <div class="d-widget__icon border-radius--100">
                <i class="las la-clipboard-list"></i>
                <a href="{{ route('user.history.service') }}" class="d-widget__btn mt-2">@lang('View all')</a>
              </div>
            </div><!-- d-widget end -->
          </div>
          <div class="col-lg-4 col-md-6 mb-30">
            <div class="d-widget style--two d-flex flex-wrap align-items-center border-radius--8">
              <div class="d-widget__content">
                <h3 class="d-number">{{ $widgets['count_apply_service_pending'] }}</h3>
                <span class="caption">@lang('Pending Services')</span>
              </div>
              <div class="d-widget__icon border-radius--100">
                <i class="las la-spinner"></i>
                <a href="{{ route('user.history.service.pending') }}" class="d-widget__btn mt-2">@lang('View all')</a>
              </div>
            </div><!-- d-widget end -->
          </div>
          <div class="col-lg-4 col-md-6 mb-30">
            <div class="d-widget style--two d-flex flex-wrap align-items-center border-radius--8">
              <div class="d-widget__content">
                <h3 class="d-number">{{ $widgets['downline'] }}</h3>
                <span class="caption">@lang('Downline')</span>
              </div>
              <div class="d-widget__icon border-radius--100">
                <i class="las la-link"></i>
                <a href="{{ route('user.downlines') }}" class="d-widget__btn mt-2">@lang('View all')</a>
              </div>
            </div><!-- d-widget end -->
          </div>
        </div><!-- row end -->

        <div class="row mt-5">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">@lang('Latest Transaction')</h6>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive--md">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>@lang('Transaction Id')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Charge')</th>
                        <th>@lang('Post Balance')</th>
                        <th>@lang('Details')</th>
                        <th>@lang('Date')</th>
                      </tr>
                    </thead>
                    <tbody>
                    @forelse($latestTrx as $singleTrx)    
                      <tr>
                        <td data-label="@lang('Transaction Id')">
                            <b>{{ __($singleTrx->trx) }}</b>
                        </td>
                        <td data-label="@lang('Amount')">
                            {{ __($singleTrx->trx_type) }}
                            {{ getAmount($singleTrx->amount) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Charge')">
                            {{ getAmount($singleTrx->charge) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Post Balance')">
                            {{ getAmount($singleTrx->post_balance) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Details')">
                            {{ __($singleTrx->details) }}
                        </td>
                        <td data-label="@lang('Date')">
                            {{ showDateTime($singleTrx->created_at, 'd-m-Y') }}
                        </td>
                      </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">@lang('Data Not Found')!</td>
                        </tr>
                    @endforelse 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </section>
    <!-- dashboard end -->

@endsection


@push('style')
<style>
    .rank__card{
        max-width: 100% !important;
    }
</style>
@endpush

@push('script')
    <script>
        "use strict";

        const copyRefLink = ()=> {
            var copyText = document.getElementById("link");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            notify('success', "Copied: " + copyText.value);
        }

    </script>
@endpush
