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
                                <th scope="col">@lang('Field Name')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $data)
                                    <tr>
                                        <td data-label="@lang('Category')">
                                            {{ __($data->name) }}
                                        </td>
                                        <td data-label="@lang('Field Name')">
                                            @if($data->field_name)
                                                {{ str_replace('_', ' ', ucfirst($data->field_name)) }}
                                            @else 
                                                @lang('N/A')
                                            @endif
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($data->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Enable')</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--warning">@lang('Disable')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a href="javascript:void(0)" class="icon-btn eidtBtn" data-toggle="tooltip" data-original-title="@lang('Edit')"
                                            data-id='{{ $data->id }}'
                                            data-name='{{ $data->name }}'
                                            data-status='{{ $data->status }}'
                                            data-field_name='{{ str_replace("_", " ", ucfirst($data->field_name)) }}'
                                            data-field_type='{{ $data->field_type }}'
                                            >
                                                <i class="la la-pencil"></i>
                                            </a>
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
                    {{ paginateLinks($categories) }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

    <!-- ADD MODAL -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('New Service Category')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <form action="{{ route('admin.service.category.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="name">@lang('Name') *</label>
                                <input type="text" id="name" value="{{ old('name') }}" class="form-control" name="name" required>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label for="field_name">@lang('Field Name') 
                                    <br/>
                                    <strong>@lang('If you want to give select option like: Utilities bill, Operator, Send Via')</strong>
                                </label>
                                <input type="text" id="field_name" value="{{ old('field_name') }}" class="form-control" name="field_name">
                            </div>                           
                            <div class="col-lg-12 form-group mt-3">
                                <label for="status">@lang('Active status') *</label>
                                <input type="checkbox" data-width="100%" data-height="40px" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary deleteButton">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Service Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.service.category.update') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id">
                            <div class="col-lg-12 form-group">
                                <label for="name2">@lang('Name') *</label>
                                <input type="text" id="name2" value="{{ old('name') }}" class="form-control" name="name" required>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label for="field_name2">@lang('Field Name')
                                <br/>
                                    <strong>@lang('If you want to give select option like: Utilities bill, Operator, Send Via')</strong>
                                </label>
                                <input type="text" id="field_name2" value="{{ old('field_name') }}" class="form-control" name="field_name">
                            </div>
                            <div class="col-lg-12 form-group mt-3">
                                <label for="status">@lang('Active status') *</label>
                                <input type="checkbox" data-width="100%" data-height="40px" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-sm add-btn btn--primary box--shadow1 text--small" href="javascript:void(0)"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";

            $(document).on('click', '.add-btn', function () {
                var modal = $('#addModal');
                modal.modal('show');
            });

            $(document).on('click','.eidtBtn',function () {
                var modal = $('#editModal');
                var status = $(this).data('status');

                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('select[name=field_type]').val($(this).data('field_type'));
                modal.find('input[name=field_name]').val($(this).data('field_name'));

                if (status == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
