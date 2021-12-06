@php
	$captcha = getCustomCaptcha();
@endphp

@if($captcha)

    <div class="account_form_group text-white captcha form-group">
        @php echo $captcha @endphp
    </div>

    <div class="account_form_group form-group">
        <input type="text" name="captcha" class="form-control" placeholder="@lang('Enter Code')">
    </div>

@endif

@push('style')
<style>
    .captcha div{
        width: 100% !important;
    }
    .captcha span {
        color: #fff !important;
    }
</style>
@endpush
