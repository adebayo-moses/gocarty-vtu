@extends($activeTemplate.'layouts.master')
@section('content')



<section class="pt-100 pb-100 section--bg">
  <div class="container">

        <!--  Profile Edit Section  -->
        <div class="profile-section py-5">
            <div class="profile-area section-bg card overflow-visible p-4">
            <form class="user-profile-form" action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="user-profile text-center">
                            <div class="profile-thumb-wrapper text-center mb-4">
                                <div class="profile-thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview" style="background-image: url( '{{ getImage(imagePath()['profile']['user']['path'].'/'. @$user->image,imagePath()['profile']['user']['size']) }}' )"></div>
                                </div>
                                <div class="avatar-edit">
                                    <input type='file' class="profilePicUpload" id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"><i class="la la-pencil"></i></label>
                                </div>
                                </div>
                            </div>
                            <h5 class="title">{{ __($user->fullname) }}</h5>
                            <span>@lang('Username'): {{ __($user->username) }}</span>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4">
                    <h5 class="title mb-2">@lang('Edit Profile')</h5>
                        <div class="row">   
                            @csrf
                            <div class="col-md-6 mb-3">
                                <label for="InputFirstname" class="col-form-label">@lang('First Name'):</label>
                                <input type="text" class="form-control" id="InputFirstname" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="col-form-label">@lang('Last Name'):</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="hidden" id="track" name="country_code">
                                    <label for="phone" class="col-form-label">@lang('Mobile Number')</label>
                                    <input type="tel" class="form-control" id="phone" name="mobile" value="{{$user->mobile}}" placeholder="@lang('Your Contact Number')" readonly>
                                    <input type="hidden" name="country" id="country" class="form-control d-none" value="{{@$user->address->country}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state" class="col-form-label">@lang('State'):</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}" required="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip" class="col-form-label">@lang('Zip Code'):</label>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city" class="col-form-label">@lang('City'):</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="col-form-label">@lang('Address'):</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required="">
                            </div>
                            <div class="col-lg-12 mb-3 ml-auto text-right mt-4">
                                <button type="submit" class="w-100 cmn-btn">@lang('Update Profile')</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!--  Profile Edit Section  -->

    </div>
</section>
@endsection

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue.'css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endpush
@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/build/css/intlTelInput.css')}}">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100% !important;
        }
        
        .profile-thumb {
            position: relative;
            width: 11.25rem;
            height: 11.25rem;
            border-radius: 15px;
            -webkit-border-radius: 15px;
            -moz-border-radius: 15px;
            -ms-border-radius: 15px;
            -o-border-radius: 15px;
            display: inline-flex;
        }
        .profile-thumb .profilePicPreview {
            width: 11.25rem;
            height: 11.25rem;
            border-radius: 15px;
            -webkit-border-radius: 15px;
            -moz-border-radius: 15px;
            -ms-border-radius: 15px;
            -o-border-radius: 15px;
            display: block;
            border: 3px solid #ffffff;
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.25);
            background-size: cover;
            background-position: center;
        }
        .profile-thumb .profilePicUpload {
            font-size: 0;
            opacity: 0;
        }
        .profile-thumb .avatar-edit {
            position: absolute;
            right: -15px;
            bottom: -20px;
        }
        .profile-thumb .avatar-edit input {
            width: 0;
        }
        .profile-thumb .avatar-edit label {
            width: 45px;
            height: 45px;
            background-color: #37ebec;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
            border: 2px solid #ffffff;
            font-size: 18px;
            cursor: pointer;
            color: #000000;
        }
    </style>
@endpush

@push('script')
<script>

    (function($){

        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents('.profile-thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
            }
            $(".profilePicUpload").on('change', function() {
            proPicURL(this);
            });

            $(".remove-image").on('click', function(){
            $(".profilePicPreview").css('background-image', 'none');
            $(".profilePicPreview").removeClass('has-image');
            })

    })(jQuery);

</script>
@endpush