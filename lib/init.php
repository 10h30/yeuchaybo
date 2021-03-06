<?php
/**
 * Child Theme Library
 *
 * WARNING: This file is a part of the core Child Theme Library.
 * DO NOT edit this file under any circumstances. Please use
 * the functions.php file to make any theme modifications.
 *
 * @package   SEOThemes\ChildThemeLibrary
 * @link      https://github.com/seothemes/child-theme-library
 * @author    Thuan Bui
 * @copyright Copyright © 2018 Thuan Bui
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {

	die;

}

add_action( 'genesis_setup', 'child_theme_init', 5 );
/**
 * Initializes the child theme library.
 *
 * @since  1.0.0
 *
 * @throws Exception If too many files are loaded.
 *
 * @return void
 */
function child_theme_init() {

	$child_theme = wp_get_theme();

	define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
	define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );
	define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );
	define( 'CHILD_THEME_HANDLE', $child_theme->get( 'TextDomain' ) );
	define( 'CHILD_THEME_AUTHOR', $child_theme->get( 'Author' ) );
	define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
	define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );
	define( 'CHILD_THEME_LIB', CHILD_THEME_DIR . '/lib' );
	define( 'CHILD_THEME_VIEWS', CHILD_THEME_LIB . '/views' );
	define( 'CHILD_THEME_VENDOR', CHILD_THEME_DIR . '/vendor' );
	define( 'CHILD_THEME_ASSETS', CHILD_THEME_URI . '/assets' );
	define( 'CHILD_THEME_CONFIG', CHILD_THEME_DIR . '/config/config.php' );

	$config = require apply_filters( 'child_theme_config', CHILD_THEME_CONFIG );

	require_once CHILD_THEME_LIB . '/autoload.php';

	foreach ( $config['autoload'] as $dir ) {

		child_theme_autoload_dir( CHILD_THEME_DIR . $dir );

	}

}
