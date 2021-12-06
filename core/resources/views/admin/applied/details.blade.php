@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30"> 
        <div class="col-xl-4 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <div class="p-3 bg--white">

                    </div>

                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Date')
                            <span class="font-weight-bold">{{ showDateTime(@$service->created_at) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold">
                                <a href="{{ route('admin.users.detail', $service->user_id) }}">
                                    {{ __(@$service->user->fullname) }}
                                </a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Category')
                            <span class="font-weight-bold">
                                {{ __(@$service->service->category->name) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Service')
                            <span class="font-weight-bold">
                                <a href="{{ route('admin.service.update.page', $service->service_id) }}">
                                    {{ __(@$service->service->name) }}
                                </a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Amount')
                            <span class="font-weight-bold">
                                {{ getAmount($service->amount) }}
                                {{ __($general->cur_text) }}
                            </span>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Total Charge')
                            <span class="font-weight-bold">
                                {{ getAmount($service->total_charge) }}
                                {{ __($general->cur_text) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('After Charge')
                            <span class="font-weight-bold">
                                {{ getAmount($service->after_charge) }}
                                {{ __($general->cur_text) }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @if($service->status == 2)
                                <span class="badge badge-pill bg--warning">@lang('Pending')</span>
                            @elseif($service->status == 1)
                                <span class="badge badge-pill bg--success">@lang('Approved')</span>
                            @elseif($service->status == 3)
                                <span class="badge badge-pill bg--danger">@lang('Rejected')</span>
                            @endif
                        </li>
                    </ul>

                    @if($service->admin_feedback)
                        <div class="mt-4">
                            <span class="d-block font-weight-bold">@lang('Admin Feedback')</span>
                            <span >{{ __($service->admin_feedback) }}</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">
                    {{ __(@$service->service->category->name) }}
                    @lang('Information')
                    </h5>

                    @if($service->select_field)
                        @php
                            $select = (array) json_decode($service->select_field);
                            $serviceType = key($select);
                            $serviceValue = array_values($select);
                            $serviceValue = implode(' ', $serviceValue);
                        @endphp
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <p>{{ ucfirst($serviceType) }}</p>
                                <h6>{{ $serviceValue }}</h6>
                            </div>
                        </div>
                    @endif

                    @php
                        $data = $service->user_data;
                        $array = json_decode($data, true);
                    @endphp

                    @foreach($array as $index => $value)

                        @if($array[$index]['type'] == 'file')
                           <div class="row mt-4">
                                <div class="col-md-8">
                                    <h6>{{ __(str_replace('_', ' ', ucfirst($array[$index]['field_name']))) }}</h6>
                                    <img src="{{ getImage(imagePath()['service']['path'] .'/'.$value['field_value']) }}" alt="@lang('Image')" class="mt-1">
                                </div>
                            </div>
                        @else
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <p>{{ __(str_replace('_', ' ', ucfirst($array[$index]['field_name']))) }}</p>
                                    <h6>{{ __($value['field_value']) }}</h6>
                                </div>
                            </div>
                        @endif

                    @endforeach

                    @if($service->status == 2)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button class="btn btn--success ml-1 approveBtn"
                                        data-id="{{ $service->id }}"
                                        data-name="{{ $service->service->category->name }}"
                                        data-toggle="tooltip" data-original-title="@lang('Approve')"><i class="fas fa-check"></i>
                                    @lang('Approve')
                                </button>

                                <button class="btn btn--danger ml-1 cancelBtn"
                                        data-id="{{ $service->id }}"
                                        data-name="{{ $service->service->category->name }}"
                                        data-toggle="tooltip" data-original-title="@lang('Reject')"><i class="fas fa-ban"></i>
                                    @lang('Reject')
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation')!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.applied.approve')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span class="font-weight-bold">@lang('approve')</span> <span class="font-weight-bold withdraw-amount text-success"></span> @lang('the service of') <span class="font-weight-bold withdraw-user"></span>?</p>

                        <div class="form-group">
                            <label class="font-weight-bold mt-2">@lang('Details')</label>
                            <textarea name="message" placeholder="@lang('Details')" class="form-control" rows="5"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Approve')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CANCEL MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation')!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.applied.reject')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span class="font-weight-bold">@lang('cancel')</span> <span class="font-weight-bold withdraw-amount text-success"></span> @lang('the service of') <span class="font-weight-bold withdraw-user"></span>?</p>

                        <div class="form-group">
                            <label class="font-weight-bold mt-2">@lang('Reason for cancellation')</label>
                            <textarea name="message" id="message" placeholder="@lang('Reason for Cancellation')" class="form-control" rows="5"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Reject')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>

    (function($){

        "use strict";

        $('.approveBtn').on('click', function () {
            var modal = $('#approveModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-user').text($(this).data('name'));
            modal.modal('show');
        });

        $('.cancelBtn').on('click', function () {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-user').text($(this).data('name'));
            modal.modal('show');
        });

    })(jQuery);

    </script>
@endpush
