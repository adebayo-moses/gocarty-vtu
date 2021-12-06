@php
    $image = getContent('breadcrumb.content', true);
@endphp

<!-- Page Header Section -->
<section class="page-header-section oh">
    <div class="container">
        <div class="page-wrapper">
            <div class="page-content">
                <h2 class="title">{{ __($page_title) }}</h2>
            </div>
            <div class="page-thumb d-none d-lg-block">
                <img src="{{ getImage( 'assets/images/frontend/breadcrumb/' .@$image->data_values->image) }}" alt="banner">
            </div>
        </div>
    </div>
</section>
<!-- Page Header Section -->
