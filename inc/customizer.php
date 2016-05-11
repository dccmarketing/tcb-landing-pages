<?php
/**
 * Replace With Theme Name Customizer
 *
 * Contains methods for customizing the theme customization screen.
 *
 * @link 		https://codex.wordpress.org/Theme_Customization_API
 * @since 		1.0.0
 * @package  	DocBlock
 */

// Register panels, sections, and controls
add_action( 'customize_register', 'function_names_register_panels' );
add_action( 'customize_register', 'function_names_register_sections' );
add_action( 'customize_register', 'function_names_register_fields' );

// Output custom CSS to live site
add_action( 'wp_head', 'function_names_header_output' );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init', 'function_names_live_preview' );

// Enqueue scripts for the customizer controls
add_action( 'customize_controls_enqueue_scripts', 'function_names_control_scripts' );

/**
 * Registers custom panels for the Customizer
 *
 * @see			add_action( 'customize_register', $func )
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 *
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 */
function function_names_register_panels( $wp_customize ) {

	// Theme Options Panel
	$wp_customize->add_panel( 'theme_options',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Options for Replace With Theme Name', 'tcb-landing' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Theme Options', 'tcb-landing' ),
		)
	);

	/*
	// Theme Options Panel
	$wp_customize->add_panel( 'theme_options',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Options for Replace With Theme Name', 'tcb-landing' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Theme Options', 'tcb-landing' ),
		)
	);
	*/

} // function_names_register_panels()

/**
 * Registers custom sections for the Customizer
 *
 * Existing sections:
 *
 * Slug 				Priority 		Title
 *
 * title_tagline 		20 				Site Identity
 * colors 				40				Colors
 * header_image 		60				Header Image
 * background_image 	80				Background Image
 * nav 					100 			Navigation
 * widgets 				110 			Widgets
 * static_front_page 	120 			Static Front Page
 * default 				160 			all others
 *
 * @see			add_action( 'customize_register', $func )
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 *
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 */
function function_names_register_sections( $wp_customize ) {



	/*
	// New Section
	$wp_customize->add_section( 'new_section',
		array(
			'capability' 	=> 'edit_theme_options',
			'description' 	=> esc_html__( 'New Customizer Section', 'tcb-landing' ),
			'panel' 		=> 'theme_options',
			'priority' 		=> 10,
			'title' 		=> esc_html__( 'New Section', 'tcb-landing' )
		)
	);
	*/

} // function_names_register_sections()

/**
 * Registers controls/fields for the Customizer
 *
 * Note: To enable instant preview, we have to actually write a bit of custom
 * javascript. See live_preview() for more.
 *
 * Note: To use active_callbacks, don't add these to the selecting control, it apepars these conflict:
 * 		'transport' => 'postMessage'
 * 		$wp_customize->get_setting( 'field_name' )->transport = 'postMessage';
 *
 * @see			add_action( 'customize_register', $func )
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 *
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 */
function function_names_register_fields( $wp_customize ) {

	// Enable live preview JS for default fields
	$wp_customize->get_setting( 'blogname' )->transport 		= 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';



	// Site Identity Section Fields

	// Google Tag Manager Field
	$wp_customize->add_setting(
		'tag_manager',
		array(
			'default'  			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'tag_manager',
		array(
			'description' 		=> esc_html__( 'Paste in the Google Tag Manager code here. Do not include the comment tags!', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Google Tag Manager', 'tcb-landing' ),
			'priority' 			=> 90,
			'section' 			=> 'title_tagline',
			'settings' 			=> 'tag_manager',
			'type' 				=> 'textarea'
		)
	);
	$wp_customize->get_setting( 'tag_manager' )->transport = 'postMessage';




	/*
	// Fields & Controls

	// Text Field
	$wp_customize->add_setting(
		'text_field',
		array(
			'default'  			=> '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'text_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label'  			=> esc_html__( 'Text Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section'  			=> 'new_section',
			'settings' 			=> 'text_field',
			'type' 				=> 'text'
		)
	);
	$wp_customize->get_setting( 'text_field' )->transport = 'postMessage';



	// URL Field
	$wp_customize->add_setting(
		'url_field',
		array(
			'default'  			=> '',
			'sanitize_callback' => 'esc_url_raw'
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'url_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'URL Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'url_field',
			'type' 				=> 'url'
		)
	);
	$wp_customize->get_setting( 'url_field' )->transport = 'postMessage';



	// Email Field
	$wp_customize->add_setting(
		'email_field',
		array(
			'default'  			=> '',
			'sanitize_callback' => 'sanitize_email',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'email_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Email Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'email_field',
			'type' 				=> 'email'
		)
	);
	$wp_customize->get_setting( 'email_field' )->transport = 'postMessage';

	// Date Field
	$wp_customize->add_setting(
		'date_field',
		array(
			'default'  			=> '',
			'sanitize_callback' => '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'date_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Date Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'date_field',
			'type' 				=> 'date'
		)
	);
	$wp_customize->get_setting( 'date_field' )->transport = 'postMessage';


	// Checkbox Field
	$wp_customize->add_setting(
		'checkbox_field',
		array(
			'default'  			=> 'true',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'checkbox_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Checkbox Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'checkbox_field',
			'type' 				=> 'checkbox'
		)
	);
	$wp_customize->get_setting( 'checkbox_field' )->transport = 'postMessage';




	// Password Field
	$wp_customize->add_setting(
		'password_field',
		array(
			'default'  			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'password_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Password Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'password_field',
			'type' 				=> 'password'
		)
	);
	$wp_customize->get_setting( 'password_field' )->transport = 'postMessage';



	// Radio Field
	$wp_customize->add_setting(
		'radio_field',
		array(
			'default'  			=> 'choice1',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'radio_field',
		array(
			'choices' 			=> array(
				'choice1' 		=> esc_html__( 'Choice 1', 'tcb-landing' ),
				'choice2' 		=> esc_html__( 'Choice 2', 'tcb-landing' ),
				'choice3' 		=> esc_html__( 'Choice 3', 'tcb-landing' )
			),
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Radio Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'radio_field',
			'type' 				=> 'radio'
		)
	);
	$wp_customize->get_setting( 'radio_field' )->transport = 'postMessage';



	// Select Field
	$wp_customize->add_setting(
		'select_field',
		array(
			'default'  			=> 'choice1',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'select_field',
		array(
			'choices' 			=> array(
				'choice1' 		=> esc_html__( 'Choice 1', 'tcb-landing' ),
				'choice2' 		=> esc_html__( 'Choice 2', 'tcb-landing' ),
				'choice3' 		=> esc_html__( 'Choice 3', 'tcb-landing' )
			),
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Select Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'select_field',
			'type' 				=> 'select'
		)
	);
	$wp_customize->get_setting( 'select_field' )->transport = 'postMessage';



	// Textarea Field
	$wp_customize->add_setting(
		'textarea_field',
		array(
			'default'  			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'textarea_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Textarea Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'textarea_field',
			'type'				=> 'textarea'
		)
	);
	$wp_customize->get_setting( 'textarea_field' )->transport = 'postMessage';



	// Range Field
	$wp_customize->add_setting(
		'range_field',
		array(
			'default'  			=> '',
			'sanitize_callback' => 'sanitize_hex_color'
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'range_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'input_attrs' 		=> array(
				'class' 		=> 'range-field',
				'max' 			=> 100,
				'min' 			=> 0,
				'step' 			=> 1,
				'style' 		=> 'color: #020202'
			),
			'label' 			=> esc_html__( 'Range Field', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'range_field',
			'type' 				=> 'range'
		)
	);
	$wp_customize->get_setting( 'range_field' )->transport = 'postMessage';



	// Page Select Field
	$wp_customize->add_setting(
		'select_page_field',
		array(
			'default'  			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'select_page_field',
		array(
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Select Page', 'tcb-landing' ),
			'priority' 			=> 10,
			'section' 			=> 'new_section',
			'settings' 			=> 'select_page_field',
			'type' 				=> 'dropdown-pages'
		)
	);
	$wp_customize->get_setting( 'dropdown-pages' )->transport = 'postMessage';



	// Color Chooser Field
	$wp_customize->add_setting(
		'color_field',
		array(
			'default'  			=> '#ffffff',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'color_field',
			array(
				'description' 	=> esc_html__( '', 'tcb-landing' ),
				'label' 		=> esc_html__( 'Color Field', 'tcb-landing' ),
				'priority' 		=> 10,
				'section' 		=> 'new_section',
				'settings' 		=> 'color_field'
			),
		)
	);
	$wp_customize->get_setting( 'color_field' )->transport = 'postMessage';



	// File Upload Field
	$wp_customize->add_setting( 'file_upload' );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'file_upload',
			array(
				'description' 	=> esc_html__( '', 'tcb-landing' ),
				'label' 		=> esc_html__( 'File Upload', 'tcb-landing' ),
				'priority' 		=> 10,
				'section' 		=> 'new_section',
				'settings' 		=> 'file_upload'
			),
		)
	);



	// Image Upload Field
	$wp_customize->add_setting(
		'image_upload',
		array(
			'default' 			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'image_upload',
			array(
				'description' 	=> esc_html__( '', 'tcb-landing' ),
				'label' 		=> esc_html__( 'Image Field', 'tcb-landing' ),
				'priority' 		=> 10,
				'section' 		=> 'new_section',
				'settings' 		=> 'image_upload'
			)
		)
	);
	$wp_customize->get_setting( 'image_upload' )->transport = 'postMessage';



	// Media Upload Field
	// Can be used for images
	// Returns the image ID, not a URL
	$wp_customize->add_setting(
		'media_upload',
		array(
			'default' 			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'media_upload',
			array(
				'description' 	=> esc_html__( '', 'tcb-landing' ),
				'label' 		=> esc_html__( 'Media Field', 'tcb-landing' ),
				'mime_type' 	=> '',
				'priority' 		=> 10,
				'section'		=> 'new_section',
				'settings' 		=> 'media_upload'
			)
		)
	);
	$wp_customize->get_setting( 'media_upload' )->transport = 'postMessage';




	// Cropped Image Field
	$wp_customize->add_setting(
		'cropped_image',
		array(
			'default' 			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'cropped_image',
			array(
				'description' 	=> esc_html__( '', 'tcb-landing' ),
				'flex_height' 	=> '',
				'flex_width' 	=> '',
				'height' 		=> '1080',
				'priority' 		=> 10,
				'section' 		=> 'new_section',
				'settings' 		=> 'cropped_image',
				width' 			=> '1920'
			)
		)
	);
	$wp_customize->get_setting( 'cropped_image' )->transport = 'postMessage';


	// Country Select Field
	$wp_customize->add_setting(
		'country',
		array(
			'default'  			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'country',
		array(
			'choices' 			=> function_names_country_list(),
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'Country', 'tcb-landing' ),
			'priority' 			=> 250,
			'section' 			=> 'contact_info',
			'settings' 			=> 'country',
			'type' 				=> 'select'
		)
	);
	$wp_customize->get_setting( 'country' )->transport = 'postMessage';


	// US States Select Field
	$wp_customize->add_setting(
		'us_state',
		array(
			'default'  			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'us_state',
		array(
			'choices' => array(
				'AL' => esc_html__( 'Alabama', 'tcb-landing' ),
				'AK' => esc_html__( 'Alaska', 'tcb-landing' ),
				'AZ' => esc_html__( 'Arizona', 'tcb-landing' ),
				'AR' => esc_html__( 'Arkansas', 'tcb-landing' ),
				'CA' => esc_html__( 'California', 'tcb-landing' ),
				'CO' => esc_html__( 'Colorado', 'tcb-landing' ),
				'CT' => esc_html__( 'Connecticut', 'tcb-landing' ),
				'DE' => esc_html__( 'Delaware', 'tcb-landing' ),
				'DC' => esc_html__( 'District of Columbia', 'tcb-landing' ),
				'FL' => esc_html__( 'Florida', 'tcb-landing' ),
				'GA' => esc_html__( 'Georgia', 'tcb-landing' ),
				'HI' => esc_html__( 'Hawaii', 'tcb-landing' ),
				'ID' => esc_html__( 'Idaho', 'tcb-landing' ),
				'IL' => esc_html__( 'Illinois', 'tcb-landing' ),
				'IN' => esc_html__( 'Indiana', 'tcb-landing' ),
				'IA' => esc_html__( 'Iowa', 'tcb-landing' ),
				'KS' => esc_html__( 'Kansas', 'tcb-landing' ),
				'KY' => esc_html__( 'Kentucky', 'tcb-landing' ),
				'LA' => esc_html__( 'Louisiana', 'tcb-landing' ),
				'ME' => esc_html__( 'Maine', 'tcb-landing' ),
				'MD' => esc_html__( 'Maryland', 'tcb-landing' ),
				'MA' => esc_html__( 'Massachusetts', 'tcb-landing' ),
				'MI' => esc_html__( 'Michigan', 'tcb-landing' ),
				'MN' => esc_html__( 'Minnesota', 'tcb-landing' ),
				'MS' => esc_html__( 'Mississippi', 'tcb-landing' ),
				'MO' => esc_html__( 'Missouri', 'tcb-landing' ),
				'MT' => esc_html__( 'Montana', 'tcb-landing' ),
				'NE' => esc_html__( 'Nebraska', 'tcb-landing' ),
				'NV' => esc_html__( 'Nevada', 'tcb-landing' ),
				'NH' => esc_html__( 'New Hampshire', 'tcb-landing' ),
				'NJ' => esc_html__( 'New Jersey', 'tcb-landing' ),
				'NM' => esc_html__( 'New Mexico', 'tcb-landing' ),
				'NY' => esc_html__( 'New York', 'tcb-landing' ),
				'NC' => esc_html__( 'North Carolina', 'tcb-landing' ),
				'ND' => esc_html__( 'North Dakota', 'tcb-landing' ),
				'OH' => esc_html__( 'Ohio', 'tcb-landing' ),
				'OK' => esc_html__( 'Oklahoma', 'tcb-landing' ),
				'OR' => esc_html__( 'Oregon', 'tcb-landing' ),
				'PA' => esc_html__( 'Pennsylvania', 'tcb-landing' ),
				'RI' => esc_html__( 'Rhode Island', 'tcb-landing' ),
				'SC' => esc_html__( 'South Carolina', 'tcb-landing' ),
				'SD' => esc_html__( 'South Dakota', 'tcb-landing' ),
				'TN' => esc_html__( 'Tennessee', 'tcb-landing' ),
				'TX' => esc_html__( 'Texas', 'tcb-landing' ),
				'UT' => esc_html__( 'Utah', 'tcb-landing' ),
				'VT' => esc_html__( 'Vermont', 'tcb-landing' ),
				'VA' => esc_html__( 'Virginia', 'tcb-landing' ),
				'WA' => esc_html__( 'Washington', 'tcb-landing' ),
				'WV' => esc_html__( 'West Virginia', 'tcb-landing' ),
				'WI' => esc_html__( 'Wisconsin', 'tcb-landing' ),
				'WY' => esc_html__( 'Wyoming', 'tcb-landing' ),
				'AS' => esc_html__( 'American Samoa', 'tcb-landing' ),
				'AA' => esc_html__( 'Armed Forces America (except Canada)', 'tcb-landing' ),
				'AE' => esc_html__( 'Armed Forces Africa/Canada/Europe/Middle East', 'tcb-landing' ),
				'AP' => esc_html__( 'Armed Forces Pacific', 'tcb-landing' ),
				'FM' => esc_html__( 'Federated States of Micronesia', 'tcb-landing' ),
				'GU' => esc_html__( 'Guam', 'tcb-landing' ),
				'MH' => esc_html__( 'Marshall Islands', 'tcb-landing' ),
				'MP' => esc_html__( 'Northern Mariana Islands', 'tcb-landing' ),
				'PR' => esc_html__( 'Puerto Rico', 'tcb-landing' ),
				'PW' => esc_html__( 'Palau', 'tcb-landing' ),
				'VI' => esc_html__( 'Virgin Islands', 'tcb-landing' )
			),
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'State', 'tcb-landing' ),
			'priority' 			=> 230,
			'section' 			=> 'contact_info',
			'settings' 			=> 'us_state',
			'type' 				=> 'select'
		)
	);
	$wp_customize->get_setting( 'us_state' )->transport = 'postMessage';


	// Canadian States Select Field
	$wp_customize->add_setting(
		'canada_state',
		array(
			'default'  			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'canada_state',
		array(
			'choices' => array(
				'AB' => esc_html__( 'Alberta', 'tcb-landing' ),
				'BC' => esc_html__( 'British Columbia', 'tcb-landing' ),
				'MB' => esc_html__( 'Manitoba', 'tcb-landing' ),
				'NB' => esc_html__( 'New Brunswick', 'tcb-landing' ),
				'NL' => esc_html__( 'Newfoundland and Labrador', 'tcb-landing' ),
				'NT' => esc_html__( 'Northwest Territories', 'tcb-landing' ),
				'NS' => esc_html__( 'Nova Scotia', 'tcb-landing' ),
				'NU' => esc_html__( 'Nunavut', 'tcb-landing' ),
				'ON' => esc_html__( 'Ontario', 'tcb-landing' ),
				'PE' => esc_html__( 'Prince Edward Island', 'tcb-landing' ),
				'QC' => esc_html__( 'Quebec', 'tcb-landing' ),
				'SK' => esc_html__( 'Saskatchewan', 'tcb-landing' ),
				'YT' => esc_html__( 'Yukon', 'tcb-landing' )
			),
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'State', 'tcb-landing' ),
			'priority' 			=> 230,
			'section' 			=> 'contact_info',
			'settings' 			=> 'canada_state',
			'type' 				=> 'select'
		)
	);
	$wp_customize->get_setting( 'canada_state' )->transport = 'postMessage';


	// Australian States Select Field
	$wp_customize->add_setting(
		'australia_state',
		array(
			'default'  			=> '',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'australia_state',
		array(
			'choices' => array(
				'ACT' 	=> esc_html__( 'Australian Capital Territory', 'tcb-landing' ),
				'NSW' 	=> esc_html__( 'New South Wales', 'tcb-landing' ),
				'NT' 	=> esc_html__( 'Northern Territory', 'tcb-landing' ),
				'QLD' 	=> esc_html__( 'Queensland', 'tcb-landing' ),
				'SA' 	=> esc_html__( 'South Australia', 'tcb-landing' ),
				'TAS' 	=> esc_html__( 'Tasmania', 'tcb-landing' ),
				'VIC' 	=> esc_html__( 'Victoria', 'tcb-landing' ),
				'WA' 	=> esc_html__( 'Western Australia', 'tcb-landing' )
			),
			'description' 		=> esc_html__( '', 'tcb-landing' ),
			'label' 			=> esc_html__( 'State', 'tcb-landing' ),
			'priority' 			=> 230,
			'section' 			=> 'contact_info',
			'settings' 			=> 'australia_state',
			'type' 				=> 'select'
		)
	);
	$wp_customize->get_setting( 'australia_state' )->transport = 'postMessage';


	*/

} // function_names_register_fields()

/**
 * This will generate a line of CSS for use in header output. If the setting
 * ($mod_name) has no defined value, the CSS will not be output.
 *
 * @access 		public
 * @since 		1.0.0
 *
 * @param 		string 		$selector 		CSS selector
 * @param 		string 		$style 			The name of the CSS *property* to modify
 * @param 		string 		$mod_name 		The name of the 'theme_mod' option to fetch
 * @param 		string 		$prefix 		Optional. Anything that needs to be output before the CSS property
 * @param 		string 		$postfix 		Optional. Anything that needs to be output after the CSS property
 * @param 		bool 		$echo 			Optional. Whether to print directly to the page (default: true).
 *
 * @return 		string 						Returns a single line of CSS with selectors and a property.
 */
function function_names_generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

	$return = '';
	$mod 	= get_theme_mod( $mod_name );

	if ( ! empty( $mod ) ) {

		$return = sprintf('%s { %s:%s; }',
			$selector,
			$style,
			$prefix . $mod . $postfix
		);

		if ( $echo ) {

			echo $return;

		}

	}

	return $return;

} // function_names_generate_css()

/**
 * This will output the custom WordPress settings to the live theme's WP head.
 *
 * Used by hook: 'wp_head'
 *
 * @access 		public
 * @see 		add_action( 'wp_head', $func )
 * @since 		1.0.0
 */
function function_names_header_output() {

	?><!-- Customizer CSS -->
	<style type="text/css"><?php

		// pattern:
		// function_names_generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
		//
		// background-image example:
		// function_names_generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );


	?></style><!-- Customizer CSS --><?php

	/**
	 * Hides all but the first Soliloquy slide while using Customizer previewer.
	 */
	if ( is_customize_preview() ) {

		?><style type="text/css">

			li.soliloquy-item:not(:first-child) {
				display: none !important;
			}

		</style><!-- Customizer CSS --><?php

	}

} // function_names_header_output()

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Used by hook: 'customize_preview_init'
 *
 * @access 		public
 * @see 		add_action( 'customize_preview_init', $func )
 * @since 		1.0.0
 */
function function_names_live_preview() {

	wp_enqueue_script( 'function_names_customizer', get_template_directory_uri() . '/js/customizer.min.js', array( 'jquery', 'customize-preview' ), '', true );

} // function_names_live_preview()

/**
 * Used by customizer controls, mostly for active callbacks.
 *
 * @hook		customize_controls_enqueue_scripts
 *
 * @access 		public
 * @see 		add_action( 'customize_preview_init', $func )
 * @since 		1.0.0
 */
function function_names_control_scripts() {

	wp_enqueue_script( 'function_names_customizer_controls', get_template_directory_uri() . '/js/customizer-controls.min.js', array( 'jquery', 'customize-controls' ), false, true );

} // function_names_control_scripts()

/**
 * Returns TRUE based on which link type is selected, otherwise FALSE
 *
 * @param 	object 		$control 			The control object
 * @return 	bool 							TRUE if conditions are met, otherwise FALSE
 */
function function_names_states_of_country_callback( $control ) {

	$country_setting = $control->manager->get_setting('country')->value();

	//wp_die( print_r( $radio_setting ) );
	//wp_die( print_r( $control->id ) );

	if ( 'us_state' === $control->id && 'US' === $country_setting ) { return true; }
	if ( 'canada_state' === $control->id && 'CA' === $country_setting ) { return true; }
	if ( 'australia_state' === $control->id && 'AU' === $country_setting ) { return true; }
	if ( 'default_state' === $control->id && ! function_names_custom_countries( $country_setting ) ) { return true; }

	return false;

} // function_names_states_of_country_callback()

/**
 * Returns true if a country has a custom select menu
 *
 * @param 		string 		$country 			The country code to check
 *
 * @return 		bool 							TRUE if the code is in the array, FALSE otherwise
 */
function function_names_custom_countries( $country ) {

	$countries = array( 'US', 'CA', 'AU' );

	return in_array( $country, $countries );

} // function_names_custom_countries()


/**
 * Returns an array of countries or a country name.
 *
 * @param 		string 		$country 		Country code to return (optional)
 *
 * @return 		array|string 				Array of countries or a single country name
 */
function function_names_country_list( $country = '' ) {

	$countries = array();

	$countries['AF'] = esc_html__( 'Afghanistan (‫افغانستان‬‎)', 'tcb-landing' );
	$countries['AX'] = esc_html__( 'Åland Islands (Åland)', 'tcb-landing' );
	$countries['AL'] = esc_html__( 'Albania (Shqipëri)', 'tcb-landing' );
	$countries['DZ'] = esc_html__( 'Algeria (‫الجزائر‬‎)', 'tcb-landing' );
	$countries['AS'] = esc_html__( 'American Samoa', 'tcb-landing' );
	$countries['AD'] = esc_html__( 'Andorra', 'tcb-landing' );
	$countries['AO'] = esc_html__( 'Angola', 'tcb-landing' );
	$countries['AI'] = esc_html__( 'Anguilla', 'tcb-landing' );
	$countries['AQ'] = esc_html__( 'Antarctica', 'tcb-landing' );
	$countries['AG'] = esc_html__( 'Antigua and Barbuda', 'tcb-landing' );
	$countries['AR'] = esc_html__( 'Argentina', 'tcb-landing' );
	$countries['AM'] = esc_html__( 'Armenia (Հայաստան)', 'tcb-landing' );
	$countries['AW'] = esc_html__( 'Aruba', 'tcb-landing' );
	$countries['AC'] = esc_html__( 'Ascension Island', 'tcb-landing' );
	$countries['AU'] = esc_html__( 'Australia', 'tcb-landing' );
	$countries['AT'] = esc_html__( 'Austria (Österreich)', 'tcb-landing' );
	$countries['AZ'] = esc_html__( 'Azerbaijan (Azərbaycan)', 'tcb-landing' );
	$countries['BS'] = esc_html__( 'Bahamas', 'tcb-landing' );
	$countries['BH'] = esc_html__( 'Bahrain (‫البحرين‬‎)', 'tcb-landing' );
	$countries['BD'] = esc_html__( 'Bangladesh (বাংলাদেশ)', 'tcb-landing' );
	$countries['BB'] = esc_html__( 'Barbados', 'tcb-landing' );
	$countries['BY'] = esc_html__( 'Belarus (Беларусь)', 'tcb-landing' );
	$countries['BE'] = esc_html__( 'Belgium (België)', 'tcb-landing' );
	$countries['BZ'] = esc_html__( 'Belize', 'tcb-landing' );
	$countries['BJ'] = esc_html__( 'Benin (Bénin)', 'tcb-landing' );
	$countries['BM'] = esc_html__( 'Bermuda', 'tcb-landing' );
	$countries['BT'] = esc_html__( 'Bhutan (འབྲུག)', 'tcb-landing' );
	$countries['BO'] = esc_html__( 'Bolivia', 'tcb-landing' );
	$countries['BA'] = esc_html__( 'Bosnia and Herzegovina (Босна и Херцеговина)', 'tcb-landing' );
	$countries['BW'] = esc_html__( 'Botswana', 'tcb-landing' );
	$countries['BV'] = esc_html__( 'Bouvet Island', 'tcb-landing' );
	$countries['BR'] = esc_html__( 'Brazil (Brasil)', 'tcb-landing' );
	$countries['IO'] = esc_html__( 'British Indian Ocean Territory', 'tcb-landing' );
	$countries['VG'] = esc_html__( 'British Virgin Islands', 'tcb-landing' );
	$countries['BN'] = esc_html__( 'Brunei', 'tcb-landing' );
	$countries['BG'] = esc_html__( 'Bulgaria (България)', 'tcb-landing' );
	$countries['BF'] = esc_html__( 'Burkina Faso', 'tcb-landing' );
	$countries['BI'] = esc_html__( 'Burundi (Uburundi)', 'tcb-landing' );
	$countries['KH'] = esc_html__( 'Cambodia (កម្ពុជា)', 'tcb-landing' );
	$countries['CM'] = esc_html__( 'Cameroon (Cameroun)', 'tcb-landing' );
	$countries['CA'] = esc_html__( 'Canada', 'tcb-landing' );
	$countries['IC'] = esc_html__( 'Canary Islands (islas Canarias)', 'tcb-landing' );
	$countries['CV'] = esc_html__( 'Cape Verde (Kabu Verdi)', 'tcb-landing' );
	$countries['BQ'] = esc_html__( 'Caribbean Netherlands', 'tcb-landing' );
	$countries['KY'] = esc_html__( 'Cayman Islands', 'tcb-landing' );
	$countries['CF'] = esc_html__( 'Central African Republic (République centrafricaine)', 'tcb-landing' );
	$countries['EA'] = esc_html__( 'Ceuta and Melilla (Ceuta y Melilla)', 'tcb-landing' );
	$countries['TD'] = esc_html__( 'Chad (Tchad)', 'tcb-landing' );
	$countries['CL'] = esc_html__( 'Chile', 'tcb-landing' );
	$countries['CN'] = esc_html__( 'China (中国)', 'tcb-landing' );
	$countries['CX'] = esc_html__( 'Christmas Island', 'tcb-landing' );
	$countries['CP'] = esc_html__( 'Clipperton Island', 'tcb-landing' );
	$countries['CC'] = esc_html__( 'Cocos (Keeling) Islands (Kepulauan Cocos (Keeling))', 'tcb-landing' );
	$countries['CO'] = esc_html__( 'Colombia', 'tcb-landing' );
	$countries['KM'] = esc_html__( 'Comoros (‫جزر القمر‬‎)', 'tcb-landing' );
	$countries['CD'] = esc_html__( 'Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)', 'tcb-landing' );
	$countries['CG'] = esc_html__( 'Congo (Republic) (Congo-Brazzaville)', 'tcb-landing' );
	$countries['CK'] = esc_html__( 'Cook Islands', 'tcb-landing' );
	$countries['CR'] = esc_html__( 'Costa Rica', 'tcb-landing' );
	$countries['CI'] = esc_html__( 'Côte d’Ivoire', 'tcb-landing' );
	$countries['HR'] = esc_html__( 'Croatia (Hrvatska)', 'tcb-landing' );
	$countries['CU'] = esc_html__( 'Cuba', 'tcb-landing' );
	$countries['CW'] = esc_html__( 'Curaçao', 'tcb-landing' );
	$countries['CY'] = esc_html__( 'Cyprus (Κύπρος)', 'tcb-landing' );
	$countries['CZ'] = esc_html__( 'Czech Republic (Česká republika)', 'tcb-landing' );
	$countries['DK'] = esc_html__( 'Denmark (Danmark)', 'tcb-landing' );
	$countries['DG'] = esc_html__( 'Diego Garcia', 'tcb-landing' );
	$countries['DJ'] = esc_html__( 'Djibouti', 'tcb-landing' );
	$countries['DM'] = esc_html__( 'Dominica', 'tcb-landing' );
	$countries['DO'] = esc_html__( 'Dominican Republic (República Dominicana)', 'tcb-landing' );
	$countries['EC'] = esc_html__( 'Ecuador', 'tcb-landing' );
	$countries['EG'] = esc_html__( 'Egypt (‫مصر‬‎)', 'tcb-landing' );
	$countries['SV'] = esc_html__( 'El Salvador', 'tcb-landing' );
	$countries['GQ'] = esc_html__( 'Equatorial Guinea (Guinea Ecuatorial)', 'tcb-landing' );
	$countries['ER'] = esc_html__( 'Eritrea', 'tcb-landing' );
	$countries['EE'] = esc_html__( 'Estonia (Eesti)', 'tcb-landing' );
	$countries['ET'] = esc_html__( 'Ethiopia', 'tcb-landing' );
	$countries['FK'] = esc_html__( 'Falkland Islands (Islas Malvinas)', 'tcb-landing' );
	$countries['FO'] = esc_html__( 'Faroe Islands (Føroyar)', 'tcb-landing' );
	$countries['FJ'] = esc_html__( 'Fiji', 'tcb-landing' );
	$countries['FI'] = esc_html__( 'Finland (Suomi)', 'tcb-landing' );
	$countries['FR'] = esc_html__( 'France', 'tcb-landing' );
	$countries['GF'] = esc_html__( 'French Guiana (Guyane française)', 'tcb-landing' );
	$countries['PF'] = esc_html__( 'French Polynesia (Polynésie française)', 'tcb-landing' );
	$countries['TF'] = esc_html__( 'French Southern Territories (Terres australes françaises)', 'tcb-landing' );
	$countries['GA'] = esc_html__( 'Gabon', 'tcb-landing' );
	$countries['GM'] = esc_html__( 'Gambia', 'tcb-landing' );
	$countries['GE'] = esc_html__( 'Georgia (საქართველო)', 'tcb-landing' );
	$countries['DE'] = esc_html__( 'Germany (Deutschland)', 'tcb-landing' );
	$countries['GH'] = esc_html__( 'Ghana (Gaana)', 'tcb-landing' );
	$countries['GI'] = esc_html__( 'Gibraltar', 'tcb-landing' );
	$countries['GR'] = esc_html__( 'Greece (Ελλάδα)', 'tcb-landing' );
	$countries['GL'] = esc_html__( 'Greenland (Kalaallit Nunaat)', 'tcb-landing' );
	$countries['GD'] = esc_html__( 'Grenada', 'tcb-landing' );
	$countries['GP'] = esc_html__( 'Guadeloupe', 'tcb-landing' );
	$countries['GU'] = esc_html__( 'Guam', 'tcb-landing' );
	$countries['GT'] = esc_html__( 'Guatemala', 'tcb-landing' );
	$countries['GG'] = esc_html__( 'Guernsey', 'tcb-landing' );
	$countries['GN'] = esc_html__( 'Guinea (Guinée)', 'tcb-landing' );
	$countries['GW'] = esc_html__( 'Guinea-Bissau (Guiné Bissau)', 'tcb-landing' );
	$countries['GY'] = esc_html__( 'Guyana', 'tcb-landing' );
	$countries['HT'] = esc_html__( 'Haiti', 'tcb-landing' );
	$countries['HM'] = esc_html__( 'Heard & McDonald Islands', 'tcb-landing' );
	$countries['HN'] = esc_html__( 'Honduras', 'tcb-landing' );
	$countries['HK'] = esc_html__( 'Hong Kong (香港)', 'tcb-landing' );
	$countries['HU'] = esc_html__( 'Hungary (Magyarország)', 'tcb-landing' );
	$countries['IS'] = esc_html__( 'Iceland (Ísland)', 'tcb-landing' );
	$countries['IN'] = esc_html__( 'India (भारत)', 'tcb-landing' );
	$countries['ID'] = esc_html__( 'Indonesia', 'tcb-landing' );
	$countries['IR'] = esc_html__( 'Iran (‫ایران‬‎)', 'tcb-landing' );
	$countries['IQ'] = esc_html__( 'Iraq (‫العراق‬‎)', 'tcb-landing' );
	$countries['IE'] = esc_html__( 'Ireland', 'tcb-landing' );
	$countries['IM'] = esc_html__( 'Isle of Man', 'tcb-landing' );
	$countries['IL'] = esc_html__( 'Israel (‫ישראל‬‎)', 'tcb-landing' );
	$countries['IT'] = esc_html__( 'Italy (Italia)', 'tcb-landing' );
	$countries['JM'] = esc_html__( 'Jamaica', 'tcb-landing' );
	$countries['JP'] = esc_html__( 'Japan (日本)', 'tcb-landing' );
	$countries['JE'] = esc_html__( 'Jersey', 'tcb-landing' );
	$countries['JO'] = esc_html__( 'Jordan (‫الأردن‬‎)', 'tcb-landing' );
	$countries['KZ'] = esc_html__( 'Kazakhstan (Казахстан)', 'tcb-landing' );
	$countries['KE'] = esc_html__( 'Kenya', 'tcb-landing' );
	$countries['KI'] = esc_html__( 'Kiribati', 'tcb-landing' );
	$countries['XK'] = esc_html__( 'Kosovo (Kosovë)', 'tcb-landing' );
	$countries['KW'] = esc_html__( 'Kuwait (‫الكويت‬‎)', 'tcb-landing' );
	$countries['KG'] = esc_html__( 'Kyrgyzstan (Кыргызстан)', 'tcb-landing' );
	$countries['LA'] = esc_html__( 'Laos (ລາວ)', 'tcb-landing' );
	$countries['LV'] = esc_html__( 'Latvia (Latvija)', 'tcb-landing' );
	$countries['LB'] = esc_html__( 'Lebanon (‫لبنان‬‎)', 'tcb-landing' );
	$countries['LS'] = esc_html__( 'Lesotho', 'tcb-landing' );
	$countries['LR'] = esc_html__( 'Liberia', 'tcb-landing' );
	$countries['LY'] = esc_html__( 'Libya (‫ليبيا‬‎)', 'tcb-landing' );
	$countries['LI'] = esc_html__( 'Liechtenstein', 'tcb-landing' );
	$countries['LT'] = esc_html__( 'Lithuania (Lietuva)', 'tcb-landing' );
	$countries['LU'] = esc_html__( 'Luxembourg', 'tcb-landing' );
	$countries['MO'] = esc_html__( 'Macau (澳門)', 'tcb-landing' );
	$countries['MK'] = esc_html__( 'Macedonia (FYROM) (Македонија)', 'tcb-landing' );
	$countries['MG'] = esc_html__( 'Madagascar (Madagasikara)', 'tcb-landing' );
	$countries['MW'] = esc_html__( 'Malawi', 'tcb-landing' );
	$countries['MY'] = esc_html__( 'Malaysia', 'tcb-landing' );
	$countries['MV'] = esc_html__( 'Maldives', 'tcb-landing' );
	$countries['ML'] = esc_html__( 'Mali', 'tcb-landing' );
	$countries['MT'] = esc_html__( 'Malta', 'tcb-landing' );
	$countries['MH'] = esc_html__( 'Marshall Islands', 'tcb-landing' );
	$countries['MQ'] = esc_html__( 'Martinique', 'tcb-landing' );
	$countries['MR'] = esc_html__( 'Mauritania (‫موريتانيا‬‎)', 'tcb-landing' );
	$countries['MU'] = esc_html__( 'Mauritius (Moris)', 'tcb-landing' );
	$countries['YT'] = esc_html__( 'Mayotte', 'tcb-landing' );
	$countries['MX'] = esc_html__( 'Mexico (México)', 'tcb-landing' );
	$countries['FM'] = esc_html__( 'Micronesia', 'tcb-landing' );
	$countries['MD'] = esc_html__( 'Moldova (Republica Moldova)', 'tcb-landing' );
	$countries['MC'] = esc_html__( 'Monaco', 'tcb-landing' );
	$countries['MN'] = esc_html__( 'Mongolia (Монгол)', 'tcb-landing' );
	$countries['ME'] = esc_html__( 'Montenegro (Crna Gora)', 'tcb-landing' );
	$countries['MS'] = esc_html__( 'Montserrat', 'tcb-landing' );
	$countries['MA'] = esc_html__( 'Morocco (‫المغرب‬‎)', 'tcb-landing' );
	$countries['MZ'] = esc_html__( 'Mozambique (Moçambique)', 'tcb-landing' );
	$countries['MM'] = esc_html__( 'Myanmar (Burma) (မြန်မာ)', 'tcb-landing' );
	$countries['NA'] = esc_html__( 'Namibia (Namibië)', 'tcb-landing' );
	$countries['NR'] = esc_html__( 'Nauru', 'tcb-landing' );
	$countries['NP'] = esc_html__( 'Nepal (नेपाल)', 'tcb-landing' );
	$countries['NL'] = esc_html__( 'Netherlands (Nederland)', 'tcb-landing' );
	$countries['NC'] = esc_html__( 'New Caledonia (Nouvelle-Calédonie)', 'tcb-landing' );
	$countries['NZ'] = esc_html__( 'New Zealand', 'tcb-landing' );
	$countries['NI'] = esc_html__( 'Nicaragua', 'tcb-landing' );
	$countries['NE'] = esc_html__( 'Niger (Nijar)', 'tcb-landing' );
	$countries['NG'] = esc_html__( 'Nigeria', 'tcb-landing' );
	$countries['NU'] = esc_html__( 'Niue', 'tcb-landing' );
	$countries['NF'] = esc_html__( 'Norfolk Island', 'tcb-landing' );
	$countries['MP'] = esc_html__( 'Northern Mariana Islands', 'tcb-landing' );
	$countries['KP'] = esc_html__( 'North Korea (조선 민주주의 인민 공화국)', 'tcb-landing' );
	$countries['NO'] = esc_html__( 'Norway (Norge)', 'tcb-landing' );
	$countries['OM'] = esc_html__( 'Oman (‫عُمان‬‎)', 'tcb-landing' );
	$countries['PK'] = esc_html__( 'Pakistan (‫پاکستان‬‎)', 'tcb-landing' );
	$countries['PW'] = esc_html__( 'Palau', 'tcb-landing' );
	$countries['PS'] = esc_html__( 'Palestine (‫فلسطين‬‎)', 'tcb-landing' );
	$countries['PA'] = esc_html__( 'Panama (Panamá)', 'tcb-landing' );
	$countries['PG'] = esc_html__( 'Papua New Guinea', 'tcb-landing' );
	$countries['PY'] = esc_html__( 'Paraguay', 'tcb-landing' );
	$countries['PE'] = esc_html__( 'Peru (Perú)', 'tcb-landing' );
	$countries['PH'] = esc_html__( 'Philippines', 'tcb-landing' );
	$countries['PN'] = esc_html__( 'Pitcairn Islands', 'tcb-landing' );
	$countries['PL'] = esc_html__( 'Poland (Polska)', 'tcb-landing' );
	$countries['PT'] = esc_html__( 'Portugal', 'tcb-landing' );
	$countries['PR'] = esc_html__( 'Puerto Rico', 'tcb-landing' );
	$countries['QA'] = esc_html__( 'Qatar (‫قطر‬‎)', 'tcb-landing' );
	$countries['RE'] = esc_html__( 'Réunion (La Réunion)', 'tcb-landing' );
	$countries['RO'] = esc_html__( 'Romania (România)', 'tcb-landing' );
	$countries['RU'] = esc_html__( 'Russia (Россия)', 'tcb-landing' );
	$countries['RW'] = esc_html__( 'Rwanda', 'tcb-landing' );
	$countries['BL'] = esc_html__( 'Saint Barthélemy (Saint-Barthélemy)', 'tcb-landing' );
	$countries['SH'] = esc_html__( 'Saint Helena', 'tcb-landing' );
	$countries['KN'] = esc_html__( 'Saint Kitts and Nevis', 'tcb-landing' );
	$countries['LC'] = esc_html__( 'Saint Lucia', 'tcb-landing' );
	$countries['MF'] = esc_html__( 'Saint Martin (Saint-Martin (partie française))', 'tcb-landing' );
	$countries['PM'] = esc_html__( 'Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)', 'tcb-landing' );
	$countries['WS'] = esc_html__( 'Samoa', 'tcb-landing' );
	$countries['SM'] = esc_html__( 'San Marino', 'tcb-landing' );
	$countries['ST'] = esc_html__( 'São Tomé and Príncipe (São Tomé e Príncipe)', 'tcb-landing' );
	$countries['SA'] = esc_html__( 'Saudi Arabia (‫المملكة العربية السعودية‬‎)', 'tcb-landing' );
	$countries['SN'] = esc_html__( 'Senegal (Sénégal)', 'tcb-landing' );
	$countries['RS'] = esc_html__( 'Serbia (Србија)', 'tcb-landing' );
	$countries['SC'] = esc_html__( 'Seychelles', 'tcb-landing' );
	$countries['SL'] = esc_html__( 'Sierra Leone', 'tcb-landing' );
	$countries['SG'] = esc_html__( 'Singapore', 'tcb-landing' );
	$countries['SX'] = esc_html__( 'Sint Maarten', 'tcb-landing' );
	$countries['SK'] = esc_html__( 'Slovakia (Slovensko)', 'tcb-landing' );
	$countries['SI'] = esc_html__( 'Slovenia (Slovenija)', 'tcb-landing' );
	$countries['SB'] = esc_html__( 'Solomon Islands', 'tcb-landing' );
	$countries['SO'] = esc_html__( 'Somalia (Soomaaliya)', 'tcb-landing' );
	$countries['ZA'] = esc_html__( 'South Africa', 'tcb-landing' );
	$countries['GS'] = esc_html__( 'South Georgia & South Sandwich Islands', 'tcb-landing' );
	$countries['KR'] = esc_html__( 'South Korea (대한민국)', 'tcb-landing' );
	$countries['SS'] = esc_html__( 'South Sudan (‫جنوب السودان‬‎)', 'tcb-landing' );
	$countries['ES'] = esc_html__( 'Spain (España)', 'tcb-landing' );
	$countries['LK'] = esc_html__( 'Sri Lanka (ශ්‍රී ලංකාව)', 'tcb-landing' );
	$countries['VC'] = esc_html__( 'St. Vincent & Grenadines', 'tcb-landing' );
	$countries['SD'] = esc_html__( 'Sudan (‫السودان‬‎)', 'tcb-landing' );
	$countries['SR'] = esc_html__( 'Suriname', 'tcb-landing' );
	$countries['SJ'] = esc_html__( 'Svalbard and Jan Mayen (Svalbard og Jan Mayen)', 'tcb-landing' );
	$countries['SZ'] = esc_html__( 'Swaziland', 'tcb-landing' );
	$countries['SE'] = esc_html__( 'Sweden (Sverige)', 'tcb-landing' );
	$countries['CH'] = esc_html__( 'Switzerland (Schweiz)', 'tcb-landing' );
	$countries['SY'] = esc_html__( 'Syria (‫سوريا‬‎)', 'tcb-landing' );
	$countries['TW'] = esc_html__( 'Taiwan (台灣)', 'tcb-landing' );
	$countries['TJ'] = esc_html__( 'Tajikistan', 'tcb-landing' );
	$countries['TZ'] = esc_html__( 'Tanzania', 'tcb-landing' );
	$countries['TH'] = esc_html__( 'Thailand (ไทย)', 'tcb-landing' );
	$countries['TL'] = esc_html__( 'Timor-Leste', 'tcb-landing' );
	$countries['TG'] = esc_html__( 'Togo', 'tcb-landing' );
	$countries['TK'] = esc_html__( 'Tokelau', 'tcb-landing' );
	$countries['TO'] = esc_html__( 'Tonga', 'tcb-landing' );
	$countries['TT'] = esc_html__( 'Trinidad and Tobago', 'tcb-landing' );
	$countries['TA'] = esc_html__( 'Tristan da Cunha', 'tcb-landing' );
	$countries['TN'] = esc_html__( 'Tunisia (‫تونس‬‎)', 'tcb-landing' );
	$countries['TR'] = esc_html__( 'Turkey (Türkiye)', 'tcb-landing' );
	$countries['TM'] = esc_html__( 'Turkmenistan', 'tcb-landing' );
	$countries['TC'] = esc_html__( 'Turks and Caicos Islands', 'tcb-landing' );
	$countries['TV'] = esc_html__( 'Tuvalu', 'tcb-landing' );
	$countries['UM'] = esc_html__( 'U.S. Outlying Islands', 'tcb-landing' );
	$countries['VI'] = esc_html__( 'U.S. Virgin Islands', 'tcb-landing' );
	$countries['UG'] = esc_html__( 'Uganda', 'tcb-landing' );
	$countries['UA'] = esc_html__( 'Ukraine (Україна)', 'tcb-landing' );
	$countries['AE'] = esc_html__( 'United Arab Emirates (‫الإمارات العربية المتحدة‬‎)', 'tcb-landing' );
	$countries['GB'] = esc_html__( 'United Kingdom', 'tcb-landing' );
	$countries['US'] = esc_html__( 'United States', 'tcb-landing' );
	$countries['UY'] = esc_html__( 'Uruguay', 'tcb-landing' );
	$countries['UZ'] = esc_html__( 'Uzbekistan (Oʻzbekiston)', 'tcb-landing' );
	$countries['VU'] = esc_html__( 'Vanuatu', 'tcb-landing' );
	$countries['VA'] = esc_html__( 'Vatican City (Città del Vaticano)', 'tcb-landing' );
	$countries['VE'] = esc_html__( 'Venezuela', 'tcb-landing' );
	$countries['VN'] = esc_html__( 'Vietnam (Việt Nam)', 'tcb-landing' );
	$countries['WF'] = esc_html__( 'Wallis and Futuna', 'tcb-landing' );
	$countries['EH'] = esc_html__( 'Western Sahara (‫الصحراء الغربية‬‎)', 'tcb-landing' );
	$countries['YE'] = esc_html__( 'Yemen (‫اليمن‬‎)', 'tcb-landing' );
	$countries['ZM'] = esc_html__( 'Zambia', 'tcb-landing' );
	$countries['ZW'] = esc_html__( 'Zimbabwe', 'tcb-landing' );

	if ( ! empty( $country ) ) {

		return $countries[$country];

	}

	return $countries;

} // function_names_country_list()

