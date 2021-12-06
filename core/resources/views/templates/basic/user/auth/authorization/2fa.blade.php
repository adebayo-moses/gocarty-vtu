@extends($activeTemplate .'layouts.authenticate')
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
      <form class="account-form" method="POST" action="{{route('user.go2fa.verify')}}">
      @csrf

        <h4 class="text-center">@lang('Google Authenticator Code')</h4>
        <h4 class="text-center">@lang('Current Time'): {{\Carbon\Carbon::now()}}</h4>

        <div class="form-group mt-4">
            <div id="phoneInput">
                <div class="field-wrapper">
                    <div class=" phone">
                        <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                        <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                        <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                        <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                        <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                        <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
          <button type="submit" class="cmn-btn py-3 w-100">@lang('SUBMIT')</button>
        </div>

      </form>

      <div class="account-footer text-center">
        {{ __(@$footer->data_values->text) }}
      </div>

    </div>
</div>
  <!-- account section end -->

@endsection
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/jquery.inputLettering.js') }}"></script>
@endpush
@push('style')
    <style>
        #phoneInput .field-wrapper {
            position: relative;
            text-align: center;
        }
        #phoneInput .form-group {
            min-width: 300px;
            width: 50%;
            margin: 4em auto;
            display: flex;
            border: 1px solid rgba(96, 100, 104, 0.3);
        }
        #phoneInput .letter {
            height: 50px;
            border-radius: 0;
            text-align: center;
            max-width: calc((100% / 7) - 1px);
            flex-grow: 1;
            flex-shrink: 1;
            flex-basis: calc(100% / 10);
            outline-style: none;
            padding: 5px 0;
            font-size: 18px;
            font-weight: bold;
            color: red;
            border: 1px solid #0e0d35;
        }
        #phoneInput .letter + .letter {
        }
        @media (max-width: 480px) {
            #phoneInput .field-wrapper {
                width: 100%;
            }
            #phoneInput .letter {
                font-size: 16px;
                padding: 2px 0;
                height: 35px;
            }
        }

    </style>
@endpush

@push('script')
    <script>
        (function($){

            "use strict";
            $('#phoneInput').letteringInput({
                inputClass: 'letter',
                onLetterKeyup: function ($item, event) {
                    console.log('$item:', $item);
                    console.log('event:', event);
                },
                onSet: function ($el, event, value) {
                    console.log('element:', $el);
                    console.log('event:', event);
                    console.log('value:', value);
                }
            });
       })(jQuery);
    </script>
@endpush
