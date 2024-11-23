<?php
/**
 * Fox Shop Theme Customizer
 *
 * @package Fox_Shop
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fox_shop_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'fox_shop_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'fox_shop_customize_partial_blogdescription',
		) );
	}
	
	/**
	* Fox Shop Custom Customizer Customizations [ PS: The order matters ( add_panel, add_section, add_setting, add_control ) ]
	*/
	
	/**
	 * Checkbox sanitization callback.
	 * 
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function theme_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
	
	/**
	 * Create custom control for Fox Shop Documentation link.
	 *
	 * Class WP_Customize_Control is loaded only when theme customizer is acutally used. 
	 * So, I've defined my custom class within the fox_shop_customize_register function that is binded to the 'customize_register' action.
	 *
	 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/#custom-controls-sections-and-panels.
	 */ 
	class WP_Documentation_Link_Customize_Control extends WP_Customize_Control {
		public $type = 'fox_shop_documentation_link';
		/** 
		* Render the control's content. esc_url($my_theme->get( 'AuthorURI' ))
		*/
		public function render_content() {
		?>
			<a href="<?php echo esc_url( wp_get_theme()->get( 'AuthorURI' ) ) . 'blog/article/fox-shop-gutenberg-ready-woocommerce-wordpress-theme'; ?>" class="button button-primary" id="fox-shop-documentation-link" target="_blank" tabindex="0"><?php _e( 'Documentation', 'fox-shop' ); ?></a>
		<?php
		}
	}
	
	// Documentation Section
	$wp_customize->add_section( 'fox_shop_documentation', array(
		'title'				=> __( 'Fox Shop Documentation', 'fox-shop' ),
		'description'		=> __( 'View Fox Shop Documentation.', 'fox-shop' ),
		'priority'			=> 1,
		'capability'		=> 'edit_theme_options',
	    'theme_supports' 	=> '', // Rarely needed.
	) );
	
	// Documentation Button ( from custom control WP_Documentation_Link_Customize_Control )
	$wp_customize->add_control( new WP_Documentation_Link_Customize_Control( $wp_customize, 'documentation_button', array(
        'section'			=> 'fox_shop_documentation',
        'settings'			=> array(),
    ) ) );
	
	// Add Theme Options Panel
	$wp_customize->add_panel( 'theme_options', array(
	  'title'				=> __( 'Theme Options', 'fox-shop' ),
	  'description'			=> __( 'Adjust Fox Shop Theme Options.', 'fox-shop' ),
	  'priority'			=> 160,
	) );
	
	// CTA Button Settings Section
	$wp_customize->add_section( 'cta_button_settings', array(
		'title'				=> __( 'CTA Button', 'fox-shop' ),
		'description'		=> __( 'Edit call-to-action button text and link.', 'fox-shop' ),
		'panel' 			=> 'theme_options', 
		'priority'			=> 1,
		'capability'		=> 'edit_theme_options',
	    'theme_supports' 	=> '', // Rarely needed.
	) );
	
	
	// Display CTA Button 
	$wp_customize->add_setting( 'fox_shop_display_cta_button', array(
	  'type' 				=> 'theme_mod', // or 'option'
	  'capability' 			=> 'edit_theme_options',
	  'theme_supports'	 	=> '', // Rarely needed.
	  'default' 			=> true,
	  'transport' 			=> 'refresh', // or postMessage
	  'sanitize_callback'   => 'theme_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'fox_shop_display_cta_button', array(
	  'label' 				=> __( 'Display CTA Button', 'fox-shop' ),
	  'type' 				=> 'checkbox',
	  'section' 			=> 'cta_button_settings',
	) );
	
	// CTA Button URL 
	$wp_customize->add_setting( 'fox_shop_cta_button_url', array(
	  'type' 				=> 'theme_mod', // or 'option'
	  'capability' 			=> 'edit_theme_options',
	  'theme_supports'	 	=> '', // Rarely needed.
	  'default' 			=> ( class_exists( 'WooCommerce' ) ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '#',
	  'transport' 			=> 'refresh', // or postMessage
	  'sanitize_callback' 	=> 'esc_url_raw',
	) );

	$wp_customize->add_control( 'fox_shop_cta_button_url', array(
	  'label' 				=> __( 'CTA Button URL', 'fox-shop' ),
	  'type' 				=> 'url',
	  'section' 			=> 'cta_button_settings',
	) );
	
	// CTA Button Text 
	$wp_customize->add_setting( 'fox_shop_cta_button_text', array(
	  'type' 				=> 'theme_mod', // or 'option'
	  'capability' 			=> 'edit_theme_options',
	  'theme_supports'	 	=> '', // Rarely needed.
	  'default' 			=> __( 'Shop Now', 'fox-shop' ),
	  'transport' 			=> 'refresh', // or postMessage
	  'sanitize_callback' 	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'fox_shop_cta_button_text', array(
	  'label' 				=> __( 'CTA Button Text', 'fox-shop' ),
	  'type' 				=> 'text',
	  'section' 			=> 'cta_button_settings',
	) );
	
}
add_action( 'customize_register', 'fox_shop_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function fox_shop_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function fox_shop_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fox_shop_customize_preview_js() {
	wp_enqueue_script( 'fox-shop-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'fox_shop_customize_preview_js' );

/**
 * Enqueue CSS for styling custom controls in the customizer.
 */
function fox_shop_customize_preview_assets() {
	wp_enqueue_style( 'fox-shop-customizer-custom-controls', get_template_directory_uri() . '/style/css/customizer.css', array(), '20240530', 'all' );
}
add_action( 'customize_controls_enqueue_scripts', 'fox_shop_customize_preview_assets' );
