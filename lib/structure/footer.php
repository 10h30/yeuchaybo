<?php
/**
 * Child Theme Library
 *
 * WARNING: This file is a part of the core Child Theme Library.
 * DO NOT edit this file under any circumstances. Please use
 * the functions.php file to make any theme modifications.
 *
 * @package   SEOThemes\ChildThemeLibrary\Structure
 * @link      https://github.com/seothemes/child-theme-library
 * @author    Thuan Bui
 * @copyright Copyright © 2018 Thuan Bui
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {

	die;

}

add_action( 'genesis_setup', 'child_theme_reposition_footer_widgets' );
/**
 * Reposition footer widgets inside site footer.
 *
 * @since  1.0.0
 *
 * @return void
 */
function child_theme_reposition_footer_widgets() {

	remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
	add_action( 'genesis_before_footer_wrap', 'genesis_footer_widget_areas', 5 );

}