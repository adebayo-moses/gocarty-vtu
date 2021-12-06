@extends($activeTemplate.'layouts.master')

@section('content')

    <section class="pt-100 pb-100 section--bg">
        <div class="container">
          <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    <div class="card main-card border-top-0">
                        <div class="card-body">

                            <form action="" method="post" class="register">
                                @csrf
                                <div class="form-group">
                                    <label for="password">@lang('Current Password')</label>
                                    <div class="custom-icon-field">
                                        <i class="las la-key"></i>
                                        <input id="password" type="password" placeholder="Current Password" class="form-control" name="current_password" required autocomplete="current-password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">@lang('Password')</label>
                                    <div class="custom-icon-field">
                                        <i class="las la-lock"></i>
                                        <input id="confirm_password" type="password" placeholder="New Password" class="form-control" name="password" required autocomplete="current-password">
                                    </div>
                                    @if($general->secure_password)
                                    <div class="progress mt-2">
                                      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-danger my-1 capital">@lang('Minimum 1 capital letter is required')</p>
                                    <p class="text-danger my-1 number">@lang('Minimum 1 number is required')</p>
                                    <p class="text-danger my-1 special">@lang('Minimum 1 special character is required')</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">@lang('Confirm Password')</label>
                                    <div class="custom-icon-field">
                                        <i class="las la-lock"></i>
                                        <input id="password_confirmation" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="current-password">
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" class="mt-3 btn bg-primary w-100 cmn-btn text-white" value="@lang('Change Password')">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    "use strict";
    @if($general->secure_password)
        $('input[name=password]').on('input',function(){
            var password = $(this).val();
            var width = 25;
            var capital = /[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/;
            var capital = capital.test(password);
            if (!capital){
                $('.capital').removeClass('d-none');
            }else{
                width += 25;
                $('.capital').addClass('d-none');
            }
            var number = /[123456790]/;
            var number = number.test(password);
            if (!number){
                $('.number').removeClass('d-none');
            }else{
                width += 25;
                $('.number').addClass('d-none');
            }
            var special = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
            var special = special.test(password);
            if (!special){
                $('.special').removeClass('d-none');
            }else{
                width += 25;
                $('.special').addClass('d-none');
            }

            if (width == 25) {
                var bg = 'red';
                var msg = 'Too Week'
            }else if(width == 50){
                var msg = 'Week'
                var bg = '#D7A612';
            }else if(width == 75){
                var msg = 'Medium'
                var bg = '#5210BF';
            }else if(width == 100){
                var msg = 'Strong'
                var bg = 'green';
            }
            $('.progress-bar').attr('style',`width:${width}%;background:${bg};`);
            $('.progress-bar').text(msg);
        });
    @endif
</script>
@endpush
