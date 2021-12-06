@extends($activeTemplate.'layouts.frontend')

@section('content')

<div class="contact-section pt-120 pb-120 section-bg oh">
    <div class="container">

	{!! @$findPage->data_values->description !!}

	</div>
</div>
@endsection
