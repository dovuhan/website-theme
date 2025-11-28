<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function iori_register_sidebar() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'iori' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Widget Area for post and page.', 'iori' ),
			'before_widget' => '<section id="%1$s" class="widget block %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title block-title text-uppercase">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop', 'iori' ),
			'id'            => 'shop-1',
			'description'   => esc_html__( 'Widget Area for shop pages.', 'iori' ),
			'before_widget' => '<section id="%1$s" class="widget block %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title block-title text-uppercase">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'iori' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'iori' ),
			'before_widget' => '<section id="%1$s" class="widget block %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title block-title text-uppercase">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'iori' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'iori' ),
			'before_widget' => '<section id="%1$s" class="widget block %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title block-title text-uppercase">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'iori' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'iori' ),
			'before_widget' => '<section id="%1$s" class="widget block %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title block-title text-uppercase">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 4', 'iori' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'For footer style 1 and 2.', 'iori' ),
			'before_widget' => '<section id="%1$s" class="widget ft-block block %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title block-title text-uppercase">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 5', 'iori' ),
			'id'            => 'footer-5',
			'description'   => esc_html__( 'Only for footer style 2.', 'iori' ),
			'before_widget' => '<section id="%1$s" class="widget ft-block block %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title block-title text-uppercase">',
			'after_title'   => '</h4>',
		)
	);
}
