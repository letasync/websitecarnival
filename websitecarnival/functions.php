<?php

define( 'WEBSITECARNIVAL_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'WEBSITECARNIVAL_THEME_NAME', wp_get_theme()->get( 'Name' ) );
define( 'WEBSITECARNIVAL_URI', wp_get_theme()->get( 'ThemeURI' ) );
define( 'WEBSITECARNIVAL_TEMPLATE_DIR', get_template_directory() );
define( 'WEBSITECARNIVAL_TEMPLATE_DIR_URI', get_template_directory_uri() );

if ( ! function_exists( 'ktfc_support' ) ) {
	function ktfc_support()  {

		// Add language support for international translation.
		load_theme_textdomain( 'websitecarnival', WEBSITECARNIVAL_TEMPLATE_DIR . '/languages' );

		// Add support for featured images.
		add_theme_support( 'post-thumbnails' );

		// Add support for core block visual styles variation.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

	}
}
add_action( 'after_setup_theme', 'ktfc_support' );

// Include files from inc folder

require get_template_directory() . '/inc/ktwc-margin-padding-option.php';
require get_template_directory() . '/inc/styles.php';


// Register patterns
// require get_template_directory() . '/inc/patterns.php';





/**
 * Enqueue scripts and styles.
 */
function ktfc_scripts_styles() {

	wp_enqueue_style( 'ktfc-google-fonts', ktfc_google_fonts(), array(), null );
	wp_enqueue_style( 'frontend-only-style', WEBSITECARNIVAL_TEMPLATE_DIR_URI . '/assets/frontend-only-style.css', array(), WEBSITECARNIVAL_VERSION );

    wp_enqueue_style( 'additional-style', WEBSITECARNIVAL_TEMPLATE_DIR_URI . '/style.css', array(), WEBSITECARNIVAL_VERSION );

}
add_action( 'wp_enqueue_scripts', 'ktfc_scripts_styles' );


/**
 * Enqueue editor styles.
 */
function ktfc_editor_styles() {

	add_editor_style( array( 'style.css', ktfc_google_fonts() ) );

}
add_action( 'admin_init', 'ktfc_editor_styles' );




/**
 * Google fonts.
 */
function ktfc_google_fonts() {

	/**
	 * Note: although Alara requires 5.9, child themes could still be 5.8 with Gutenberg
	 */
	if ( version_compare( get_bloginfo( 'version' ), '5.9', '<' ) ) {
		$resolver_class = 'WP_Theme_JSON_Resolver_Gutenberg';
	} else {
		$resolver_class = 'WP_Theme_JSON_Resolver';
	}

	if ( !class_exists( $resolver_class ) ) {
		return '';
	}

	$global_styles = $resolver_class::get_merged_data()->get_settings();

	if ( empty( $global_styles['typography']['fontFamilies'] ) ) {
		return '';
	}

	$theme_fonts = ! empty( $global_styles['typography']['fontFamilies']['theme'] ) ? $global_styles['typography']['fontFamilies']['theme'] : array();

	$user_fonts = ! empty( $global_styles['typography']['fontFamilies']['user'] ) ? $global_styles['typography']['fontFamilies']['user'] : array();

	$fonts = array_merge( $theme_fonts, $user_fonts );

	if ( !$fonts ) {
		return '';
	}

	$font_vars = array();

	foreach ( $fonts as $font ) {
		if ( !empty( $font['google'] ) ) {
			$font_vars[] = $font['google'];
		}
	}

	if ( !$font_vars ) {
		return '';
	}

	return esc_url_raw( 'https://fonts.googleapis.com/css2?' . implode( '&', $font_vars ) . '&display=swap' );

}

