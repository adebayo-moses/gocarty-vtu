@extends($activeTemplate.'layouts.master')
@section('content')

    <!-- dashboard start -->
    <section class="pt-120 pb-120 section--bg">
      <div class="container">

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">@lang('My Downline')</h6>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive--md">
                  <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Name')</th>
                            <th scope="col">@lang('Email')</th>
                            <th scope="col">@lang('Mobile')</th>
                            <th scope="col">@lang('Join At')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($downlines as $data)    
                      <tr>
                        <tr>
                            <td data-label="@lang('Name')">
                                <b>{{ __($data->fullname) }}</b>
                            </td>
                            <td data-label="@lang('Email')">
                                {{ __($data->email) }}
                            </td>
                            <td data-label="@lang('Mobile')">
                                {{ __($data->mobile) }}
                            </td>
                            <td data-label="@lang('Join At')">
                                {{ showDateTime($data->created_at) }}
                            </td>
                        </tr>
                      </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">@lang('Data Not Found')!</td>
                        </tr>
                    @endforelse 
                    </tbody>
                  </table>

                    {{ $downlines->links() }}

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