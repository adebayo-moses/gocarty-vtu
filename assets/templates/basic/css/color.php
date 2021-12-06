<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}


function checkhexcolor2($secondColor){
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor OR !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}
?>


.preloader .animated-preloader, .preloader .animated-preloader::before, .bill-items-wrapper .bill-items .nav-item.active .nav-link i, .bill-items-wrapper .bill-items .nav-item::after, .bill-items-wrapper .bill-items .nav-item:hover .nav-link i, .cmn-btn, .scroll-to-top .scroll-icon, .feature-card:hover .feature-card__icon, .social-links.style--two li a, .d-widget__icon, .d-widget::before, .d-widget__btn, .client-slider .slick-arrow:hover, .service-card:hover, .table thead{
	background: <?php echo $color; ?>;
}

.header .main-menu li a:hover, .header .main-menu li a:focus, .section-top-title, .service-card__icon i, .feature-card__icon i, .overview-card__icon i, .social-links li a:hover, .page-breadcrumb li:first-child::before, .contact-card__header i, a:hover, .d-widget.style--two .d-widget__icon i{
	color: <?php echo $color; ?>;
}

.overview-card__icon i {
	text-shadow: 0 5px 10px <?php echo $color; ?>75;
}

.base--color, .header-account-list li a:hover{
	color: <?php echo $color; ?> !important;
}
.profile-thumb .avatar-edit label {
	background-color: <?php echo $color; ?> !important;
	color: #fff !important;
}
.feature-card:hover .feature-card__icon{
	box-shadow: 0 15px 35px <?php echo $color; ?>73;
}

.bg-primary, a.bg-primary:focus, a.bg-primary:hover, button.bg-primary:focus, button.bg-primary:hover{
	background: <?php echo $color; ?> !important;
}

.form-control:focus {
    border-color: <?php echo $color; ?>;
    box-shadow: 0 0 5px <?php echo $color; ?>59;
}

.d-widget__icon::after{
	border: 3px solid <?php echo $color; ?>;
}

.btn.focus, .btn:focus{
	box-shadow: 0 0 0 0.2rem <?php echo $color; ?>40;;
}

.footer::before{
	background-color: <?php echo $secondColor; ?>;
}

.base--bg-two{
	background-color: <?php echo $secondColor; ?> !important;
}