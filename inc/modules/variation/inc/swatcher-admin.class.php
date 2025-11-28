<?php
/**
 * Class Iori_WC_Variation_Swatcher_Admin
 */
class Iori_WC_Variation_Swatcher_Admin {
	/**
	 * The single instance of the class
	 *
	 * @var Iori_WC_Variation_Swatcher_Admin
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return Iori_WC_Variation_Swatcher_Admin
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
		add_action( 'admin_init', array( $this, 'includes' ) );
		add_action( 'admin_init', array( $this, 'init_attribute_hooks' ) );
		add_action( 'admin_print_scripts', array( $this, 'enqueue_scripts' ) );

		// Display attribute fields
		add_action( 'iori_product_attribute_field', array( $this, 'attribute_fields' ), 10, 3 );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once dirname( __FILE__ ) . '/swatcher-admin-product.class.php';
	}

	/**
	 * Init hooks for adding fields to attribute screen
	 * Save new term meta
	 * Add thumbnail column for attribute term
	 */
	public function init_attribute_hooks() {
		$attribute_taxonomies = ( function_exists( 'wc_get_attribute_taxonomies' ) ) ? wc_get_attribute_taxonomies() : '';

		if ( empty( $attribute_taxonomies ) ) {
			return;
		}

		foreach ( $attribute_taxonomies as $tax ) {
			add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', array( $this, 'add_attribute_fields' ) );
			add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields', array( $this, 'edit_attribute_fields' ), 10, 2 );

			add_filter( 'manage_edit-pa_' . $tax->attribute_name . '_columns', array( $this, 'add_attribute_columns' ) );
			add_filter( 'manage_pa_' . $tax->attribute_name . '_custom_column', array( $this, 'add_attribute_column_content' ), 10, 3 );
		}

		add_action( 'created_term', array( $this, 'save_term_meta' ), 10, 2 );
		add_action( 'edit_term', array( $this, 'save_term_meta' ), 10, 2 );
	}

	/**
	 * Load stylesheet and scripts in edit product attribute screen
	 */
	public function enqueue_scripts() {
		$screen = get_current_screen();
		if ( strpos( $screen->id, 'edit-pa_' ) === false && strpos( $screen->id, 'product' ) === false ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_style( 'iori-variation', IORI_MODULES_URI . 'variation/assets/css/admin.css', array( 'wp-color-picker' ), '20160615' );
		wp_enqueue_script( 'iori-variation', IORI_MODULES_URI . 'variation/assets/js/admin.js', array( 'jquery', 'wp-color-picker', 'wp-util' ), '20170113', true );

		wp_localize_script(
			'iori-variation',
			'iori',
			array(
				'i18n'        => array(
					'mediaTitle'  => esc_html__( 'Choose an image', 'iori' ),
					'mediaButton' => esc_html__( 'Use image', 'iori' ),
				),
				'placeholder' => WC()->plugin_url() . '/assets/images/placeholder.png',
			)
		);
	}

	/**
	 * Create hook to add fields to add attribute term screen
	 *
	 * @param string $taxonomy
	 */
	public function add_attribute_fields( $taxonomy ) {
		$attr = Iori_WCVS()->get_tax_attribute( $taxonomy );

		do_action( 'iori_product_attribute_field', $attr->attribute_type, '', 'add' );
	}

	/**
	 * Create hook to fields to edit attribute term screen
	 *
	 * @param object $term
	 * @param string $taxonomy
	 */
	public function edit_attribute_fields( $term, $taxonomy ) {
		$attr  = Iori_WCVS()->get_tax_attribute( $taxonomy );
		$value = get_term_meta( $term->term_id, $attr->attribute_type, true );

		do_action( 'iori_product_attribute_field', $attr->attribute_type, $value, 'edit' );
	}

	/**
	 * Print HTML of custom fields on attribute term screens
	 *
	 * @param $type
	 * @param $value
	 * @param $form
	 */
	public function attribute_fields( $type, $value, $form ) {
		// Return if this is a default attribute type
		if ( in_array( $type, array( 'select', 'text' ) ) ) {
			return;
		}

		// Print the open tag of field container
		printf(
			'<%s class="form-field">%s<label for="term-%s">%s</label>%s',
			'edit' == $form ? 'tr' : 'div',
			'edit' == $form ? '<th>' : '',
			esc_attr( $type ),
			Iori_WCVS()->types[ $type ],
			'edit' == $form ? '</th><td>' : ''
		);

		switch ( $type ) {
			case 'hm_image':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				?>
				<div class="iori-term-image-thumbnail" style="float:left;margin-right:10px;">
					<img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" />
				</div>
				<div style="line-height:60px;">
					<input type="hidden" class="iori-term-image" name="hm_image" value="<?php echo esc_attr( $value ); ?>" />
					<button type="button" class="iori-upload-image-button button"><?php esc_html_e( 'Upload/Add image', 'iori' ); ?></button>
					<button type="button" class="iori-remove-image-button button <?php echo esc_attr( $value ? '' : 'hidden' ); ?>"><?php esc_html_e( 'Remove image', 'iori' ); ?></button>
				</div>
				<?php
				break;

			case 'hm_popup':
				$popup_type_image = $value ? wp_get_attachment_image_src( $value ) : '';
				$popup_type_image = $popup_type_image ? $popup_type_image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				?>
				<div class="iori-term-image-thumbnail" style="float:left;margin-right:10px;">
					<img src="<?php echo esc_url( $popup_type_image ); ?>" width="60px" height="60px" />
				</div>
				<div style="line-height:60px;">
					<input type="hidden" class="iori-term-image" name="hm_popup" value="<?php echo esc_attr( $value ); ?>" />
					<button type="button" class="iori-upload-image-button button"><?php esc_html_e( 'Upload/Add image', 'iori' ); ?></button>
					<button type="button" class="iori-remove-image-button button <?php echo esc_attr( $value ? '' : 'hidden' ); ?>"><?php esc_html_e( 'Remove image', 'iori' ); ?></button>
				</div>
				<?php
				break;

			default:
				?>
				<input type="text" id="term-<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( $value ); ?>" />
				<?php
				break;
		}

		// Print the close tag of field container
		echo 'edit' == $form ? '</td></tr>' : '</div>';
	}

	/**
	 * Save term meta
	 *
	 * @param int $term_id
	 * @param int $tt_id
	 */
	public function save_term_meta( $term_id, $tt_id ) {
		foreach ( Iori_WCVS()->types as $type => $label ) {
			if ( isset( $_POST[ $type ] ) ) {
				update_term_meta( $term_id, $type, $_POST[ $type ] );
			}
		}
	}

	/**
	 * Add thumbnail column to column list
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_attribute_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = 'Thumb';
		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Render thumbnail HTML depend on attribute type
	 *
	 * @param $columns
	 * @param $column
	 * @param $term_id
	 */
	public function add_attribute_column_content( $columns, $column, $term_id ) {
		$attr  = Iori_WCVS()->get_tax_attribute( $_REQUEST['taxonomy'] );
		$value = get_term_meta( $term_id, $attr->attribute_type, true );

		switch ( $attr->attribute_type ) {
			case 'hm_color':
				printf( '<div class="swatch-preview swatch-color" style="background-color:%s;"></div>', esc_attr( $value ) );
				break;

			case 'hm_image':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				printf( '<img class="swatch-preview swatch-image" src="%s" width="44px" height="44px">', esc_url( $image ) );
				break;

			case 'hm_label':
				printf( '<div class="swatch-preview swatch-label">%s</div>', esc_html( $value ) );
				break;

			case 'hm_popup':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				printf( '<img class="swatch-preview swatch-popup" src="%s" width="44px" height="44px">', esc_url( $image ) );
				break;
		}
	}
}
