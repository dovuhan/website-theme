<?php

/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iori
 */

if ( function_exists( 'iori_is_ajax' ) && ! iori_is_ajax() ) { // for ajaxify.

	$copyrights = iori_theme_option( 'copyrights' );
	?>
	<!doctype html>
	<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="https://gmpg.org/xfn/11">
		
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<?php if ( function_exists( 'wp_body_open' ) ) : ?>
			<?php wp_body_open(); ?>
		<?php endif; ?>

		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'iori' ); ?></a>
		
		<?php 
		if ( iori_theme_option( 'iori_preloader_enable' ) ) {
			?>
		<div id="preloader-active">
			<div class="preloader d-flex align-items-center justify-content-center">
				<div class="preloader-inner position-relative">
				<div class="page-loading">
					<div class="page-loading-inner">
					<div></div>
					<div></div>
					<div></div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<?php 
		$iori_top_bar_color      = iori_theme_option( 'iori_top_bar_color' );
		$iori_top_bar_text_color = iori_theme_option( 'iori_top_bar_text_color' );
		$iori_topbar_enable      = iori_theme_option( 'iori_topbar_enable' );
		if ( $iori_topbar_enable ) {
			?>
		<div class="box-notify bg-brand-1" 
			<?php 
			if ( $iori_top_bar_color ) {
				?>
			 style="background-color: <?php echo esc_attr( $iori_top_bar_color ); ?>;" <?php } ?>>
			<div class="container position-relative">
				<div class="box-container-sw">
				<div class="box-button-slider">
					<div class="swiper-button-prev-notify">
					<svg 
					<?php 
					if ( $iori_top_bar_text_color ) {
						?>
						 style="color: <?php echo esc_attr( $iori_top_bar_text_color ); ?> !important;" <?php } ?> class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
					</svg>
					</div>
					<div class="swiper-button-next-notify">
					<svg 
					<?php 
					if ( $iori_top_bar_text_color ) {
						?>
						 style="color: <?php echo esc_attr( $iori_top_bar_text_color ); ?> !important;" <?php } ?> class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
					</svg>
					</div>
				</div>
				<div class="box-swiper">
					<div class="swiper-container swiper-notify">
					<div class="swiper-wrapper">
						<?php
							$top_msgs = iori_theme_option( 'top_bar_area' );
						foreach ( $top_msgs as $key => $top_msg ) {
							?>
						<div class="swiper-slide"><span class="d-inline-block font-sm color-brand-2" 
							<?php 
							if ( $iori_top_bar_text_color ) {
								?>
							 style="color: <?php echo esc_attr( $iori_top_bar_text_color ); ?> !important;" <?php } ?>><?php echo esc_html( $top_msg['name'] ); ?></span></div>
						<?php } ?>
					</div>
					</div>
				</div>
				</div>
			</div>
			<a class="btn btn-close">
				<svg 
				<?php 
				if ( $iori_top_bar_text_color ) {
					?>
					 style="color: <?php echo esc_attr( $iori_top_bar_text_color ); ?> !important;" <?php } ?> class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
				</svg>
			</a>
		</div>
		<?php } ?>
			
		<header class="header sticky-bar">
			<div class="container">
				<div class="main-header">
					<div class="header-left">
						<div class="header-logo">

							<?php
							the_custom_logo();
							?>
						</div>
						<div class="header-nav">

							<nav class="nav-main-menu d-none d-xl-block">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'iori-main-menu',
										'menu_class'     => 'main-menu',
										'walker'         => new Iori_Mega_Menu_Walker(),
										'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									)
								);

								?>
							</nav>
							<div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
						</div>
						<div class="header-right">

							<?php

							$iori_searchbar_enable = iori_theme_option( 'iori_searchbar_enable' );
							if ( $iori_searchbar_enable ) {
								?>
								<div class="d-inline-block box-search-top">
									<div class="form-search-top">
										<form action="<?php echo esc_url( home_url( '/' ) ); ?>">
											<input class="input-search" name="s" type="text" placeholder="Search...">
											<button class="btn btn-search">
												<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
												</svg>
											</button>
										</form>
									</div>
									<span class="font-lg icon-list search-post">
										<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
										</svg>
									</span>
								</div>

							<?php } ?>

							<?php

							$iori_getstarted_enable = iori_theme_option( 'iori_getstarted_enable' );
							$button_url             = iori_theme_option( 'button_url' );
							$button_text            = iori_theme_option( 'button_text' );
							
							if ( $iori_getstarted_enable ) {
								?>
								<div class="d-none d-sm-inline-block">
									<a class="btn btn-brand-1 hover-up" href="<?php echo esc_url( $button_url ); ?>">
										<?php echo esc_html( $button_text ); ?>
									</a>
								</div>
							<?php } ?>

						</div>
					</div>
				</div>
			</div>
		</header>


		<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
			<div class="mobile-header-wrapper-inner">
				<div class="mobile-header-content-area">
					<div class="mobile-logo">
						<?php
						the_custom_logo();
						?>
					</div>
					<div class="burger-icon"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
					<div class="perfect-scroll">
						<div class="mobile-menu-wrap mobile-header-border">
							<?php 
							$mobile_menu_tabs = iori_theme_option( 'mobile_menu_tabs' );
							$mobile_noti_tabs = iori_theme_option( 'mobile_noti_tabs' );
							if ( $mobile_menu_tabs ) {
								?>
							<ul class="nav nav-tabs nav-tabs-mobile mt-25" role="tablist">
								<li>
									<a class="active" href="#tab-menu" data-bs-toggle="tab" role="tab" aria-controls="tab-menu" aria-selected="true">
										<svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
										</svg><?php esc_html_e( 'Menu', 'iori' ); ?>
									</a>
								</li>
								<li>
									<a href="#tab-account" data-bs-toggle="tab" role="tab" aria-controls="tab-account" aria-selected="false">
										<svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
										</svg><?php esc_html_e( 'Account', 'iori' ); ?>
									</a>
								</li>
								<?php if ( $mobile_noti_tabs ) { ?>
								<li>
									<a href="#tab-notification" data-bs-toggle="tab" role="tab" aria-controls="tab-notification" aria-selected="false">
										<svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
										</svg><?php esc_html_e( 'Notification', 'iori' ); ?>
									</a>
								</li>
								<?php } ?>
							</ul>
							<?php } ?>

							<div class="tab-content">
								<div class="tab-pane fade active show" id="tab-menu" role="tabpanel" aria-labelledby="tab-menu">
									<nav class="mt-15">
										<?php
										wp_nav_menu(
											array(
												'theme_location' => 'iori-main-menu',
												'menu_class' => 'main-menu mobile-menu',
												'walker' => new Iori_Mega_Menu_Walker(),
												'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
												'depth'  => 2,
											)
										);
										?>
									</nav>
								</div>

								<div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account">
									<nav class="mt-15">
										<ul class="mobile-menu font-heading">

											<?php
											$account_list_area = iori_theme_option( 'account_list_area' );

											foreach ( $account_list_area as $item ) { 
												?>

												<li><a href="<?php echo esc_url( $item['link'] ); ?>"><?php echo esc_html( $item['name'] ); ?></a></li>

											<?php } ?>

										</ul>
									</nav>
								</div>
								<?php if ( $mobile_noti_tabs ) { ?>
								<div class="tab-pane fade" id="tab-notification" role="tabpanel" aria-labelledby="tab-notification">
									<p class="font-sm-bold color-brand-1 mt-30"><?php esc_html_e( 'Recent Posts', 'iori' ); ?></p>

									<div class="notifications-item">
										<?php
										$args = array(
											'post_type'   => 'post',
											'post_status' => 'publish',
											'posts_per_page' => 5,
											'orderby'     => 'date',
											'order'       => 'DESC',
										);

										$recent_posts = new WP_Query( $args );

										if ( $recent_posts->have_posts() ) :
											while ( $recent_posts->have_posts() ) :
												$recent_posts->the_post();

												$author_id     = get_the_author_meta( 'ID' );
												$author_avatar = get_avatar( $author_id, 32 );
												?>
												<div class="item-notify">
													<div class="item-image">
														<?php echo wpautop( $author_avatar ); ?>
													</div>
													<div class="item-info">
														<p class="color-grey-500 font-xs"><strong class="font-xs-bold"><?php the_author(); ?></strong> <?php esc_html_e( 'Publised a post', 'iori' ); ?> “<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>”</p>
													</div>
													<div class="item-time"><span class="color-grey-500 font-xs"><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?></span></div>
												</div>
												<?php
												endwhile;
											wp_reset_postdata();
										else :
											echo '<p>No recent posts found.</p>';
										endif;
										?>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="site-copyright color-grey-400 mt-0">
							<div class="box-download-app">
								<p class="font-xs color-grey-400 mb-25"><?php echo esc_html( iori_theme_option( 'mobile_bottom_text' ) ); ?></p>
								<div class="mb-25">
									<?php
									$appstore_image                 = iori_theme_option( 'mobile_bottom_appstore_thumb' );
									$google_play_image              = iori_theme_option( 'mobile_bottom_google_play_thumb' );
									$payment_image                  = iori_theme_option( 'mobile_bottom_payment_thumb' );
									$mobile_bottom_appstore_link    = iori_theme_option( 'mobile_bottom_appstore_link' );
									$mobile_bottom_google_play_link = iori_theme_option( 'mobile_bottom_google_play_link' );
									?>
									<a href="<?php echo esc_url( $mobile_bottom_appstore_link ); ?>" class="mr-10">
										<img src="<?php echo esc_url( $appstore_image ); ?>" alt="iori">
									</a>
									<a href="<?php echo esc_url( $mobile_bottom_google_play_link ); ?>">
										<img src="<?php echo esc_url( $google_play_image ); ?>" alt="iori">
									</a>
								</div>
								<p class="font-sm color-grey-400 mt-20 mb-10"><?php echo esc_html( iori_theme_option( 'mobile_bottom_payment_text' ) ); ?></p>
								<img src="<?php echo esc_url( $payment_image ); ?>" alt="iori">
							</div>
							<div class="mb-0">
								<?php if ( ! empty( $copyrights ) ) { ?>
									<span class="color-grey-300 font-md"><?php echo wp_kses_post( $copyrights ); ?></span>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php
}
