@php
    $icons = getContent('social_icon.element');
    $footer = getContent('footer.content', true);
    $pages = getContent('pages.element');
@endphp


  <!-- footer start -->
  <footer class="footer bg_img" data-background="{{ getImage( 'assets/images/frontend/footer/' .@$footer->data_values->image, '1920x1080') }}">
    <div class="footer__top">
    <div class="container">
        <div class="row align-items-center mb-none-30">
        <div class="col-lg-3 mb-30 text-lg-left text-center">
            <a href="{{ route('home') }}" class="footer-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="image"></a>
        </div>
        <div class="col-lg-7 col-md-6 mb-30">
            <ul class="footer-menu d-flex flex-wrap justify-content-center">
              @foreach($pages as $page)
              <li><a href="{{ route('page', ['id'=>$page->id, 'slug'=>slug($page->data_values->name)]) }}">{{ __($page->data_values->name) }}</a></li>
              @endforeach
            </ul>
        </div>
        <div class="col-lg-2 col-md-6 mb-30">
            <ul class="social-links d-flex flex-wrap justify-content-lg-end justify-content-center">
                @foreach($icons as $icon)
                    <li>
                        <a href="{{ $icon->data_values->url }}" target="_blank">
                            @php echo $icon->data_values->social_icon; @endphp
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        </div>
    </div>
    </div><!-- footer__top end -->
    <div class="footer__bottom">
    <div class="container">
        <div class="row">
        <div class="col-lg-12 text-center">
            <p class="text-white">
                {{ __(@$footer->data_values->text) }}
            </p>
        </div>
        </div>
    </div>
    </div>
</footer>


@push('script')
<script>
  (function($){

      "use strict";

      var formEl = $("#subscribe");

      formEl.on('submit', (e)=>{
          e.preventDefault();
          var data = formEl.serialize();

          $.ajax({
          url:'{{ route('subscribe') }}',
          method:'post',
          data:data,

          success:(response)=>{
              if(response.success){
                  formEl.find("input[name=email]").val('');
                  notify('success', response.message);
              }else{
                  $.each(response.error, ( key, value )=>{
                      notify('error', value);
                  });
              }
          },
          error:(error)=>{
              console.log(error);
          }

          });
      });

  })(jQuery);
</script>
@endpush

