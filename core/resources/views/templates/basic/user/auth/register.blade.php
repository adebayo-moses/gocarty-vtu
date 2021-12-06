@extends($activeTemplate.'layouts.authenticate')

@section('content')

@php
    $footer = getContent('footer.content', true);
    $pages = getContent('pages.element');
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
      <form class="account-form" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
        @csrf

        @if(session()->get('reference') != null)
            <div class="form-group">
                <input type="text" id="referBy" name="referBy" id="referenceBy" value="{{session()->get('reference')}}" class="form-control" readonly>
            </div>
        @endif

        <div class="form-group">
            <div class="custom-icon-field">
            <i class="las la-user-circle"></i>
                <input type="text" id="firstname" class="form-control" placeholder="First Name" name="firstname" value="{{ old('firstname') }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-icon-field">
            <i class="las la-user-circle"></i>
                <input type="text" name="lastname" class="form-control" id="lastname" name="lastname" placeholder="Last Name" value="{{ old('lastname') }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-icon-field">
                <i class="las la-user"></i>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend input-new-group">
                    <span class="input-group-text" id="basic-addon1">
                        <select name="country_code" class="country_code">
                            @include('partials.country_code')
                        </select>
                    </span>
                </div>
                <input type="text" placeholder="@lang('Mobile')" name="mobile" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-icon-field">
            <i class="las la-globe-americas"></i>
                <input type="text" name="country" readonly class="form-control">
            </div>
        </div>        
        <div class="form-group">
            <div class="custom-icon-field">
            <i class="las la-envelope"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('Email')" required>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-icon-field">
            <i class="las la-key"></i>
                <input id="password" type="password" name="password" placeholder="@lang('Password')" class="form-control" required autocomplete="new-password">
            </div>
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
            <div class="custom-icon-field">
            <i class="las la-key"></i>
                <input id="password-confirm" type="password" placeholder="@lang('Confirm Password')" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>
        <div class="form-group">
           @php echo loadReCaptcha() @endphp
        </div>

        @include($activeTemplate.'partials.custom-captcha')

        <div class="form-group">
            <input type="checkbox" id="accept_tos" name="checkbox" value="1" required="">
            <label for="accept_tos" style="cursor: default !important;">@lang('I accept the ') 
                @foreach($pages as $page)
                    <a href="{{ route('page', ['id'=>$page->id, 'slug'=>slug($page->data_values->name)]) }}" target="_blank" class="text-dark">
                        <strong>{{ __($page->data_values->name) }}
                            @if(!$loop->last) , @endif
                        </strong>
                    </a>
                @endforeach
            </label>
        </div>

        <div class="form-group">
          <button type="submit" class="cmn-btn py-3 w-100">@lang('REGISTRATION NOW')</button>
        </div>
        <a href="{{ route('user.login') }}" class="base--color">@lang('Login here')...</a>
      </form>

      <div class="account-footer text-center">
        {{ __(@$footer->data_values->text) }}
      </div>

    </div>
  </div>
  <!-- account section end -->

@endsection

@push('style')
<style>
    .country-code .input-group-prepend .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
    .input-new-group .country_code{
        padding: 0;
        border: none;
        background: transparent;
    }
    .input-group-text {
        border: none;
    }
</style>
@endpush
@push('script')
    <script>
      "use strict";
      @if($country_code)
        $(`option[data-code={{ $country_code }}]`).attr('selected','');
      @endif
        $('select[name=country_code]').change(function(){
            $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
        }).change();
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
