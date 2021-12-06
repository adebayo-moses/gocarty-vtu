@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Category')</th>
                                <th scope="col">@lang('Service')</th>
                                <th scope="col">@lang('Processig Time')</th>
                                <th scope="col">@lang('Fixed Charge')</th>
                                <th scope="col">@lang('Parcent Charge')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $index => $data)
                                    <tr>
                                        <td data-label="@lang('Category')">
                                            {{ __(@$data->category->name) }}
                                        </td>
                                        <td data-label="@lang('Service')">
                                            {{ __(@$data->name) }}
                                        </td>
                                        <td data-label="@lang('Processig Time')">
                                            {{ __(@$data->delay) }}
                                        </td>
                                        <td data-label="@lang('Fixed Charge')">
                                            {{ getAmount($data->fixed_charge) }}
                                            {{ __($general->cur_text) }}
                                        </td>
                                        <td data-label="@lang('Parcent Charge')">
                                            {{ getAmount($data->percent_charge) }} @lang('%')
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($data->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Enable')</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--warning">@lang('Disable')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.service.update.page', $data->id) }}" class="icon-btn eidtBtn" data-toggle="tooltip" data-original-title="@lang('Edit')">
                                                <i class="la la-pencil"></i>
                                            </a>

                                            @if($data->status == 1)
                                                <a href="javascript:void(0)" class="icon-btn btn--danger deactivateBtn  ml-1" data-toggle="tooltip" data-original-title="@lang('Disable')" data-id="{{ $data->id }}" data-name="{{ __($data->category->name) }}">
                                                    <i class="la la-eye-slash"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="icon-btn btn--success activateBtn  ml-1"
                                                   data-toggle="tooltip" data-original-title="@lang('Enable')"
                                                   data-id="{{ $data->id }}" data-name="{{ __($data->category->name) }}">
                                                    <i class="la la-eye"></i>
                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }} !</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($services) }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation')!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.service.status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span class="font-weight-bold method-name"></span> @lang('service')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Enable')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation')!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.service.status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span class="font-weight-bold method-name"></span> @lang('service')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Disable')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text--small" href="{{ route('admin.service.page') }}"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush


@push('script')
    <script>
        (function($){

            "use strict";

            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush