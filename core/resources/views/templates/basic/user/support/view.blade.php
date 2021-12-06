@extends($activeTemplate.'layouts.master')
@section('content')

<section class="pt-100 pb-120 section--bg">
  <div class="container">

        <!--  Ticket Chat Section  -->
        <div class="ticket-chat-section pr-2 pl-2">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="ticket-wrapper card p-4">
                        <div class="button-contain-header d-flex flex-wrap align-items-center justify-content-between">
                            <div class="d-flex align-items-center m-2">
                                @if($my_ticket->status == 0)
                                    <span class="badge badge-success style--light py-2 px-3">@lang('Open')</span>
                                @elseif($my_ticket->status == 1)
                                    <span class="badge badge-primary style--light py-2 px-3">@lang('Answered')</span>
                                @elseif($my_ticket->status == 2)
                                    <span class="badge badge-info style--light py-2 px-3">@lang('Replied')</span>
                                @elseif($my_ticket->status == 3)
                                    <span class="badge badge-dark style--light py-2 px-3">@lang('Closed')</span>
                              @endif
                                &nbsp;<span>[@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}</span>
                            </div>
                            <div>
                                <button class="add-more m-1 bg-primary icon-btn" title="List">
                                    <a href="{{ route('ticket') }}">
                                        <i class="lar la-hand-point-left" style="font-size: 20px; color:white;"></i>
                                    </a>
                                </button>
                                @if($my_ticket->status != 3)
                                <button class="add-more m-1 bg-danger icon-btn" type="button" title="Close Ticket" data-toggle="modal" data-target="#DelModal"><i class="las la-times"></i></button>
                                @endif
                            </div>
                        </div>
                        <form class="ticket_form mb--20 row" method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 form-group">
                                <label for="message" class="inputMessage">@lang('Your Message')</label>
                                 <textarea name="message" class="form-control" id="inputMessage" rows="4" cols="10"></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="d-flex">
                                    <div class="left-group col p-0">
                                        <label for="file" class="inputAttachments w-100 mb-0">@lang('Attachments')</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" name="attachments[]" id="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label mb-0" for="inputGroupFile01">@lang('Choose file')</label>
                                            </div>
                                        </div>
                                        <div id="fileUploadsContainer"></div>
                                        <span class="info font-size--14px">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </span>
                                    </div>
                                    <div class="add-area">
                                        <label class="label_one d-block">&nbsp;</label>
                                        <button class="add-more text-white bg-primary icon-btn ml-2 ml-md-4" onclick="extraTicketAttachment()" type="button"><i class="las la-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" class="cmn-btn text-white bg-primary" name="replayTicket" value="1">@lang('Reply')</button>
                            </div>
                        </form>
                        <ul class="reply-message-area mt-4">
                            <li>

                                @foreach($messages as $message)
                                    @if($message->admin_id == 0)
                                        <div class="reply-item border p-4 mb-2 rounded-lg">
                                            <div class="name-area mb-2">
                                                <h6 class="title">{{ __($message->ticket->name) }}</h6>
                                            </div>
                                            <div class="content-area">
                                                <span class="meta-date">
                                                    @lang('Posted on'), {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                                </span>
                                                <p>
                                                    {{ __($message->message) }}
                                                </p>
                                                @if($message->attachments()->count() > 0)
                                                    <div class="mt-2">
                                                        @foreach($message->attachments as $k=> $image)
                                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <ul>
                                            <div class="reply-item border p-4 mb-2 admin-reply rounded-lg">
                                                <div class="name-area mb-2">
                                                    <h6 class="title">{{ __($message->admin->name) }}</h6>
                                                </div>
                                                <div class="content-area">
                                                    <span class="meta-date">
                                                    @lang('Posted on'), {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                                    </span>
                                                    </span>
                                                    <p>
                                                        {{ __($message->message) }}
                                                    </p>
                                                    @if($message->attachments()->count() > 0)
                                                        <div class="mt-2">
                                                            @foreach($message->attachments as $k=> $image)
                                                                <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </ul>
                                    @endif
                                @endforeach

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--  Ticket Chat Section  -->

    </div>
</section>


<div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                @csrf
                <div class="modal-header bg-primary">
                    <strong class="modal-title text-white"> @lang('Confirmation')!</strong>
                    <button type="button" class="close close-button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <strong class="text-dark">@lang('Are you sure you want to Close This Support Ticket')?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmn-btn bg-danger btn-md text-white" data-dismiss="modal">
                        @lang('Close')
                    </button>
                    <button type="submit" class="cmn-btn bg-primary btn-md text-white" name="replayTicket" value="2">@lang("Confirm")
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";
        (function($){
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
        })(jQuery);

        function extraTicketAttachment() {
            $("#fileUploadsContainer").append(`
            <div class="input-group mb-3">
                                           
                                            <div class="custom-file">
                                                <input type="file" name="attachments[]" id="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label mb-0" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
            `)
        }
    </script>
@endpush
