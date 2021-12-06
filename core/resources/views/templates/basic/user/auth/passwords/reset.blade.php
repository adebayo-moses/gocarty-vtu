@extends($activeTemplate.'layouts.authenticate')
@section('content')

@php
    $footer = getContent('footer.content', true);
    $bg = getContent('auth_image.content', true);
@endphp

 <!-- account section start -->
 <div class="account-area">
    <div class="account-area-bg bg_img" data-background="{{ getImage( 'assets/images/frontend/auth_image/' .@$bg->data_values->image, '1920x1080') }}"></div>
    <div class="account-wrapper">
      <div class="account-logo text-center">
        <a href="{{ route('home') }}">
            <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="image">
        </a>
      </div>
      <form class="account-form" method="POST" action="{{ route('user.password.update') }}">
      @csrf

        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <input id="password" type="password" class="@error('password') is-invalid @enderror form-control" name="password" required autocomplete="new-password" placeholder="@lang('New Password')">
            @if($general->secure_password)
                <div class="progress mt-3">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <p class="text-dark my-1 capital">@lang('Minimum 1 capital letter is required')</p>
                <p class="text-dark my-1 number">@lang('Minimum 1 number is required')</p>
                <p class="text-dark my-1 special">@lang('Minimum 1 special character is required')</p>
            @endif
        </div>
        <div class="form-group">
            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control" placeholder="@lang('Confirm Password')">
        </div>

        <div class="form-group">
          <button type="submit" class="cmn-btn py-3 w-100">@lang('RESET PASSWORD')</button>
        </div>
        <p class="text-center">@lang('Have an account') {{ __($general->sitename) }}? <a href="{{ route('user.login') }}" class="base--color">@lang('Sign In')...</a></p>
      </form>
      <div class="account-footer text-center">
        {{ __(@$footer->data_values->text) }}
      </div>
    </div>
</div>
  <!-- account section end -->

@endsection
@push('script')
<script>
    (function($){

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

    })(jQuery);
    @endif
</script>
@endpush
