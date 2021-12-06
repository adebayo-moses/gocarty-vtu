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
      <form class="account-form" method="POST" action="{{ route('user.login')}}"
      onsubmit="return submitUserForm();">
      @csrf
        <div class="form-group">
            <div class="custom-icon-field">
                <i class="las la-user"></i>
                <input type="text" name="username" placeholder="@lang('Username')" class="form-control" value="{{ old('username') }}" id="username" required>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-icon-field">
                <i class="las la-key"></i>
                <input type="password" class="form-control" name="password" id="password" placeholder="@lang('Password')" required autocomplete="current-password">
            </div>
        </div>
        <div class="form-group d-flex flex-wrap justify-content-between">
            <div>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">@lang('Remember Me')</label>
            </div>
            <div>
                <a href="{{route('user.password.request')}}" class="p--color font-size--14px">@lang('Forget Password')?</a>
            </div>
        </div>
        <div class="form-group">
            @php echo loadReCaptcha() @endphp
        </div>

        <div class="mb-4">
            @include($activeTemplate.'partials.custom-captcha')
        </div>

        <div class="form-group">
          <button type="submit" class="cmn-btn py-3 w-100">@lang('LOGIN NOW')</button>
        </div>
        <p class="text-center">@lang('New to') {{ __($general->sitename) }}? <a href="{{ route('user.register') }}" class="base--color">@lang('Signup here')...</a></p>
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
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
