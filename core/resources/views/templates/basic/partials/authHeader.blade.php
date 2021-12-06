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
                <li><a href="{{ route('home') }}" class="text-white font-size--14px"><i class="las la-user-circle font-size--18px base--color"></i> @lang('Home')</a></li>
                <li><a href="{{ route('user.logout') }}" class="text-white font-size--14px"><i class="las la-user-edit font-size--18px base--color"></i> @lang('Logout')</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header__bottom">
      <div class="container">
        <nav class="navbar navbar-expand-lg p-0 align-items-center">
          <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="site-logo"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="menu-toggle"></span>
          </button>
          <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
            <ul class="navbar-nav main-menu ml-auto">

              <li> <a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>

              <li> <a href="{{ route('user.deposit') }}">@lang('Deposit')</a></li>
              
              <li> <a href="{{ route('user.services') }}">@lang('Service')</a></li>

              <li> <a href="{{ route('user.downlines') }}">@lang('Downline')</a></li>

              <li class="menu_has_children"><a href="#0">@lang('Report')</a>
                <ul class="sub-menu">
                  <li><a href="{{ route('user.history.service') }}">@lang('Service History')</a></li>
                  <li><a href="{{ route('user.trx.history') }}">@lang('Transaction History')</a></li>
                </ul>
              </li>

              <li class="menu_has_children"><a href="#0">@lang('Account')</a>
                <ul class="sub-menu">
                  <li><a href="{{ route('user.profile-setting') }}">@lang('Profile')</a></li>
                  <li><a href="{{ route('user.twofactor') }}">@lang('Two Factor')</a></li>
                  <li><a href="{{ route('user.change-password') }}">@lang('Change Password')</a></li>
                  <li><a href="{{ route('ticket.open') }}">@lang('Support')</a></li>
                  <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                </ul>
              </li>

            </ul>
          </div>
        </nav>
      </div>
    </div><!-- header__bottom end -->
  </header>
  <!-- header-section end  -->


