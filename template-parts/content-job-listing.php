<?php

/**
 * Template part for displaying posts single
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package iori
 */

// meta box calling here 
$job_details_page_settings = get_post_meta( get_the_ID(), 'iori_job_details_page_settings', true );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- my testing code start -->
	<section class="section pt-50 pb-100">
		<div class="container">
			<div class="box-image-detail job-listing-brd16">
				<img src="<?php echo esc_url( $job_details_page_settings['job_details_banner_img'] ) ?>" alt="">
			</div>
			<div class="content-detail">
				<div class="row">
					<div class="col-lg-10 col-11 m-auto">
						<div class="box-detail-content">
							<div class="row align-items-center">
								<div class="col-lg-8 col-md-8 col-sm-12 col-12 mb-30">
									<h3 class="color-brand-1 mb-10 mt-0">
										<?php echo the_title(); ?>
									</h3>
									<span class="date-post font-xs color-grey-300">
										<svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
										</svg><?php echo the_date(); ?></span><span class="time-read font-xs color-grey-300">
										<svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
										</svg><?php echo iori_reading_time(); ?></span>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 col-12 text-start text-md-end mb-30">
									<a href="<?php echo esc_url( $job_details_page_settings['apply_now_btn_link'] ); ?>" class="btn btn-brand-1 btn-apply">
										<svg class="w-6 h-6 icon-18 mr-10" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
										</svg>
										<?php 
										echo esc_html( $job_details_page_settings['apply_now_btn_text'] ); 
										?>
									</a>
								</div>
							</div>
							<div class="border-bottom bd-grey-80 mb-40 pt-0"></div>
							<h4 class="color-brand-1 mb-25"><?php echo esc_html( $job_details_page_settings['job_summery_title'] ); ?></h4>
							
							
							<div class="box-info-job">
								<div class="row align-items-start">
									<?php if(isset($job_details_page_settings['job_summery_content'])) {
									 foreach ( $job_details_page_settings['job_summery_content'] as $item ) { 
										?>
										<div class="col-lg-6 col-md-6">
											<div class="item-job">
												<div class="left-title"><span class="industry" style="background-image: url(<?php echo esc_url( $item['icon_image'] ); ?>); background-size: 16px; width: 16px;">
												<?php echo esc_html( $item['name']); ?></span>
											</div>
												<div class="right-info"><?php echo esc_html( $item['text'] ); ?></div>
											</div>
										</div>
									<?php }
									}
									?>

								</div>
							</div>

							<p><?php echo the_content(); ?></p>

							<div class="box-info-bottom">
								<div class="row align-items-center">
									<div class="col-lg-6 col-md-6 col-sm-5 col-12 mb-30">
										<a class="btn btn-brand-1 btn-apply" href="#">
											<svg class="w-6 h-6 icon-18 mr-10" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
											</svg>
											<?php echo isset($job_details_page_settings['apply_now_btn2_text']) ? esc_html( $job_details_page_settings['apply_now_btn2_text'] ) : ""; ?>
										</a>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-7 col-12 text-start text-sm-end mb-30">
										<?php
										$term_obj_list = get_the_terms(get_the_ID(), 'job_listing_tax');
										if (!is_wp_error($term_obj_list) && !empty($term_obj_list)) {
											foreach ($term_obj_list as $cat_item) { 
												?>
												<a href="<?php echo esc_url(get_term_link($cat_item)); ?>" class="btn btn-tag mb-10">
													<?php echo esc_html($cat_item->name); ?>
												</a>
												<?php
											}
										}
										 ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</article><!-- #post-<?php the_ID(); ?> -->
