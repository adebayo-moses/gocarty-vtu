@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.service.store') }}" method="POST" id="serviceForm">
                    @csrf
                    <div class="card-body">
                        <h6 class="card-title">@lang('New Service Form')</h6>
                        <div class="payment-method-item pt-4">
                            <div class="payment-method-header d-flex flex-wrap">

                                <div class="content w-100 pl-0 mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="w-100">@lang('Select Category')<span class="text-danger">*</span></label>

                                                <div class="input-group">
                                                    <select name="category_id" id="category_id" class="form-control" required="">
                                                            <option value="">---@lang('Select category')---</option>
                                                        @foreach($categories as $data)
                                                            <option value="{{ $data->id }}"
                                                             data-type="{{ $data->field_type }}"
                                                             data-name="{{ str_replace('_', ' ', ucfirst($data->field_name)) }}"
                                                             >{{ __($data->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                         </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="w-100">@lang('Processing Time') <span class="text-danger">*</span></label>
                                                <input type="text" name="delay" class="form-control border-radius-5" value="{{ old('delay') }}" required="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="content w-100 pl-0 mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="w-100">@lang('Service Name')<span class="text-danger">*</span></label>

                                                <div class="input-group">
                                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                                                </div>
                                            </div>
                                         </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="w-100">@lang('Icon') <span class="text-danger">*</span></label>
                                                <div class="input-group has_append">
                                                    <input type="text" class="form-control icon" name="icon" value="{{ old('icon') }}" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="payment-method-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                         <div class="form-group">
                                            <div class="input-group">
                                                <label class="w-100">@lang('Fixed Charge') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="0" name="fixed_charge" value="{{ old('fixed_charge') }}" required="" />
                                                <div class="input-group-append">
                                                    <div class="input-group-text"> {{ __($general->cur_text) }} </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                         <div class="form-group">
                                            <div class="input-group">
                                                <label class="w-100">@lang('Percent Charge') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required="" placeholder="0" name="percent_charge" value="{{ old('percent_charge') }}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
 
                                    <div class="dynamic-form w-100">
                                            
                                        <div class="col-lg-12 selectElement">
                                            <div class="card border--dark my-2">
                                                <h5 class="card-header bg--dark selectName">  </h5>
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <div class="input-group mb-md-0 mb-4">
                                                            <select name="select[]" class="form-control select2-auto-tokenize"  multiple="multiple">

                                                           </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card border--dark my-2">

                                            <h5 class="card-header bg--dark">@lang('Service Instruction') </h5>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea rows="5" class="form-control border-radius-5 nicEdit" name="description">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card border--dark">
                                            <h5 class="card-header bg--dark">@lang('User data')
                                                <button type="button" class="btn btn-sm btn-outline-light float-right addUserData">
                                                    <i class="la la-fw la-plus"></i>@lang('Add New')
                                                </button>
                                            </h5>

                                            <div class="card-body">
                                                <div class="row addedField">

                                                    <div class="col-md-12 user-data">
                                                        <div class="form-group">
                                                            <div class="input-group mb-md-0 mb-4">
                                                                <div class="col-md-4">
                                                                    <input name="field_name[]" class="form-control" type="text" value="" required placeholder="@lang('Field Name')">
                                                                </div>
                                                                <div class="col-md-4 mt-md-0 mt-2">
                                                                    <select name="type[]" class="form-control">
                                                                        <option value="text" > @lang('Input Text') </option>
                                                                        <option value="textarea" > @lang('Textarea') </option>
                                                                        <option value="file"> @lang('File upload') </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4 mt-md-0 mt-2">
                                                                    <select name="validation[]"
                                                                            class="form-control">
                                                                        <option value="required"> @lang('Required') </option>
                                                                        <option value="nullable">  @lang('Optional') </option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block submitBtn">@lang('Save Service')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.service') }}" class="btn btn-sm btn--primary box--shadow1 text--small">
        <i class="la la-fw la-backward"></i> @lang('Go to back')
    </a>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-iconpicker.min.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush


@push('script')
    <script>
        (function($){

        "use strict";

        $('.iconPicker').iconpicker({
            align: 'center', // Only in div tag
            arrowClass: 'btn-danger',
            arrowPrevIconClass: 'fas fa-angle-left',
            arrowNextIconClass: 'fas fa-angle-right',
            cols: 10,
            footer: true,
            header: true,
            icon: 'fas fa-bomb',
            iconset: 'fontawesome5',
            labelHeader: '{0} of {1} pages',
            labelFooter: '{0} - {1} of {2} icons',
            placement: 'bottom', // Only in button tag
            rows: 5,
            search: false,
            searchText: 'Search icon',
            selectedClass: 'btn-success',
            unselectedClass: ''
        }).on('change', function (e) {
            $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
        });

        $('.selectElement').hide();
        $('.dynamic-form').hide();

        $('input[name=currency]').on('input', function () {
            $('.currency_symbol').text($(this).val());
        });

        $('.addUserData').on('click', function () {
            var html = `
                <div class="col-md-12 user-data">
                    <div class="form-group">
                        <div class="input-group mb-md-0 mb-4">
                            <div class="col-md-4">
                                <input name="field_name[]" class="form-control" type="text" value="" required placeholder="@lang('Field Name')">
                            </div>
                            <div class="col-md-3 mt-md-0 mt-2">
                                <select name="type[]" class="form-control">
                                    <option value="text" > @lang('Input Text') </option>
                                    <option value="textarea" > @lang('Textarea') </option>
                                    <option value="file"> @lang('File upload') </option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-md-0 mt-2">
                                <select name="validation[]"
                                        class="form-control">
                                    <option value="required"> @lang('Required') </option>
                                    <option value="nullable">  @lang('Optional') </option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-md-0 mt-2 text-right">
                                <span class="input-group-btn">
                                    <button class="btn btn--danger btn-lg removeBtn w-100" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;

            $('.addedField').append(html);
        });


        $(document).on('click', '.removeBtn', function () {
            $(this).closest('.user-data').remove();
        });

        var existsCategory = @json(count($categories));
        if(!existsCategory){
            $("input, select, option, textarea, .submitBtn", "#serviceForm").prop('disabled', true);
            notify('error', 'Service category not found');
        }

        $(document).on('change', '#category_id', function () {

            var field_type = $(this).children("option:selected").data('type');
            var field_name = $(this).children("option:selected").data('name');

            if(!field_type){
                $('.dynamic-form').hide();
                return;
            }

            $('.dynamic-form').show();

            if(field_type == 'select'){
                $('.selectName').text(field_name);
                $('.selectElement').show();
            }
 
        });

        })(jQuery);

    </script>
@endpush


@push('style')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice__display, .select2-container--default .select2-selection--multiple .select2-selection__choice__remove span{
        font-size: 17px !important;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type=number] {
      -moz-appearance: textfield;
    }

</style>
@endpush