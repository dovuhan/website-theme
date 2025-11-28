<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title( '|' ); ?></title>

	<?php wp_head(); ?>
</head>

<body id="home" class="wide">
	<header class="header header2 sticky-bar">
		<div class="container">
			<div class="main-header">
			<div class="header-left">
				<div class="header-logo">
					<?php the_custom_logo(); ?>
				</div>
				<div class="header-nav">
				<div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
				</div>
				<div class="header-right">
				<nav class="nav-main-menu d-none d-xl-block">
					<ul class="main-menu">
						<li><a class="active" href="#contact"><?php esc_html_e( 'Contact', 'iori' ); ?></a></li>
						<li><a class="active" href="#address"><?php esc_html_e( 'Address', 'iori' ); ?></a></li>
					</ul>
				</nav>
				</div>
			</div>
			</div>
		</div>
	</header>
	<section id="contact" class="section mt-90">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-7 mb-40"><span class="btn btn-tag wow animate__animated animate__fadeIn" data-wow-delay=".0s"><?php esc_html_e( 'Under Construction', 'iori' ); ?></span>
					<h1 class="color-brand-1 mt-15 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".0s"><?php echo iori_theme_option( 'coming_soon_heading' ); ?></h1>
					<div class="box-count box-count-square mb-50">
						<div class="deals-countdown" data-countdown="<?php echo iori_theme_option( 'coming_soon_time' ); ?>"></div>
					</div>
					<div class="col-md-9">
					<p class="font-md color-grey-500 wow animate__animated animate__fadeIn" data-wow-delay=".0s"><?php echo iori_theme_option( 'coming_soon_desc' ); ?></p>
					</div>
					<div class="row">
						<div class="col-lg-9">
							<div class="box-notify-me mt-15">
								<div class="inner-notify-me wow animate__animated animate__fadeIn" data-wow-delay=".0s">
									<?php
									$coming_soon_code = iori_theme_option( 'coming_soon_code' );
									echo do_shortcode( $coming_soon_code ); 
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="mt-45 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
						<?php 
						$coming_soon_social = iori_theme_option( 'coming_soon_social' ); 
						foreach ( $coming_soon_social as $key => $social ) {
							?>
							<a class="icon-socials <?php echo esc_attr( $social['name'] ); ?> mr-15" href="<?php echo esc_url( $social['link'] ); ?>"></a>
						<?php } ?>
					</div>
				</div>
				<div class="col-lg-5 mb-40">
					<?php 
					$coming_soon_image = iori_theme_option( 'coming_soon_image' ); 
					if ( $coming_soon_image ) {
						echo '<img src="' . $coming_soon_image . '">"';
					} else {
						?>
					<object data="<?php echo IORI_ASSETS; ?>/imgs/page/coming/coming_soon.svg" type="image/svg+xml"></object>
					<?php } ?>
				</div>
			</div>
			<div class="border-bottom mb-0 mt-50"></div>
		</div>
	</section>

	<section id="address" class="section mt-100">
		<div class="container">
			<div class="row">
				<?php 
				$coming_soon_address = iori_theme_option( 'coming_soon_address' );
				$i                   = 0;
				foreach ( $coming_soon_address as $address ) {
					?>
				<div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".0<?php echo esc_attr( $i ); ?>s">
					<div class="card-small card-small-2">
						<div class="card-image">
							<div class="box-image"><img src="<?php echo esc_url( $address['icon'] ); ?>" alt="iori"></div>
						</div>
						<div class="card-info">
							<h6 class="color-brand-1 mb-10"><?php echo esc_html( $address['title'] ); ?></h6>
							<p class="font-xs color-grey-500">
							<?php echo wpautop( $address['desc'] ); ?>
							</p>
						</div>
					</div>
				</div>
				<?php $i++; } ?>
			</div>
		</div>
	</section>


	<!-- /WRAPPER -->
	<?php wp_footer(); ?>
</body>

</html>
