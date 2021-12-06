@extends($activeTemplate.'layouts.master')
@section('content')


<section class="pt-100 pb-100 section--bg">
  <div class="container">

        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 pr-lg-5">
                        @if(Auth::user()->ts)
                            <h5 class="title cl-white mb-2">@lang('Two Factor Authenticator')</h5>
                            <div class="form-group mx-auto text-center m-0">
                                <a href="#0"  class="cmn-btn" data-toggle="modal" data-target="#disableModal">
                                    @lang('Disable Two Factor Authenticator')</a>
                            </div>
                        @else
                            <h5 class="title cl-white mb-2">@lang('Two Factor Authenticator')</h5>
                            <div class="form-group mx-auto text-center">
                                <img class="mx-auto" src="{{$qrCodeUrl}}">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="key" value="{{$secret}}" class="form-control form-control-lg outline-0 shadow-none" id="code" readonly>
                                    <div class="input-group-append" style="cursor: pointer;">
                                        <span class="input-group-text copytext bg-primary text-white" id="copyBoard" onclick="copyFunction()"> <i class="las la-copy"></i> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mx-auto text-center m-0">
                                <a href="#0" class="cmn-btn w-100" data-toggle="modal" data-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 mt-lg-0 mt-4">
                        <div class="card main-card border-top-0">
                            <div class="card-header border-0">
                                <h5 class="title cl-white m-0">@lang('Google Authenticator')</h5>
                            </div>
                            <div class=" card-body">
                                <p class="mb-3">@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                                <a class="cmn-btn w-100 text-center" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" class="" target="_blank">@lang('DOWNLOAD APP')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

    <!--Enable Modal -->
    <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <strong class="modal-title">@lang('Verify Your Otp')</strong>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn bg-primary text-white">@lang('Verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <strong class="modal-title">@lang('Verify Your Otp Disable')</strong>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn bg-primary text-white">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        "use strict";

        function copyFunction() {
            var copyText = document.getElementById("code");
            copyText.select();
            copyText.setSelectionRange(0, 99999);

            document.execCommand("copy");
            notify('success', "Copied: " + copyText.value);
        }

    </script>
@endpush


