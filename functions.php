<?php

/**
 * Custom amendments for the theme.
 *
 * @category   Genesis_Sandbox
 * @package    Functions
 * @subpackage Functions
 * @author     Travis Smith and Jonathan Perez
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://surefirewebservices.com/
 * @since      1.1.0
 */

// Initialize Sandbox ** DON'T REMOVE **
require_once( get_stylesheet_directory() . '/lib/init.php');

add_action( 'genesis_setup', 'gs_theme_setup', 15 );

//Theme Set Up Function
function gs_theme_setup() {
	
	//Enable HTML5 Support
	add_theme_support( 'html5' );

	//Enable Post Navigation
	add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

	/** 
	 * 01 Set width of oEmbed
	 * genesis_content_width() will be applied; Filters the content width based on the user selected layout.
	 *
	 * @see genesis_content_width()
	 * @param integer $default Default width
	 * @param integer $small Small width
	 * @param integer $large Large width
	 */
	$content_width = apply_filters( 'content_width', 600, 430, 920 );
	
	//Custom Image Sizes
	add_image_size( 'featured-image', 225, 160, TRUE );
	
	// Enable Custom Background
	//add_theme_support( 'custom-background' );

	// Enable Custom Header
	//add_theme_support('genesis-custom-header');


	// Add support for structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',
		'footer-widgets',
		'footer'
	) );

	/**
	 * 07 Footer Widgets
	 * Add support for 3-column footer widgets
	 * Change 3 for support of up to 6 footer widgets (automatically styled for layout)
	 */
	add_theme_support( 'genesis-footer-widgets', 1 );

	/**
	 * 08 Genesis Menus
	 * Genesis Sandbox comes with 4 navigation systems built-in ready.
	 * Delete any menu systems that you do not wish to use.
	 */
	add_theme_support(
		'genesis-menus', 
		array(
			'primary'   => __( 'Primary Navigation Menu', CHILD_DOMAIN ), 
			'secondary' => __( 'Secondary Navigation Menu', CHILD_DOMAIN ),
			'footer'    => __( 'Footer Navigation Menu', CHILD_DOMAIN ),
			'mobile'    => __( 'Mobile Navigation Menu', CHILD_DOMAIN ),
		)
	);
	
	// Add Mobile Navigation
	add_action( 'genesis_before', 'gs_mobile_navigation', 5 );
	
	//Enqueue Sandbox Scripts
	add_action( 'wp_enqueue_scripts', 'gs_enqueue_scripts' );
	
	/**
	 * 13 Editor Styles
	 * Takes a stylesheet string or an array of stylesheets.
	 * Default: editor-style.css 
	 */
	//add_editor_style();
	
	
	// Register Sidebars
	gs_register_sidebars();
	
	/******** REPOSITION/MODIFICATIONS ********/
	
	//* Reposition the primary navigation menu
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_header_right', 'genesis_do_nav' );	
	
	add_filter( 'wp_nav_menu_items', 'gs_translate_primary_nav_menu', 9, 2 );	
	add_filter( 'wp_nav_menu_items', 'gs_search_primary_nav_menu', 10, 2 );	
	
	
	
	//* Customize the entire footer
	remove_action( 'genesis_footer', 'genesis_do_footer' );
	add_action( 'genesis_footer', 'gs_custom_footer' );	
	add_action( 'genesis_footer', 'byPassPageBreak' );	
	
	//* add spacer that will push other elements below
	add_action( 'genesis_after_header', 'add_spacer' );	
	
} // End of Set Up Function


//gf hacks
function byPassPageBreak(){
		if(get_post($post->ID)->post_name == "order-form"){
			?>
				<script>
					jQuery(function(){
						//jQuery(".swissparts24-order-form_wrapper .gform_page_footer").html("");
						//jQuery(".swissparts24-order-form_wrapper .gform_page_footer").html("<input type="button" id="gform_previous_button_2" class="gform_previous_button button" value="Previous" tabindex="25" onclick="jQuery(&quot;#gform_target_page_number_2&quot;).val(&quot;2&quot;); jQuery(&quot;#gform_2&quot;).trigger(&quot;submit&quot;,[true]); "> <input type="submit" id="gform_submit_button_2" class="gform_button button" value="Submit" tabindex="26" onclick="if(window[&quot;gf_submitting_2&quot;]){return false;}  window[&quot;gf_submitting_2&quot;]=true; "><input type="hidden" class="gform_hidden" name="is_submit_2" value="1"><input type="hidden" class="gform_hidden" name="gform_submit" value="2"><input type="hidden" class="gform_hidden" name="gform_unique_id" value="547839410ade7"><input type="hidden" class="gform_hidden" name="state_2" value="WyJbXSIsIjA3YmY5M2EyNWI1NDRkMWRkYjllOGJjMGZiYWQzZTUzIl0="><input type="hidden" class="gform_hidden" name="gform_target_page_number_2" id="gform_target_page_number_2" value="0"><input type="hidden" class="gform_hidden" name="gform_source_page_number_2" id="gform_source_page_number_2" value="3"><input type="hidden" name="gform_field_values" value="">");
						//jQuery(document).trigger('gform_post_render', [2, 3]);
					});
					
				</script>
			<?php
		}
}

// Register Sidebars
function gs_register_sidebars() {
	$sidebars = array(
		array(
			'id'			=> 'home-top',
			'name'			=> __( 'Home Top', CHILD_DOMAIN ),
			'description'	=> __( 'This is the top homepage section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-bottom',
			'name'			=> __( 'Home Bottom', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'after-post',
			'name'			=> __( 'After Post', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up after every post.', CHILD_DOMAIN ),
		),
	);
	
	foreach ( $sidebars as $sidebar )
		genesis_register_sidebar( $sidebar );
}

/**
 * Enqueue and Register Scripts - Twitter Bootstrap, Font-Awesome, and Common.
 */
require_once('lib/scripts.php');

/**
 * Add navigation menu 
 * Required for each registered menu.
 * 
 * @uses gs_navigation() Sandbox Navigation Helper Function in gs-functions.php.
 */

//Add Mobile Menu
function gs_mobile_navigation() {
	
	$mobile_menu_args = array(
		'echo' => true,
	);
	
	gs_navigation( 'mobile', $mobile_menu_args );
}

// Add Widget Area After Post
add_action('genesis_after_entry', 'gs_do_after_entry');
function gs_do_after_entry() {
 	if ( is_single() ) {
 	genesis_widget_area( 
                'after-post', 
                array(
                        'before' => '<aside id="after-post" class="after-post"><div class="home-widget widget-area">', 
                        'after' => '</div></aside><!-- end #home-left -->',
                ) 
        );
 }
 }
 
//* Add custom search after navigation. Use 'wp_nav_menu_items' filter
function gs_search_primary_nav_menu( $menu, stdClass $args ){       
        if ( 'primary' != $args->theme_location )
        	return $menu;        
               if( genesis_get_option( 'nav_extras' ) )
                return $menu;        
        $menu .= sprintf( '<li class="search right">%s</li>', __( genesis_search_form( $echo ) ) );        
        return $menu;       
}

function gs_translate_primary_nav_menu( $menu, stdClass $args ){       
        if ( 'primary' != $args->theme_location )
        	return $menu;        
               if( genesis_get_option( 'nav_extras' ) )
                return $menu;        
		$html = '<input type="button" value="EN"/><input type="button" value="THAI"/>';	
        $menu .= sprintf( '<li class="translate">%s</li>', $html);        
        return $menu;       
}

//* Spacer after the nav
function add_spacer() {
	echo '<div id="spacer"></div>';
}

//* Custom footer
function gs_custom_footer() {
		?>
		<p>&copy 2014 <a href=" <?php bloginfo( 'url' ); ?> ">SwissParts24</a>.  All Rights Reserved. Disclaimer. <a href="http://spurpress.com/">SpurPress Website Designs</a>.</p>
		<?php
}

//* Add div shortcode TODO: Seperate all shortcodes functions
function gs_custom_div($atts, $content = null ) {
	$a = shortcode_atts( array(
		'wrap' => 'no',
		'bgcolor' => 'transparent',
		'text' => '',
		'style' => ''
	), $atts );
		
	$attrib = "float: left;clear: both;width: 100%;";
	if($a['bgcolor'] != 'transparent'){$attrib.="background-color: ".$a['bgcolor'].";";}
	if($a['text'] != ''){$attrib.="color: ".$a['text'].";";}
	$attrib.=$a['style'];
	
	$html = "<div class='custom-div' style='$attrib'>";
	if($a['wrap'] != 'no'){$html.="<div class='wrap'>";}
		$html.=do_shortcode($content);
	if($a['wrap'] != 'no'){$html.="</div>";}
	$html.="</div>";
	
	return $html;	
}

add_shortcode( 'customdiv', 'gs_custom_div' );



/**
 * Modify search page *

add_filter( 'excerpt_length', 'search_page_content_limit' );
function search_page_content_limit( $length ) {
if ( is_search() ):
	return 200; 
	endif;
}

add_filter( 'get_the_content_more_link', 'search_page_read_more_link' );
function search_page_read_more_link() {
if ( is_search() ):
	return '... <a class="more-link" href="' . get_permalink() . '">The Complete Result</a>';
	else:
	return '... <a class="more-link" href="' . get_permalink() . '">Read More Link For Non Search Pages</a>';
	endif;
}

function limit_search_results( $query ) {
    if ( $query->is_search() && $query->is_main_query() ) {
        $query->set( 'posts_per_page', '2' );
    }
}
add_action( 'pre_get_posts', 'limit_search_results' ); */