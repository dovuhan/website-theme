<?php
/**
 * Iori callback functions of layout hooks
 *
 * @package  Iori
 */

/**
 * After header
 */
function iori_page_wrapper_start() {
	?>
		<?php if ( ! iori_is_ajax() ) : ?>
			<div id="iori-ajax-wrapper">
		<?php elseif ( iori_is_pjax() ) : ?>
			<?php _wp_render_title_tag(); ?>
		<?php endif ?>
		<?php
}

/**
 * Page title after header
 */
function iori_page_title() {
	$page_for_posts = get_option( 'page_for_posts' );

	$title = ( ! empty( $page_for_posts ) ) ? get_the_title( $page_for_posts ) : esc_html__( 'Blog', 'iori' );
	
	if ( is_singular( 'page' ) && ( ! $page_for_posts || ! is_page( $page_for_posts ) ) ) {
		$title = get_the_title();
	}

	if ( is_tag() ) {
		$title = esc_html__( 'Tag Archives: ', 'iori' ) . single_tag_title( '', false );
	}

	if ( is_category() ) {
		$title = '<span>' . single_cat_title( '', false ) . '</span>';
	}

	if ( is_date() ) {
		if ( is_day() ) :
			$title = esc_html__( 'Daily Archives: ', 'iori' ) . get_the_date();
		elseif ( is_month() ) :
			$title = esc_html__( 'Monthly Archives: ', 'iori' ) . get_the_date( _x( 'F Y', 'monthly archives date format', 'iori' ) );
		elseif ( is_year() ) :
			$title = esc_html__( 'Yearly Archives: ', 'iori' ) . get_the_date( _x( 'Y', 'yearly archives date format', 'iori' ) );
		else :
			$title = esc_html__( 'Archives', 'iori' );
		endif;
	}

	if ( is_author() ) {
		/*
			* Queue the first post, that way we know what author
			* we're dealing with (if that is the case).
			*
			* We reset this later so we can run the loop
			* properly with a call to rewind_posts().
			*/
		the_post();

		$title = esc_html__( 'Posts by ', 'iori' ) . '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>';

		/*
			* Since we called the_post() above, we need to
			* rewind the loop back to the beginning that way
			* we can run the loop properly, in full.
			*/
		rewind_posts();
	}

	if ( is_search() ) {
		$title = esc_html__( 'Search Results for: ', 'iori' ) . get_search_query();
	}
	$bdrc = iori_theme_option( 'iori_breadcrumb' );
	$bdrc = ( ! empty( $bdrc ) ) ? 'style="background-image: url(' . esc_url( $bdrc ) . ' );background-position: center;background-size: cover;"' : '';
	
	$iori_breadcrumb_on_off = iori_theme_option( 'iori_breadcrumb_switch' );

	if ( $iori_breadcrumb_on_off ) {
		?>
		<div class="page-detail-wrapper" <?php echo wp_kses_post( $bdrc ); ?>>
			<h1 class="page-heading text-center"><?php echo wp_kses_post( $title ); ?></h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><?php iori_breadcrumbs(); ?></li>
			</ol>
		</div>
		<?php 
	}
}

/**
 * Before footer 'iori_subscription'
 */
function iori_subscription() {
	$iori_inner_subscription     = iori_theme_option( 'iori_inner_subscription' );
	$iori_subs_title             = iori_theme_option( 'iori_subs_title' );
	$iori_subs_id                = iori_theme_option( 'iori_subs_id' );
	$iori_popup_subscription     = iori_theme_option( 'iori_popup_subscription' );
	$iori_popup_subscription_img = iori_theme_option( 'iori_popup_subscription_img' );
	$iori_subs_popup_title       = iori_theme_option( 'iori_subs_popup_title' );
	$iori_subs_popup_desc        = iori_theme_option( 'iori_subs_popup_desc' );
	$iori_subs_popup_id          = iori_theme_option( 'iori_subs_popup_id' );

	if ( $iori_inner_subscription ) {
		?>
	<section class="st-get-exclusive">
		<div class="container">
			<div class="newsletter-widget--lg text-center">
				<h2 class="title playfair-display fs_32"><?php echo wp_kses_post( $iori_subs_title ); ?></h2>
				<div class="form-input-group">
					<?php 
					if ( shortcode_exists( 'mc4wp_form' ) ) {
						echo do_shortcode( '[mc4wp_form id="' . $iori_subs_id . '"]' );
					}
					?>
				</div>
			</div>
		</div>
	</section>
		<?php
	}
	if ( $iori_popup_subscription ) {
		?>
	<div id="newsletter_popup" class="newsletter-popup mfp-with-anim mfp-hide">
		<button title="Close (Esc)" type="button" class="mfp-close close-canvas"><span class="icon_close"></span></button>
		<div class="d-flex">
			<div class="newsletter-image" style="background-image: url(<?php echo esc_url( $iori_popup_subscription_img ); ?>);">&nbsp;</div>
			<div class="newsletter-form d-flex align-items-center">
				<div class="form-content">
					<h5 class="title text-uppercase"><?php echo wp_kses_post( $iori_subs_popup_title ); ?></h5>
					<div class="mg-bottom-25"><?php echo wp_kses_post( $iori_subs_popup_desc ); ?></div>
					<form class="needs-validation" action="#" novalidate>
						<div class="form-subscribe form-input-group">
							<div class="input-group">
								<?php 
								if ( shortcode_exists( 'mc4wp_form' ) ) {
									echo do_shortcode( '[mc4wp_form id="' . $iori_subs_popup_id . '"]' );
								}
								?>
							</div>
						</div>
					</form>
					<input id="dontShow" type="checkbox" name="newsletter_hide"> <?php esc_html_e( 'Don’t show this popup again', 'iori' ); ?>
				</div>
			</div>
		</div>
	</div>
		<?php
	}
}

/**
 * Before footer 'iori_quick_sales_services'
 */
function iori_quick_sales_services() {
	$quick_sales_service        = iori_theme_option( 'quick_sales_service' );
	$quick_sales_service_on_off = iori_theme_option( 'quick_sales_service_on_off' );
	if ( $quick_sales_service_on_off ) {
		?>
	<section class="st-service">
		<div class="container">
			<div class="row">
				<?php 
				foreach ( $quick_sales_service as $services ) {
					$image = '';
					$image = isset( $services['quick_sales_service_icon']['url'] ) ? $services['quick_sales_service_icon']['url'] : $services['quick_sales_service_icon'];
					?>
				<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="service-item">
						<div class="service-item-icon">
							<img width="65" height="60" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $services['quick_sales_service_title'] ); ?>" />
						</div>
						<div class="service-item-content">
							<h5 class="title"><?php echo esc_html( $services['quick_sales_service_title'] ); ?></h5>
							<p><?php echo esc_html( $services['quick_sales_service_desc'] ); ?></p>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>
		<?php
	}
}


/**
 * End before footer
 */
function iori_page_wrapper_end() {
	if ( ! iori_is_ajax() ) :
		?>
			</div><!-- ./iori-ajax-wrapper -->
			<?php
		endif;
	?>
	<?php
}
