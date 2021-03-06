<?php

//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
//remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
//remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
//add_action( 'display_featured_image_genesis_after_title', 'ycb_event_date_location' );


// Add id="content" attributes to <main> element
add_filter( 'genesis_attr_entry-content', 'my_attr_content' );
function my_attr_content( $attr ) {
    $attr['id'] .= 'content';
    return $attr;
}


//add_action( 'genesis_entry_header', 'ycb_event_meta', 5);
//add_action( 'genesis_entry_header', 'ycb_event_register_button', 10);

function ycb_event_meta() {
    
    global $post;
	$EM_Event = em_get_event($post->ID, 'post_id');
	       
    echo '<div class="event-meta">';
	
	$event_start_date = get_post_meta( get_the_ID(), _event_start_date ,true);
       
    if ( $event_start_date  ) {
        $format_in = 'Y-m-d'; // the format your value is saved in (set in the field options)
        $format_out = 'd/m/Y'; // the format you want to end up with

        $event_start_date = DateTime::createFromFormat($format_in, $event_start_date);
        echo '<span class="event-start-date">'.   $event_start_date->format( $format_out ) .'</span>';
    }
	echo ' | <span class="event-location">';
	echo $EM_Event->output('#_LOCATIONTOWN');
	echo '</span>
	</div>';
}

function ycb_event_register_button() {
	$register_link = get_post_meta( get_the_ID(), event_register_link ,true);
	//echo '<div class="event-button"><a class="button" href="#content">Chi tiết</a>';
	if ( $register_link ){
		echo '<a class="button register" href="'. $register_link .'">Đăng Ký</a>';
	}
	//echo '</div>';
}

//* Reposition Breadcrumbs
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_entry', 'genesis_do_breadcrumbs', 9 );

//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Remove the author box on single posts HTML5 Themes
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );


/**
 * Display Featured Image floated to the right in single Posts.
 *
 * @author Sridhar Katakam
 * @link   http://sridharkatakam.com/how-to-display-featured-image-in-single-posts-in-genesis/
 */
function ycb_event_image() {

	$image_args = array(
		'size' => 'full',
	);
	echo '<figure class="wp-block-image alignwide">';
	genesis_image( $image_args );
	echo '</figure>';
}

function ycb_event_distance() {
	 $product_terms = get_the_terms( get_the_ID(), 'distance' );
		// Make sure we have terms and also check for WP_Error object
		if (  $product_terms && !is_wp_error( $product_terms )) {
			// Display your terms as normal
			$term_list = [];
			foreach ( $product_terms as $term ) 
			$term_list[] = esc_html( $term->name );
			echo implode( ', ', $term_list );
		}
}

function ycb_event_organizer() {
	$event_organizer = get_the_terms( get_the_ID(), 'organizer' );
	$event_organizer_list = [];
	foreach ( $event_organizer as $term ) 
	$event_organizer_list[] = esc_html( $term->name );
	$event_organizer = implode( ', ', $event_organizer_list );
	echo $event_organizer;
}

function ycb_display_event_organizer() {
	echo '<h2>Ban tổ chức</h2>';
	ycb_event_organizer();
}
add_action( 'genesis_entry_content', 'ycb_event_info', 4 );
add_action( 'genesis_entry_content', 'ycb_display_event_organizer', 10);
add_action( 'genesis_entry_content', 'ycb_event_image', 4 );

//add_action( 'genesis_entry_content', 'ycb_event_image',4);
//add_action( 'genesis_entry_content', 'ycb_event_distance',5);

function ycb_event_info() {
		global $post;
		$EM_Event = em_get_event($post->ID, 'post_id');
	
		$event_website = get_post_meta( get_the_ID(), event_website ,true);
		$event_title   = get_the_title();
		$register_link = get_post_meta( get_the_ID(), event_register_link ,true);
		$event_facebook = get_post_meta( get_the_ID(), event_facebook_page,true);

		echo '<div class="event-info-wrapper alignwide">';
		// Echo the event info on the left side
		echo '<div class="event-left">';

			 /* echo '<p>';
			  if ($event_website) {
				  echo '<a href="'. $event_website . '" target="_blank"><ion-icon name="home"></ion-icon></a>';
			  }
			  if ($event_facebook) {
				  echo '<a href="'. $event_facebook . '" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>';
			  }
			  echo '</p>';*/

			  echo '<p><strong>Tên giải: </strong>';
		echo '<a href="'.$event_website.'" target="_blank" class="eventsitelink">
		      <span class="summary">'.$event_title.'</span></a></p>';

		echo '<p><strong>Cự ly: </strong>';
		//echo do_shortcode('[post_terms taxonomy="distance" before=""]').'</p>';
		ycb_event_distance();
		echo '</p>';

		echo '<p><strong>Phân loại: </strong>';
		echo do_shortcode('[post_terms taxonomy="event_category" before=""]').'</p>';
		echo '</p>';

		echo '<p><strong>Thời gian: </strong>';
		echo $EM_Event->output('#_EVENTDATES').'</p>';

		if (!empty($EM_Event->location_id) && $EM_Event->get_location()->location_status) {
			echo '<p><strong>Địa điểm: </strong>';
						//echo $EM_Event->output('#_LOCATIONLINK');
			echo '<span>'. $EM_Event->output('#_LOCATIONADDRESS') . '</span>, ';
			echo $EM_Event->output('#_LOCATIONTOWN') . ', <span>';
			echo $EM_Event->output('#_LOCATIONCOUNTRY') . '</span></p>';
		}
	
		echo '</div>';

		// Echo the event map on the right side

		/*echo '<div class="event-map">';
		echo $EM_Event->output('#_LOCATIONMAP');
		echo '</div>';*/
		echo '<div class="event-right">';
		/*if ($event_facebook) {	
			echo '<div class="event-facebook">';
			echo do_shortcode('[sfp-page-plugin url="' . $event_facebook .'"]');
			echo '</div></div>';
		}*/
		echo '<div class="event-map">';
		echo $EM_Event->output('#_LOCATIONMAP');
		echo '</div>';
		echo '</div></div>';
		
}

//* Add custom body class to the head
add_filter( 'body_class', 'event_body_class' );
function event_body_class( $classes ) {
	if ( has_post_thumbnail()) {
		$classes[] = 'single-event-media';
	}	
		return $classes;
}

// Display new sidebar for Event
//add_action('get_header','cd_change_genesis_sidebar');
function cd_change_genesis_sidebar() {
        remove_action( 'genesis_sidebar', 'genesis_do_sidebar' ); //remove the default genesis sidebar
        add_action( 'genesis_sidebar', 'ycb_event_do_sidebar' ); //add an action hook to call the function for my custom sidebar
}

//Function to output my custom sidebar
function ycb_event_do_sidebar() {
	genesis_widget_area( 'single-event-sidebar' );
}

//add_action( 'genesis_after_header', 'ycb_event_hero_markup_open');
//add_action( 'genesis_after_header', 'ycb_event_meta');
//add_action( 'genesis_after_header', 'genesis_do_post_title');
//add_action( 'genesis_after_header', 'ycb_event_register_button');
//add_action( 'genesis_after_header', 'ycb_event_hero_markup_close');

function ycb_event_hero_markup_open_1() {
	echo '<div class="event-header"><div class="wrap">';
}

function ycb_event_hero_markup_open() {
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	if ( has_post_thumbnail() ) {
		$bg_image = genesis_get_image(
			array(
				'format' => 'url',
				'size'   => 'full',
			)
		);
	} 

	if ( $bg_image ) {
		$output = '<div class="event-hero" style="background-image: linear-gradient(0deg, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.85) 100%), url(' . esc_url( $bg_image ) . ')"><div class="wrap">';	
	}
	echo $output;
}

function ycb_event_hero_markup_close() {
	echo '</div></div>';
}

//add_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_open', 5 );
//add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_post_title');
//add_action( 'genesis_before_content_sidebar_wrap', 'ycb_event_meta');
//add_action( 'genesis_before_content_sidebar_wrap', 'ycb_event_register_button');
//add_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_close', 15 );
//add_action( 'genesis_before_content_sidebar_wrap', 'ycb_event_image');

//remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
//remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
//remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
add_action( 'genesis_entry_header', 'ycb_event_meta', 10);
add_action( 'genesis_entry_header', 'ycb_event_register_button', 10);


//add_action ( 'genesis_after_entry' , 'ycb_other_events');
function ycb_other_event() {
	do_short('[loop type=event count=4 field=_event_start_date date_format="Y-m-d" value=future compare=equal orderby=_event_start_date date_format="Y-m-d" order=ASC]
	[field image-link]
	[field _event_start_date date_format="d/m/Y"]
	[field title-link]
	[/loop]');
}
genesis();