<?php
/**
 * This file adds the grid layout for the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_action( 'init' , 'wps_create_initial_layouts' );
/**
 * Registers Genesis custom post type default layouts.
 *
 */
function wps_create_initial_layouts() {

    // Registers the grid layout for category archives.
	/*genesis_register_layout( 'yeuchaybo-grid-2', array(
		'label' => __( 'Two-column Grid', 'child-theme-library'  ),
		'img'   => get_stylesheet_directory_uri() . '/images/grid2.gif',
    ) );
    genesis_register_layout( 'yeuchaybo-grid-3', array(
		'label' => __( 'Three-column Grid', 'child-theme-library'  ),
		'img'   => get_stylesheet_directory_uri() . '/images/grid3.gif',
	) );*/

	// Removes the default post image.
	remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
	add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );


	// Moves the archive description boxes.
    remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
    remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
    remove_action( 'genesis_before_loop', 'genesis_do_author_box_archive', 15 );
    remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
    remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
    remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
    remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
    add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_taxonomy_title_description', 20 );
    add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_author_title_description' , 20);
    add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_author_box_archive' , 20);
    add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_cpt_archive_title_description', 20 );
    add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_date_archive_title', 20 );
    add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_blog_template_heading' ,20);
    add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_posts_page_heading' , 20);

}

add_action( 'genesis_meta', 'yeuchaybo_grid_layout' );
/**
 * Sets up the grid layout.
 *
 * @since 1.0.0
 */
function yeuchaybo_grid_layout() {

	$site_layout = genesis_site_layout();

	if ( 'yeuchaybo-grid-2' === $site_layout || 'yeuchaybo-grid-3' === $site_layout) {
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
		remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
		//add_filter( 'genesis_skip_links_output', 'yeuchaybo_grid_skip_links_output' );
		//add_filter( 'genesis_pre_get_option_content_archive_limit', 'yeuchaybo_grid_archive_limit' );
		//add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'yeuchaybo_grid_archive_thumbnail' );
		//add_filter( 'genesis_pre_get_option_content_archive', 'yeuchaybo_grid_content_archive' );
		//add_filter( 'genesis_pre_get_option_image_size', 'yeuchaybo_grid_image_size' );
		//add_filter( 'genesis_pre_get_option_image_alignment', 'yeuchaybo_grid_image_alignment' );
	}

}

add_filter( 'genesis_pre_get_option_site_layout', 'yeuchaybo_grid_category_layout' );
/**
 * Sets the default layout for category and tag archive pages.
 *
 * @since 1.0.0
 *
 * @param string $layout The current layout.
 * @return string The new layout.
 */
function yeuchaybo_grid_category_layout( $layout ) {

	if ( is_category() || is_tag() )  {
		$layout = 'yeuchaybo-grid-2';
    }
    if  ( is_home() && !is_front_page() ) {
        $layout = 'yeuchaybo-grid-3';
    }

    if  ( is_singular('page') ) {
        $layout = 'content-sidebar';
    }

	return $layout;

}
