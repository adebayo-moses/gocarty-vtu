@extends($activeTemplate.'layouts.master')
@section('content')

    <!-- dashboard start -->
    <section class="pt-120 pb-120 section--bg">
      <div class="container">

        <div class="row mt-5">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">{{ __($page_title) }}</h6>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive--md">
                  <table class="table white-space-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Trx')</th>
                            <th scope="col">@lang('Gateway')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Time')</th>
                            <th scope="col"> @lang('Details')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $log)    
                      <tr>
                        <td data-label="@lang('Trx')">{{$log->trx}}</td>
                        <td data-label="@lang('Gateway')">{{ __(@$log->gateway->name)  }}</td>
                        <td data-label="@lang('Amount')">
                            <strong>{{getAmount($log->amount)}} {{__($general->cur_text)}}</strong>
                        </td>
                        <td>
                            @if($log->status == 1)
                                <span class="badge badge-success style--light">@lang('Complete')</span>
                            @elseif($log->status == 2)
                                <span class="badge badge-warning style--light">@lang('Pending')</span>
                            @elseif($log->status == 3)
                                <span class="badge badge-danger style--light">@lang('Rejected')</span>
                            @endif

                            @if($log->admin_feedback != null)
                                <a href="javascript:void(0)" class="icon-btn bg-primary text-white detailBtn" data-admin_feedback="{{$log->admin_feedback}}">
                                    <i class="las la-info"></i>
                                </a>
                            @endif

                        </td>
                        <td data-label="@lang('Time')">
                            {{showDateTime($log->created_at)}}
                        </td>

                        @php
                            $details = ($log->detail != null) ? json_encode($log->detail) : null;
                        @endphp

                        <td data-label="@lang('Details')">
                            <a href="javascript:void(0)" class="icon-btn bg-primary text-white approveBtn"
                               data-info="{{$details}}"
                               data-id="{{ $log->id }}"
                               data-amount="{{ getAmount($log->amount)}} {{ __($general->cur_text) }}"
                               data-charge="{{ getAmount($log->charge)}} {{ __($general->cur_text) }}"
                               data-after_charge="{{ getAmount($log->amount + $log->charge)}} {{ __($general->cur_text) }}"
                               data-rate="{{ getAmount($log->rate)}} {{ __($log->method_currency) }}"
                               data-payable="{{ getAmount($log->final_amo)}} {{ __($log->method_currency) }}">
                                <i class="las la-desktop"></i>
                            </a>
                        </td>
                      </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">@lang('Data Not Found')!</td>
                        </tr>
                    @endforelse 
                    </tbody>
                  </table>

                    {{ $logs->links() }}

                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </section>
    <!-- dashboard end -->

{{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-white bg-primary">
                    <strong class="modal-title">@lang('Details')</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <p class="" style="font-weight: bold; color:black;">@lang('Amount') : <span class="withdraw-amount "></span></p>
                        <p class="" style="font-weight: bold; color:black;">@lang('Charge') : <span class="withdraw-charge "></span></p>
                        <p class="" style="font-weight: bold; color:black;">@lang('After Charge') : <span class="withdraw-after_charge"></span></p>
                        <p class="" style="font-weight: bold; color:black;">@lang('Conversion Rate') : <span class="withdraw-rate"></span></p>
                        <p class="" style="font-weight: bold; color:black;">@lang('Payable Amount') : <span class="withdraw-payable"></span></p>
                    </div>
                    <div class="list-group withdraw-detail mt-1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <strong class="modal-title">@lang('Details')</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script>
        (function($){

        "use strict";

        $('.approveBtn').on('click', function() {
            var modal = $('#approveModal');
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-charge').text($(this).data('charge'));
            modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
            modal.find('.withdraw-rate').text($(this).data('rate'));
            modal.find('.withdraw-payable').text($(this).data('payable'));
            var list = [];
            var details =  Object.entries($(this).data('info'));

            var ImgPath = "{{asset(imagePath()['verify']['deposit']['path'])}}/";
            var singleInfo = '';

            for (var i = 0; i < details.length; i++) {
                if (details[i][1].type == 'file') {
                    singleInfo += `<li class="list-group-item">
                                        <span class="font-weight-bold" style="font-weight: bold; color:black;"> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="@lang('Image')" class="w-100">
                                    </li>`;
                }else{
                    singleInfo += `<li class="list-group-item">
                                        <span class="font-weight-bold" style="font-weight: bold; color:black;"> ${details[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3 custom--cr">${details[i][1].field_name}</span>
                                    </li>`;
                }
            }

            if (singleInfo)
            {
                modal.find('.withdraw-detail').html(`<br><strong class="my-3" style="font-weight: bold; color:black;">@lang('Payment Information')</strong>  ${singleInfo}`);
            }else{
                modal.find('.withdraw-detail').html(`${singleInfo}`);
            }
            modal.modal('show');
        });

        $('.detailBtn').on('click', function() {
            var modal = $('#detailModal');
            var feedback = $(this).data('admin_feedback');
            modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
            modal.modal('show');
        });

        })(jQuery);

    </script>
@endpush
