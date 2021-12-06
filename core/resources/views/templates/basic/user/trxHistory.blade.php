@extends($activeTemplate.'layouts.master')
@section('content')

    <!-- dashboard start -->
    <section class="pt-120 pb-120 section--bg">
      <div class="container">

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">@lang('Transaction History')</h6>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive--md">
                  <table class="table">
                    <thead>
                        <tr>
                            <th>@lang('Trx')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Charge')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Details')</th>
                            <th>@lang('Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($histories as $data)    
                      <tr>
                        <td data-label="@lang('Transaction Id')">
                                <b>{{ __($data->trx) }}</b>
                        </td>
                        <td data-label="@lang('Amount')">
                            {{ __($data->trx_type) }}
                            {{ getAmount($data->amount) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Charge')">
                            {{ getAmount($data->charge) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Post Balance')">
                            {{ getAmount($data->post_balance) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Balance')">
                            {{ __($data->details) }}
                        </td>
                        <td data-label="@lang('Date')">
                            {{ showDateTime($data->created_at, 'd-m-Y') }}
                        </td>
                      </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">@lang('Data Not Found')!</td>
                        </tr>
                    @endforelse 
                    </tbody>
                  </table>

                    {{ $histories->links() }}

                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </section>
    <!-- dashboard end -->

@endsection

