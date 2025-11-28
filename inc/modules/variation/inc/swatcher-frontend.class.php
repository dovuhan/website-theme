<?php
/**
 * Class Iori_WC_Variation_Swatcher_Frontend
 */
class Iori_WC_Variation_Swatcher_Frontend {
	/**
	 * The single instance of the class
	 *
	 * @var Iori_WC_Variation_Swatcher_Frontend
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return Iori_WC_Variation_Swatcher_Frontend
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'get_swatch_html' ), 100, 2 );
			add_filter( 'iori_swatch_html', array( $this, 'swatch_html' ), 5, 4 );
	}

	/**
	 * Enqueue scripts and stylesheets
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'iori-variation-frontend', IORI_MODULES_URI . 'variation/assets/css/frontend.css', array(), '20160615' );
		wp_enqueue_script( 'iori-variation-frontend', IORI_MODULES_URI . 'variation/assets/js/frontend.js', array( 'jquery' ), '20160615', true );
	}

	/**
	 * Filter function to add swatches bellow the default selector
	 *
	 * @param $html
	 * @param $args
	 *
	 * @return string
	 */
	public function get_swatch_html( $html, $args ) {
		$swatch_types = Iori_WCVS()->types;

		$product_attr_checkbox = get_post_meta( get_the_ID(), '_iori_product_settings', true );
		$product_attr_checkbox = ( isset( $product_attr_checkbox['product_attr_checkbox'] ) ) ? $product_attr_checkbox['product_attr_checkbox'] : '';

		if ( $product_attr_checkbox ) {
			$attr = Iori_WCVS()->get_tax_attribute( $args['attribute'] );
		} else {
			$attr = '';
		}
		
		// Return if this is normal attribute
		if ( empty( $attr ) ) {
			return $html;
		}

		if ( ! array_key_exists( $attr->attribute_type, $swatch_types ) ) {
			return $html;
		}

		$options    = $args['options'];
		$product    = $args['product'];
		$attribute  = $args['attribute'];
		$label_name = str_replace( 'pa_', '', $attribute );
		$class      = "variation-selector variation-select-{$attr->attribute_type}";
		$swatches   = '';

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		if ( array_key_exists( $attr->attribute_type, $swatch_types ) ) {
			if ( ! empty( $options ) && $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options ) ) {
						$swatches .= apply_filters( 'iori_swatch_html', '', $term, $attr->attribute_type, $args );
					}
				}
			}

			if ( ! empty( $swatches ) && $attr->attribute_type == 'hm_popup' ) {
				$class .= ' hidden';

				$swatches = '<div class="iori-swatches" data-attribute_name="attribute_' . esc_attr( $attribute ) . '">' . $swatches . '</div>';
				$html     = '<div class="modal-area"><div id="ji_popup" data-toggle="modal" data-target="#ji_popup_modal">Choose ' . $label_name . ' </div><span id="selected_popup_item"></span></div><div class="' . esc_attr( $class ) . '">' . $html . '</div>
				<div class="modal fade" id="ji_popup_modal" role="dialog">
				<div class="modal-dialog">
				<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="modal-body">
				<h3>Choose your stone from the lists</h3>
				<small>- Please note that the stone used in the product will be faceted or non-faceted as is shown in the pictures below.</small>
				<p>
				' . $swatches . '
				</p>
				</div>
				</div>
				</div>
				</div>
				';

			} else {
				$class .= ' hidden';

				$swatches = '<div class="iori-swatches" data-id="' . esc_attr( $attribute ) . '" data-attribute_name="attribute_' . esc_attr( $attribute ) . '">' . $swatches . '</div>';
				$html     = '<div class="' . esc_attr( $class ) . '">' . $html . '</div>' . $swatches;
			}
		}

		return $html;
	}

	/**
	 * Print HTML of a single swatch
	 *
	 * @param $html
	 * @param $term
	 * @param $type
	 * @param $args
	 *
	 * @return string
	 */
	public function swatch_html( $html, $term, $type, $args ) {
		$selected = sanitize_title( $args['selected'] ) == $term->slug ? 'selected' : '';
		$name     = esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );

		switch ( $type ) {
			case 'hm_color':
				$color             = get_term_meta( $term->term_id, 'hm_color', true );
				list( $r, $g, $b ) = sscanf( $color, '#%02x%02x%02x' );
				$html              = sprintf(
					'<span class="swatch swatch-color swatch-%s %s" style="background-color:%s;color:%s;" title="%s" data-value="%s">%s</span>',
					esc_attr( $term->slug ),
					$selected,
					esc_attr( $color ),
					"rgba($r,$g,$b,0.5)",
					esc_attr( $name ),
					esc_attr( $term->slug ),
					$name
				);
				break;

			case 'hm_image':
				$image = get_term_meta( $term->term_id, 'hm_image', true );
				$image = $image ? wp_get_attachment_image_src( $image ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				$html  = sprintf(
					'<span class="swatch swatch-image swatch-%s %s" title="%s" data-value="%s"><img src="%s" alt="%s"></span>',
					esc_attr( $term->slug ),
					$selected,
					esc_attr( $name ),
					esc_attr( $term->slug ),
					esc_url( $image ),
					esc_attr( $name )
				);
				break;

			case 'hm_label':
				$label = get_term_meta( $term->term_id, 'hm_label', true );
				$label = $label ? $label : $name;
				$html  = sprintf(
					'<span class="swatch swatch-label swatch-%s %s" title="%s" data-value="%s">%s</span>',
					esc_attr( $term->slug ),
					$selected,
					esc_attr( $name ),
					esc_attr( $term->slug ),
					esc_html( $label )
				);
				break;

			case 'hm_popup':
				$popup = get_term_meta( $term->term_id, 'hm_popup', true );
				$popup = $popup ? wp_get_attachment_image_src( $popup ) : '';
				$popup = $popup ? $popup[0] : WC()->plugin_url() . '';
				$html  = sprintf(
					'<span class="swatch swatch-popup swatch-%s %s" title="%s" data-value="%s"><img src="%s" alt="%s">%s</span>',
					esc_attr( $term->slug ),
					$selected,
					esc_attr( $name ),
					esc_attr( $term->slug ),
					esc_url( $popup ),
					esc_attr( $name ),
					esc_attr( $name )
				);
				break;
		}

		return $html;
	}
}
