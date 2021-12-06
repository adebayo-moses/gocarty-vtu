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
      <form class="account-form" method="POST" action="{{ route('user.password.email') }}">
      @csrf
        <div class="form-group">
            <select name="type" class="select form-control">
                <option value="email">@lang('E-Mail Address')</option>
                <option value="username">@lang('Username')</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="@error('value') is-invalid @enderror form-control" name="value" value="{{ old('value') }}" required autofocus="off" id="value">
            @error('value')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
          <button type="submit" class="cmn-btn py-3 w-100">@lang('SEND RESET CODE')</button>
        </div>
        <p class="text-center">@lang('Have an account') {{ __($general->sitename) }}? <a href="{{ route('user.login') }}" class="base--color">@lang('Sign In here')...</a></p>
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

    (function($){

        $('select[name=type]').on('change',function(){
            myVal();
        });

   })(jQuery);

    myVal();

    function myVal(){
        $('.my_value').text($('select[name=type] :selected').text()+' *');
        $('input[name=value]').attr('placeholder', $('select[name=type] :selected').text());
    }

</script>
@endpush
