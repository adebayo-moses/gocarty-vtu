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
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Category')</th>
                                <th scope="col">@lang('Service')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Charge')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $index => $data)
                                    <tr>
                                        <td data-label="@lang('Date')">
                                            {{ showDateTime(@$data->created_at) }}
                                        </td>
                                        <td data-label="@lang('Category')">
                                            {{ __(@$data->service->category->name) }}           
                                        </td>
                                        <td data-label="@lang('Service')">
                                            <a href="{{ route('admin.service.update.page', $data->service_id) }}">
                                                {{ __(@$data->service->name) }}           
                                            </a>
                                        </td>
                                        <td data-label="@lang('Username')">
                                        	<a href="{{ route('admin.users.detail', $data->user_id) }}">
                                        		{{ __(@$data->user->username) }}
                                        	</a>
                                        </td>
                                        <td data-label="@lang('Amount')">
                                            {{ getAmount($data->amount) }}
                                            {{ __($general->cur_text) }}
                                        </td>
                                        <td data-label="@lang('Charge')">
                                            {{ getAmount($data->total_charge) }}
                                            {{ __($general->cur_text) }}
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($data->status == 2)
                                                <span class="badge badge--warning">@lang('Pending')</span>
                                            @elseif($data->status == 1)
                                                <span class="badge badge--success">@lang('Approved')</span>
                                            @else 
                                                <span class="badge badge--danger">@lang('Rejected')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">

                                        <a href="{{ route('admin.applied.details', $data->id) }}" class="icon-btn btn--primary activateBtn  ml-1"
                                           data-toggle="tooltip" data-original-title="@lang('Details')"
                                           data-id="{{ $data->id }}" data-name="{{ __($data->id) }}">
                                            <i class="la la-eye"></i>
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
                    {{ paginateLinks($services) }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

@endsection

