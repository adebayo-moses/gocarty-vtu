@extends($activeTemplate.'layouts.frontend')

@php
    $contact = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element');
@endphp

@section('content')

 <!-- contact section start -->
 <section class="pt-120 pb-120">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <h2 class="contact-title">{{ __(@$contact->data_values->heading) }}</h2>
        </div>
      </div>
      <div class="row mt-5 mb-none-30 justify-content-center">
        <div class="col-lg-4 col-md-6 mb-30">
          <div class="contact-card">
            <div class="contact-card__header d-flex flex-wrap">
              <i class="las la-map-marked-alt"></i>
              <h4 class="title">@lang('Location')</h4>
            </div>
            <div class="contact-card__content">
              <p>{{ __(@$contact->data_values->location) }}</p>
            </div>
          </div><!-- contact-card end -->
        </div>
        <div class="col-lg-4 col-md-6 mb-30">
          <div class="contact-card">
            <div class="contact-card__header d-flex flex-wrap">
              <i class="las la-address-card"></i>
              <h4 class="title">@lang('Email')</h4>
            </div>
            <div class="contact-card__content">
              <p><a href="mailto:{{ __(@$contact->data_values->email) }}">{{ __(@$contact->data_values->email) }}</a></p>
            </div>
          </div><!-- contact-card end -->
        </div>
        <div class="col-lg-4 col-md-6 mb-30">
          <div class="contact-card">
            <div class="contact-card__header d-flex flex-wrap">
              <i class="las la-globe"></i>
              <h4 class="title">@lang('Follow Us')</h4>
            </div>
            <div class="contact-card__content">
              <ul class="social-links style--two d-flex flex-wrap">
                @foreach($socialIcons as $singleIcon)
                    <li>
                        <a href="{{ $singleIcon->data_values->url }}" target="_blank">
                            @php echo $singleIcon->data_values->social_icon; @endphp
                        </a>
                    </li>
                @endforeach
              </ul>
            </div>
          </div><!-- contact-card end -->
        </div>  
      </div>
      <div class="row mt-5">
        <div class="col-lg-12">
          <div class="contact-wrapper">
            <h2 class="title mb-4">@lang('Do you have questions')?</h2>
            <form action="" method="post">
                @csrf
              <div class="row">
                <div class="form-group col-lg-6">
                    <label for="name">@lang('Name') *</label>
                    <input name="name" type="text" placeholder="@lang('Your Name')" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="email">@lang('Email') *</label>
                    <input name="email" type="text" placeholder="@lang('Enter E-Mail Address')" class="form-control" value="{{old('email')}}" required>
                </div>
                <div class="form-group col-lg-12">
                    <label for="phone">@lang('Subject') *</label>
                    <input name="subject" type="text" placeholder="@lang('Write your subject')" class="form-control" value="{{old('subject')}}" required>
                </div>
                <div class="form-group col-lg-12">
                    <label for="message">@lang('Message') *</label>
                    <textarea name="message" wrap="off" placeholder="@lang('Write your message')" class="form-control" required="">{{old('message')}}</textarea>
                </div>
                <div class="col-lg-12">
                  <button type="submit" class="cmn-btn">@lang('Contact Now')</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- contact section end -->

@endsection
