<?php
/**
 * Yeu Chay Bo v6.0
 *
 * This file contains the core functionality for this child theme.
 *
 * @package   SEOThemes\GenesisStarterTheme
 * @link      https://thuanbui.me/yeuchaybo
 * @author    Thuan Bui
 * @copyright Copyright © 2018 Thuan Bui
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {

	die;

}

// Load Child Theme Library (do not remove).
require_once get_stylesheet_directory() . '/lib/init.php';

/*
|--------------------------------------------------------------------------
| Place any custom code below this line.
|--------------------------------------------------------------------------
*/
// Sets the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 1000; // Pixels.
}

add_filter( 'displayfeaturedimagegenesis_disable', 'prefix_skip_woo_terms' );
function prefix_skip_woo_terms( $disable ) {
	if ( is_singular( 'post' ) ) {
		return true;
	}
	return $disable;
}

add_filter( 'display_featured_image_genesis_do_not_move_titles', 'yeuchaybo_move_title' );
function yeuchaybo_move_title($post_types) {
	$post_types[] = 'event';
	$post_types[] = 'post';
	return $post_types;
}

add_action( 'genesis_meta', 'essence_page_hero_header' );
/**
 * Relocates page titles and adds header image wrapper.
 *
 * @since 1.0.0
 */
function essence_page_hero_header() {

	if ( !('post' == get_post_type()) ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	}
}

// Adds the grid layout.
require_once get_stylesheet_directory() . '/lib/layout/grid-layout.php';



add_filter( 'genesis_post_info', 'yeuchaybo_modify_post_info' );
/**
 * Modifies the meta information in the entry header.
 *
 * @since 1.0.0
 *
 * @param string $post_info Current post info.
 * @return string New post info.
 */
function yeuchaybo_modify_post_info( $post_info ) {

	$post_info = 'đăng ngày [post_date]';

	return $post_info;

}


add_filter('display_featured_image_genesis_css_file', 'no_css');
function no_css($url) {
	$url = '';
	return $url;
}


add_action( 'genesis_before', 'your_prefix_embed_shortcode_archive_intro_text_support' );
/** 
 * Add oEmbed and Shortcode support Genesis archive description
 */
function your_prefix_embed_shortcode_archive_intro_text_support() {
	global $wp_embed;
	// Allow shortcodes and embeds on Genesis Archive Intro Text Tags and Categories
	if ( is_category() || is_tag() || is_tax() ) :
		
		add_filter( 'genesis_term_intro_text_output', array( $wp_embed, 'autoembed' ) );
		add_filter( 'genesis_term_intro_text_output', 'do_shortcode' );
	endif;
	
	// Allow shortcodes and embeds on CPT archive descriptions
	if ( is_post_type_archive() && genesis_has_post_type_archive_support() ) :
		
		add_filter( 'genesis_cpt_archive_intro_text_output', array( $wp_embed, 'autoembed') );
		add_filter( 'genesis_cpt_archive_intro_text_output', 'do_shortcode' );
	endif;
	// Allow shortcodes and embeds on Genesis Author Intro Text
	if ( is_author() ) :
		
		add_filter( 'genesis_author_intro_text_output', array( $wp_embed, 'autoembed') );
		add_filter( 'genesis_author_intro_text_output', 'do_shortcode' );
	endif;
		
}
