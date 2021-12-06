@extends($activeTemplate.'layouts.master')
@section('content')

<section class="pt-100 pb-100 section--bg">
  <div class="container">

        <!--  New Ticket Section  -->
        <div class="new-ticket-section pr-2 pl-2">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="ticket-wrapper rounded card p-4">

                        <div class="button-contain-header text-right">
                            <a href="{{ route('ticket') }}" class="cmn-btn bg-primary">@lang('My Supports')</a>
                        </div>

                        <form class="ticket_form mb--20 row" action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="col-md-6 form-group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form-control" placeholder="@lang('Enter Name')" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">@lang('Email address')</label>
                                <input type="email"  name="email" value="{{@$user->email}}" class="form-control " placeholder="@lang('Enter your Email')" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="website">@lang('Subject')</label>
                                <input type="text" name="subject" value="{{old('subject')}}" class="form-control" placeholder="@lang('Subject')" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="inputMessage">@lang('Message')</label>
                                <textarea name="message" required id="inputMessage" rows="6" class="form-control">{{old('message')}}</textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="d-flex">
                                    <div class="left-group col p-0 overflow-hidden">
                                        <label for="inputAttachments" class="w-100">@lang('Attachments')</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" name="attachments[]" id="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label mb-0" for="inputGroupFile01">@lang('Choose file')</label>
                                            </div>
                                        </div>
                                        <div id="fileUploadsContainer"></div>
                                        <p class="ticket-attachments-message text-muted mt-1 font-size--14px">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </p>
                                    </div>
                                    <div class="add-area">
                                        <label class="label_one d-block">&nbsp;</label>
                                        <button class="add-more ml-2 ml-md-4 icon-btn bg-primary text-white mt-2" onclick="extraTicketAttachment()" type="button"><i class="las la-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-4">
                                <button type="submit" class="cmn-btn w-100 text-center bg-primary">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--  New Ticket Section  -->

    </div>
</section>
@endsection


@push('script')
    <script>
        "use strict";
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
        function formReset() {
            window.location.href = "{{url()->current()}}"
        }
    </script>
@endpush
