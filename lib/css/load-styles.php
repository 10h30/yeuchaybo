<?php
/**
 * Child Theme Library
 *
 * WARNING: This file is a part of the core Child Theme Library.
 * DO NOT edit this file under any circumstances. Please use
 * the functions.php file to make any theme modifications.
 *
 * @package   SEOThemes\ChildThemeLibrary\CSS
 * @link      https://github.com/seothemes/child-theme-library
 * @author    Thuan Bui
 * @copyright Copyright © 2018 Thuan Bui
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {

	die;

}

add_action( 'wp_enqueue_scripts', 'child_theme_load_styles', 99 );
/**
 * Enqueue theme styles.
 *
 * @since  1.0.0
 *
 * @return void
 */
function child_theme_load_styles() {

	$config = child_theme_get_config();

	foreach ( $config['styles'] as $style => $params ) {

		wp_enqueue_style( 'child-theme-' . $style, $params['src'], $params['deps'], $params['ver'], $params['media'] );

	}

	foreach ( $config['google-fonts'] as $google_font ) {

		$google_fonts[] = $google_font;

	}

	wp_enqueue_style( 'child-theme-google-fonts', '//fonts.googleapis.com/css?family=' . implode( '|', $google_fonts ), array(), CHILD_THEME_VERSION );

	add_filter( 'genesis_portfolio_load_default_styles', '__return_false' );

}
