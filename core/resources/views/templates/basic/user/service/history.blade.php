@extends($activeTemplate.'layouts.master')
@section('content') 

    <!-- dashboard start -->
    <section class="pt-120 pb-120 section--bg">
      <div class="container">

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">{{ __($page_title) }}</h6>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive--md">
                  <table class="table">
                    <thead>
                        <tr>
                            <th>@lang('Category')</th>
                            <th>@lang('Service')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Charge')</th>
                            <th>@lang('After Charge')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Select')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($histories as $data)  
                      <tr>
                        <td data-label="@lang('Category')">
                                {{ __(@$data->service->category->name) }}
                        </td>
                        <td data-label="@lang('Service')">
                                {{ __(@$data->service->name) }}
                        </td>
                        <td data-label="@lang('Amount')">
                            {{ getAmount($data->amount) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Charge')">
                            {{ getAmount($data->total_charge) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('After Charge')">
                            {{ getAmount($data->after_charge) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Post Balance')">
                            {{ getAmount($data->post_balance) }}
                            {{ __($general->cur_text) }}
                        </td>
                        <td data-label="@lang('Select')">
                            @if($data->select_field)
                                @php
                                    $array = (array) json_decode($data->select_field);
                                    $serviceType = key($array);
                                    $service = array_values($array);
                                    $service = implode(' ', $service);

                                    echo ucfirst($serviceType).'<br/>'. $service;
                                @endphp
                            @else
                                @lang('N/A')
                            @endif
                        </td>
                        <td data-label="@lang('Status')">
                            @if($data->status == 2)
                                <span class="badge badge-warning style--light">@lang('Pending')</span>
                            @elseif($data->status == 1)
                                <span class="badge badge-success style--light">@lang('Approved')</span>
                            @elseif($data->status == 3) 
                                <span class="badge badge-danger style--light">@lang('Rejected')</span>
                            @endif

                            <a href="javascript:void(0)" class="icon-btn bg-primary text-white detailBtn ml-2" 
                            data-message="{{$data->admin_feedback}}"
                            data-details="{{ $data->user_data }}"
                            >
                                <i class="las la-info"></i>
                            </a>

                        </td>
                        <td data-label="@lang('Date')">
                            {{ showDateTime($data->created_at, 'm-d-Y') }}
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

{{-- Detail MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <strong class="modal-title">@lang('Details')!</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>@lang('Admin Feedback')</h6>
                <div class="admin_feedback"></div>

                <div class="detailsArea mt-4">
                    
                </div>

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

        $('.detailBtn').on('click', function() {
            var modal = $('#detailModal');
            var feedback = $(this).data('message');

            if(!feedback){
                feedback = '@lang("No Feedback")';
            }

            var details = $(this).data('details');
            var singleInfo = '';

            modal.find('.admin_feedback').html(`<p> ${feedback} </p>`);

            $.each(details, function( index, value ){

                if(value['type'] != 'file' && value['type'] != 'textarea'){

                    singleInfo += `<div class='d-block'>
                                        <span class="" style="color:black; text-transform: capitalize;"> 
                                            ${value['field_name'].replaceAll('_', " ")} 
                                        </span> 
                                        : 
                                        <span>
                                            ${value['field_value']}
                                        </span>
                                   </div>`;
                }

            });

            modal.find('.detailsArea').html(`${singleInfo}`);

            modal.modal('show');
        });
        $('.main-wrapper').addClass('section--bg');

    })(jQuery);

    </script>
@endpush