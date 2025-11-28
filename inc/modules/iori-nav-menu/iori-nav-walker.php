<?php

/**
 * Iori Nav walker
 */
if ( ! class_exists( 'Iori_Mega_Menu_Walker' ) ) {
	class Iori_Mega_Menu_Walker extends Walker_Nav_Menu {
	

		private $color_scheme = 'dark';

		public function __construct() {
			 $this->color_scheme = 'default';
		}

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );

			if ( $depth > 1 ) {
				$sub_menu_class = 'sub-menu list-unstyled no-gutters';
			} else {
				$sub_menu_class = 'sub-sub-menu list-unstyled no-gutters sub-menu';
			}

			$output .= "\n$indent<ul class=\"$sub_menu_class color-scheme-" . $this->color_scheme . "\">\n";

			if ( $this->color_scheme == 'light' || $this->color_scheme == 'dark' ) {
				$this->color_scheme = 'default';
			}
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "$indent</ul>\n";
		}

		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'item-level-' . $depth;

			$design       = $width = $height = $icon = $label = $label_out = '';
			$design       = get_post_meta( $item->ID, '_menu_item_design', true );
			$width        = get_post_meta( $item->ID, '_menu_item_width', true );
			$height       = get_post_meta( $item->ID, '_menu_item_height', true );
			$icon         = get_post_meta( $item->ID, '_menu_item_icon', true );
			$label        = get_post_meta( $item->ID, '_menu_item_label', true );
			$label_text   = get_post_meta( $item->ID, '_menu_item_label-text', true );
			$block        = get_post_meta( $item->ID, '_menu_item_block', true );
			$color_scheme = get_post_meta( $item->ID, '_menu_item_colorscheme', true );

			if ( $color_scheme == 'light' ) {
				$this->color_scheme = 'light';
			} elseif ( $color_scheme == 'dark' ) {
				$this->color_scheme = 'dark';
			}

			if ( empty( $design ) ) {
				$design = 'default';
			}

			if ( ! is_object( $args ) ) {
				return;
			}

			if ( $depth == 0 ) {
				$classes[] = 'items parent level0 ' . $design;
				$classes[] = 'menu-' . ( ( in_array( $design, array( 'sized', 'full-width' ) ) ) ? 'mega-dropdown has-children' : 'simple-dropdown' );
				$event     = ( empty( $event ) ) ? 'hover' : $event;
				$classes[] = 'item-event-' . $event;
			}

			if ( ! empty( $label ) ) {
				$classes[] = 'item-with-label';
				$classes[] = 'item-label-' . $label;
				$label_out = '<span class="menu-label menu-label-' . $label . '">' . esc_attr( $label_text ) . '</span>';
			}

			if ( $height && $design == 'sized' ) {
				$classes[] = 'dropdown-with-height';
			}

			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts          = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$atts['class'] = 'iori-nav-link';

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon_url = '';

			if ( $item->object == 'product_cat' ) {
				$icon_url = get_term_meta( $item->object_id, 'category_icon_alt', true );
			}

			$item_output  = $args->before;
			$item_output .= '<a' . $attributes . '>';
			if ( $icon != '' ) {
				$item_output .= '<i class="' . $icon . '"></i>';
			}

			$icon_attrs = apply_filters( 'iori_megamenu_icon_attrs', false );

			if ( ! empty( $icon_url ) ) {
				$item_output .= '<img src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $item->title ) . '" ' . $icon_attrs . ' class="category-icon" />';
			}
			/** This filter is documented in wp-includes/post-template.php */
			$item_output .= '<span class="nav-link-text">' . $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . '</span>';
			$item_output .= $label_out;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$styles = '';

			if ( $depth == 0 ) {
				/**
				 * Add background image to dropdown
				 */

				if ( has_post_thumbnail( $item->ID ) ) {
					$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
					$styles        .= '.menu-item-' . $item->ID . ' > .sub-menu-dropdown {';
					$styles        .= 'background-image: url(' . $post_thumbnail[0] . '); ';
					$styles        .= '}';
				}

				if ( ! empty( $block ) && ! in_array( 'menu-item-has-children', $item->classes ) && $design != 'default' ) {
					$item_output .= "\n$indent<div class=\"sub-menu color-scheme-" . $this->color_scheme . "\">\n";
					$item_output .= "\n$indent<div class=\"iori-megamenu\">\n";
					$item_output .= iori_extra_block_shortcode( array( 'id' => $block ) );
					$item_output .= "\n$indent</div>\n";
					$item_output .= "\n$indent</div>\n";
				}
			}

			if ( $design == 'sized' && ! empty( $height ) && ! empty( $width ) ) {
				$styles .= '.menu-item-' . $item->ID . '.sized > .sub-menu {';
				$styles .= 'min-height: ' . $height . 'px; ';
				$styles .= 'width: ' . $width . 'px; ';
				$styles .= '}';
			}

			if ( $styles != '' ) {
				$item_output .= '<style>';
				$item_output .= $styles;
				$item_output .= '</style>';
			}

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}



