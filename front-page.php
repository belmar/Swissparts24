<?php

/**
 * Home Page.
 *
 * @category   Genesis_Sandbox
 * @package    Templates
 * @subpackage Home
 * @author     Travis Smith and Jonathan Perez, for Surefire Themes
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.1.0
 */
//** Update structural wrap, add 'inner'. Refer on the "Add support for structural wraps" section on functions.php
remove_theme_support( 'genesis-structural-wraps' );
add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',	
		'inner',
		'footer-widgets',
		'footer'
	) );

add_action( 'get_header', 'gs_home_helper' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function gs_home_helper() {
		if ( is_active_sidebar( 'home-top' )){
			add_action( 'genesis_after_header', 'gs_add_banner' );
		}
		
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		
		if ( is_active_sidebar( 'home-bottom' )){
			add_action( 'genesis_before_footer', 'gs_add_bottom', 5, 2 );
		}
}

function gs_add_banner(){
	genesis_widget_area(
                'home-top', 
                array( 'before' => '<div id="home-top-wrap"><aside id="home-top" class="home-widget widget-area parallax top">', 
						'after' => '</aside></div><!-- end #home-top -->'
				) 
			);
}

function gs_add_bottom(){
	genesis_widget_area(
                'home-bottom', 
                array( 'before' => '<div id="home-bottom-wrap"><aside id="home-bottom" class="home-widget widget-area parallax bottom">', 
						'after' => '</aside></div><!-- end #home-bottom -->'
				) 
			);
}

genesis();