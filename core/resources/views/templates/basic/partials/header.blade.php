@php
    $info = getContent('heading_info.content', true);
@endphp

<!-- header-section start  -->
<header class="header">
    <div class="header__top base--bg-two">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <ul class="header-contact-info-list d-flex flex-wrap justify-content-md-start justify-content-center">
              <li><i class="las la-mobile base--color font-size--18px"></i> <a href="tel:545454" class="font-size--14px text-white">{{ @$info->data_values->phone }}</a></li>
              <li><i class="las la-envelope base--color font-size--18px"></i> <a href="mailto:ami@gmail.com" class="font-size--14px text-white">{{ @$info->data_values->email }}</a></li>
            </ul>
          </div>
          <div class="col-md-6 mt-md-0 mt-2">
            <div class="d-flex align-items-center justify-content-md-end justify-content-center header-select-area">
              <select class="select style--two d-inline-block w-auto style--white mr-3 langSel">

                @foreach($language as $item)
                    <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>
                        {{ __($item->name) }}
                    </option>
                @endforeach

              </select>
              <ul class="d-flex flex-wrap header-account-list">
                @auth()
                 <li>
                    <a href="{{ route('user.home') }}" class="text-white font-size--14px">
                      <i class="las la-user-circle font-size--18px base--color"></i> 
                      @lang('Dashboard')
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('user.logout') }}" class="text-white font-size--14px"><i class="las la-user-edit font-size--18px base--color"></i> 
                      @lang('Logout')
                    </a>
                  </li>
                @else 
                  <li>
                    <a href="{{ route('user.login') }}" class="text-white font-size--14px">
                      <i class="las la-user-circle font-size--18px base--color"></i> 
                      @lang('Login')
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('user.register') }}" class="text-white font-size--14px"><i class="las la-user-edit font-size--18px base--color"></i> 
                      @lang('Registration')
                    </a>
                  </li>
                @endauth
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header__bottom">
      <div class="container">
        <nav class="navbar navbar-expand-lg p-0 align-items-center" id="linkItem">
          <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="site-logo"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="menu-toggle"></span>
          </button>
          <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
            <ul class="navbar-nav main-menu ml-auto">
              <li> <a href="{{ route('home') }}">@lang('Home')</a></li>
              <li> <a href="#service">@lang('Service')</a></li>
              <li> <a href="#feature">@lang('Feature')</a></li>
              <li> <a href="#app">@lang('App')</a></li>
              <li> <a href="#payment">@lang('Payment')</a></li>
              <li> <a href="#partner">@lang('Partner')</a></li>

              @foreach($pages as $k => $data)
                  <li>
                    <a href="{{route('pages',[$data->slug])}}">
                      {{trans($data->name)}}
                    </a>
                  </li>
              @endforeach

              <li> <a href="{{ route('contact') }}">@lang('Contact')</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </div><!-- header__bottom end -->
  </header>
  <!-- header-section end  -->


