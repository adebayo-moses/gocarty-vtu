@extends($activeTemplate.'layouts.master')

@section('content')

    <!-- dashboard start -->
    <section class="pt-100 pb-100 section--bg">
      <div class="container">

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">@lang('Support Tickets')</h6>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive--md">
                  <table class="table white-space-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Subject')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Last Reply')</th>
                            <th scope="col">@lang('Action')</th>

                        </tr>
                    </thead>
                    <tbody>
                    @forelse($supports as $key => $support)   
                      <tr>
                            <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [Ticket#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                            <td data-label="@lang('Status')">
                                @if($support->status == 0)
                                    <span class="badge badge-secondary style--light">@lang('Open')</span>
                                @elseif($support->status == 1)
                                    <span class="badge badge-primary style--light">@lang('Answered')</span>
                                @elseif($support->status == 2)
                                    <span class="badge badge-info style--light">@lang('Replied')</span>
                                @elseif($support->status == 3)
                                    <span class="badge badge-danger style--light">@lang('Closed')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                            <td data-label="@lang('Action')">
                                <a href="{{ route('ticket.view', $support->ticket) }}" class="icon-btn text-white bg-primary">
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

                    {{ $supports->links() }}

                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </section>
    <!-- dashboard end -->

@endsection


@push('script')
    <script>
        "use strict";
        $('.main-wrapper').addClass('section--bg');
    </script>
@endpush