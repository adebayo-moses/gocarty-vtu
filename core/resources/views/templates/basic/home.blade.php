@extends($activeTemplate.'layouts.frontend')

@section('content')

@if($services->count() > 0)
    <!-- recharge form section start -->
    <div class="recharge-form-section main-form pb-100 bg_img" data-background="{{ $activeTemplateTrue .'images/bg/shape.svg' }}">
        <div class="container">
        <div class="recharge-bill-area bg_img" data-background="{{ $activeTemplateTrue .'images/bg/bg-2.jpg' }}">
            <div class="row">
            <div class="col-md-12">
                <div class="bill-items-wrapper d-flex flex-wrap justify-content-center">
                <ul class="bill-items nav nav-tabs" id="teleporter">

                @foreach($services as $service)
                    <li class="nav-item {{ $loop->first ? 'active' : null }}">
                        <a href="javascript:void(0)" class="nav-link singleService" data-service="{{ $service }}">
                            @php echo $service->icon; @endphp
                            <span>{{ __($service->name) }}</span>
                        </a>
                    </li>
                @endforeach

                </ul>
                <ul class="morebtn">
                    <li>
                        <a href="javascript:void(0)" class="nav-link mbtn" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                            <span>@lang('More')</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" id="receiver"></ul>
                    </li>
                </ul>
                </div>
            </div>
            </div><!-- row end -->
            <div class="bill-form-wrapper mt-4">
            <form action="{{route('user.service.apply')}}" method="post" class="landingPage">
                @csrf
                <h6 class="mb-2"><span class="serviceCat"></span> <span class="serviceTitle"></span></h6>
                <div class="form-row align-items-center">

                <div class="col-lg-5 col-md-5 form-group">
                    <p class="serviceDes font-size--14px"></p>
                </div>

                <div class="col-lg-5 col-md-5 form-group">
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text font-size--18px bg-primary text-white">
                            {{ $general->cur_sym }}
                        </span>
                    </div>

                    <input type="hidden" name="id" required="">

                    <input type="text" name="amount" class="form-control" placeholder="@lang('Amount')" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" required="">
                    </div>
                </div>
                <div class="col-lg-2 form-group">
                    <button type="submit" class="cmn-btn w-100">@lang('Continue')</button>
                </div>


                </div>

            </form>
            </div><!-- bill-form-wrapper end -->
        </div>
        </div>
    </div>
    <!-- recharge form section end -->
@endif

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif

@endsection


@if($services->count() > 0)

    @push('script')
    <script>
        (function ($) {

            "use strict";

            let service = @json($services->first());
            let fixed = parseFloat(service.fixed_charge).toFixed(1);
            let percent = parseFloat(service.percent_charge).toFixed(1);

            $('.landingPage input[name=id]').val(service.id);

            let details = `<span class='font-weight-bold'>@lang('Fixed Charge')</span> ${fixed} {{ __($general->cur_text)}},  
                           <span class='font-weight-bold'>@lang('Parcent Charge')</span> ${percent} % <br/>
                           <span class='font-weight-bold'>@lang('Processing Time')</span> ${service.delay} 
                            `;

            $('.serviceCat').text(service.category.name);
            $('.serviceTitle').text(`(${service.name})`);
            $('.serviceDes').html(details);


            let more = $('#receiver li').length;
            let element = $('<li>');

            if(more == 0){
                $('#receiver').append(`@lang('No More')`);
            }

            $('.nav-item .singleService').on('click', function(){

                let service = $(this).data('service');
                let fixed = parseFloat(service.fixed_charge).toFixed(1);
                let percent = parseFloat(service.percent_charge).toFixed(1);

                $('.landingPage input[name=id]').val(service.id);

                let details = `<span class='font-weight-bold'>@lang('Fixed Charge')</span> ${fixed} {{ __($general->cur_text)}},  
                               <span class='font-weight-bold'>@lang('Parcent Charge')</span> ${percent} % <br/>
                               <span class='font-weight-bold'>@lang('Processing Time')</span> ${service.delay} 
                                `;

                $('.serviceCat').text(service.category.name);
                $('.serviceTitle').text(`(${service.name})`);
                $('.serviceDes').html(details);

            });

            $('.bill-items-wrapper .bill-items > .nav-item > .nav-link').on("click", function() {
                const element = $(this).parent("li");
                if (element.hasClass("active")) {
                    element.removeClass("active");
                    element.find("li").removeClass("active");
                }
                else {
                    element.addClass("active");
                    element.siblings("li").removeClass("active");
                    element.siblings("li").find("li").removeClass("active");
                }

                const dpElement = $('.bill-items-wrapper ul.morebtn li .dropdown-menu .nav-item');
                if(dpElement.hasClass('active')){
                    dpElement.removeClass("active");
                    $('.mbtn').removeClass('active');
                }
            });

            $('.bill-items-wrapper ul.morebtn li .dropdown-menu .nav-item .nav-link').on("click", function() {
                const element = $(this).parent("li");
                if (element.hasClass("active")) {
                    element.removeClass("active");
                    element.find("li").removeClass("active");
                }
                else {
                    element.addClass("active");
                    element.siblings("li").removeClass("active");
                    element.siblings("li").find("li").removeClass("active");
                }

                const billElement = $('.bill-items-wrapper .bill-items > .nav-item');
                if(billElement.hasClass('active')){
                    billElement.removeClass("active");
                    $('.mbtn').addClass('active');
                }
            });

        })(jQuery);
    </script>

    @endpush

@endif