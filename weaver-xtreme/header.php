<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/**
 * The Header for Weaver Xtreme
 *
 * Displays all of the <head> section and everything up till < div id="container" >
 *
 *  >>>> DO NOT EDIT THIS FILE <<<<
 *
 * Warning! DO NOT EDIT THIS FILE, or any other theme file! If you edit ANY theme
 * file, all your changes will be LOST when you update the theme to a newer version.
 * Instead, if you need to change theme functionality, CREATE A CHILD THEME!
 *
 *  >>>> DO NOT EDIT THIS FILE <<<<
 */

if ( ! isset( $GLOBALS['weaverx_page_who'] ) ) {
	$GLOBALS['weaverx_page_who'] = 'unknown';
}
do_action( 'weaverx_alt_theme', $GLOBALS['weaverx_page_who'] );

?>
<!DOCTYPE html>
<?php echo '<html '; language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<?php
	/* set viewport, use full horizontal size on iPad */
	echo "<meta name='viewport' content='width=device-width,initial-scale=1.0' />\n";
	?>

	<link rel="profile" href="//gmpg.org/xfn/11"/>
	<link rel="pingback" href="<?php esc_url( get_bloginfo( 'pingback_url' ) ); ?>"/>

	<?php // V4.4: drop support for IE8 and IE9

	do_action( 'weaverx_load_fonts' );        // load google fonts

	// ++++ FAVICON - only if option has been set ++++
	$icon = weaverx_getopt( '_favicon_url' );
	if ( $icon != '' ) {
		$url = esc_url( apply_filters( 'weaverx_css', parse_url( $icon, PHP_URL_PATH ) ) );
		echo "<link rel=\"shortcut icon\"  href=\"$url\" />\n";
	}

	do_action( 'weaverxplus_action', 'head' ); // stuff like other style files...

	wp_head();
	?>
</head>
<!-- **** body **** -->
<?php echo '<' . 'body '; body_class();
echo weaverx_schema( 'body' ); ?>>
<?php wp_body_open();       // Since WP 5.2 ?>
<a href="#page-bottom" id="page-top">&darr;</a> <!-- add custom CSS to use this page-bottom link -->
<div id="wvrx-page-width">&nbsp;</div>
<!--googleoff: all-->
<noscript><p style="border:1px solid red;font-size:14px;background-color:pink;padding:5px;margin-left:auto;margin-right:auto;max-width:640px;text-align:center;">
		<?php esc_html_e( 'JAVASCRIPT IS DISABLED. Please enable JavaScript on your browser to best view this site.', 'weaver-xtreme' /*adm*/ ); ?></p></noscript>
<!--googleon: all--><!-- displayed only if JavaScript disabled -->
<?php
do_action( 'weaverxplus_action', 'body_top' ); // mostly for the loading screen

weaverx_inject_area( 'prewrapper' );

weaverx_area_div( 'wrapper' );

weaverx_inject_area( 'fixedtop', 'wvrx-fixedtop' );    // inject fixed top


/* header layout:
 * #header
 *    #top-menu
 *    #branding
 *        #site-title
 *        #site-tagline
 *    #header-html
 *    #header-widget-area
 *    #bottom-menu
 */

weaverx_clear_both( 'preheader' );
weaverx_inject_area( 'preheader' );    // inject pre-header HTML
weaverx_header_widget_area( 'pre_header' );

$hdr_class = ( weaverx_is_checked_page_opt( '_pp_hide_header' ) ) ? 'hide ' : '';
$hdr_class .= weaverx_getopt_default( 'header_image_render', 'header-as-img' ) . ' ';

weaverx_area_div( 'header', $hdr_class );      // <div id='header'>

echo '<div id="header-inside" class="block-inside">';

if ( apply_filters( 'weaverx_replace_pb_area', 'header' ) == 'header' ) {

	weaverx_inject_area( 'header' );    // inject header HTML

	do_action( 'weaverx_nav', 'top' );                // menus at top

	/* ======== HEADER WIDGET AREA ======== */
	weaverx_header_widget_area( 'top' );           // show header widget area if set to this position

	echo '<header id="branding"' . weaverx_schema( 'branding' ) . ">\n";    // version 3.1.10: removed  role="banner"

	/* ======== SITE LOGO and TITLE ======== */

	$title_over_image = weaverx_logo_and_title();       // see if move title over image

	weaverx_header_widget_area( 'before_header' );           // show header widget area if set to this position

	/* ======== HEADER IMAGE ======== */

	weaverx_header_image();                // header image or video

	if ( $title_over_image ) {
		echo '</div><!--/#title-over-image -->' . "\n";
	}

	weaverx_header_widget_area( 'after_header' );           // show header widget area if set to this position

	/* ======== EXTRA HTML ======== */

	weaverx_header_extra_html();

	weaverx_header_widget_area( 'after_html' );           // show header widget area if set to this position

	do_action( 'weaverxplus_action', 'header_area_bottom' );

	weaverx_clear_both( 'branding' );

	?>
	</header><!-- #branding -->
	<?php

	/* ======== BOTTOM MENU ======== */
	do_action( 'weaverx_nav', 'bottom' );                // menus at bottom
	weaverx_header_widget_area( 'after_menu' );          // show header widget area if set to this position
	//}


} // no header area replacement

echo "\n</div></div><div class='clear-header-end clear-both'></div><!-- #header-inside,#header -->\n";

weaverx_header_widget_area( 'post_header' );
do_action( 'weaverx_post_header' );

// ************* DEFINE HEADER RELATED PLUGGABLE FUNCTION *****************
function weaverx_header_extra_html() {

	// add extra html to header

	$extra = weaverx_get_per_page_value( '_pp_header_html' );
	if ( $extra == '' ) {
		$extra = weaverx_getopt( 'header_html_text' );
	}

	$hide = weaverx_getopt_default( 'header_html_hide', 'hide-none' );

	if ( $extra == '' && is_customize_preview() ) {
		echo '<div id="header-html" style="display:inline;"></div>';        // need the area there for customizer live preview
	} elseif ( $extra != '' && $hide != 'hide' && ! weaverx_is_checked_page_opt( '_pp_hide_header_html' ) ) {
		$c_class = weaverx_area_class( 'header_html', 'not-pad', '-none', 'margin-none' );

		// 'expand_header-html' removed V5

		// see if the content is just an int, assume it to be a post id if so.
		// it seems that if a string has an int in it, the ( int ) cast will just cast that part, and throw away the rest.
		// we want an int and only an int, so we double cast to test, and that seems to work

		$post_id = ( int ) trim( $extra );

		if ( ( string ) $post_id == $extra && $post_id != 0 ) {        // assume a number only is a post id to provide as replacement
			echo apply_filters( 'weaverx_page_builder_content', $post_id, 'header-html', $c_class );
		} else {
			?>
			<div id="header-html" class="<?php echo $c_class; ?>">
				<?php echo do_shortcode( $extra ); ?>
			</div> <!-- #header-html -->
		<?php }
	}
}

//--

// ------------------------------------------------------------------------------------
function weaverx_header_image() {

// this is a function party because it is complicated, and partly to be able to use return to end logic.

	$h_hide = weaverx_getopt_default( 'hide_header_image', 'hide-none' ); // stuff depends on hide attribute

// really hide - don't need to have device download the image
	$really_hide = ( $h_hide == 'hide' || ( weaverx_getopt( 'hide_header_image_front' ) && is_front_page() ) );

	if ( $really_hide || ( ! is_search() && weaverx_is_checked_page_opt( '_pp_hide_header_image' ) ) ) { // don't bother if hide header image
		echo '<div id="header-image" class="hide"></div>';    // place holder

		return;
	}

// build #header classes

	$img_class = 'header-image ';
	if ( $h_hide != 'hide-none' && $h_hide != 'hide' ) {
		$img_class .= $h_hide . ' ';
	}

	// 'expand_header-image' removed V5

	if ( weaverx_getopt( 'header_image_add_class' ) != '' ) {
		$img_class .= weaverx_getopt( 'header_image_add_class' ) . ' ';
	}

	$full_wide = weaverx_getopt( 'header_image_align' );
	if ( $full_wide == 'alignfull' || $full_wide == 'alignwide' )   // this will override other stuff
	{
		$img_class .= $full_wide . ' ';
	}

	$page_type = ( is_single() ) ? 'post' : 'page';

	$hdr_bg = weaverx_fi( $page_type, 'header-image' );

	$hdr_type = ( $hdr_bg ) ? 'fi' : 'std';

	$img_class .= 'header-image-type-' . $hdr_type;

	echo '<div id="header-image" class="' . esc_attr( $img_class ) . '">';

// Check different ways to display a header:
// 0. Archive type page - including search ( Changed: 3.1.1 )
// 1. As HTML replacement, possibly with regular image as BG header image
// 2. As Video Header
// 3. As Standard or FI BG replacement ( no video supported )
// 4. As FI Replacement
// 5. As standard Image


// 1. HTML replacement
	$hdr_html = '';

	if ( ! $hdr_bg ) {       // FI as header replacement has priority

		$hdr_html = weaverx_get_per_page_value( '_pp_header_image_html_text' );    // per page has priority

		if ( ! $hdr_html ) {
			$hdr_html = weaverx_getopt( 'header_image_html_text' );
		}
		if ( $hdr_html && weaverx_getopt( 'header_image_html_home_only' ) && ! is_front_page() )    // only on global, not per page/post
		{
			$hdr_html = '';
		}     // make empty so will pickup the standard header

		if ( $hdr_html ) {                    // custom header html replacement overrides all other header image options
			echo do_shortcode( wp_kses( $hdr_html , weaverx_expanded_allowed_tags() ) );   // output the html
		}
	}

// 2. As Header Video

	if ( ! $hdr_html && weaverx_has_header_video() ) {
		// echo "<!-- has header video -->";
		// Handle Video - don't show if HTML supplied

		// Note: @todo: WP 4.7 doesn't filter has_header_video, but uses it internally, so video won't show unless defined in WP options
		// Now just have to emit standard WP Header image code. BG handled in header_video_settings filter.

		if ( $hdr_bg ) {    // have alternate header image to match video
			$before = '';
			$after = '';

			if ( weaverx_has_header_video() ) { // handle header video
				wp_enqueue_script( 'wp-custom-header' );
				wp_localize_script( 'wp-custom-header', '_wpCustomHeaderSettings', get_header_video_settings() );
				$before = '<div id="wp-custom-header" class="wp-custom-header">';
				$after = '</div>';
			}

			$alt = esc_attr( get_bloginfo( 'name', 'display' ) );
			$fi_hdr = get_the_post_thumbnail( null, 'full', array( 'alt' => $alt, 'class' => 'wvrx-header-image' ) );
			echo $before . $fi_hdr . $after;

		} elseif ( function_exists( 'the_custom_header_markup' ) && ( weaverx_get_video_render() != 'has-header-video-none' ) ) {
			the_custom_header_markup();            // default WP Header Image markup - works for most everything, works with customizer
		} else {
			the_header_image_tag();
		}

		echo( "\n</div><!-- #header-image -->\n" );

		return;
	}

// 3. As Standard or FI BG replacement ( no video supported )

	if ( weaverx_getopt_default( 'header_image_render', 'header-as-img' ) != 'header-as-img'   // use as BG image?
	     && ( ! $hdr_html || weaverx_getopt( 'header_image_html_plus_bg' ) ) ) { // have bg, or have BOTH HTML and bg image?

		if ( ! $hdr_bg ) {
			$hdr_bg = get_header_image();       // get the url of the standard header image
		}

		$hdr_bg = esc_url( str_replace( array( 'http://', 'https://' ), '//', $hdr_bg ) );

		// have to emit background-image url... this will be Plus only.
		if ( strlen( $hdr_bg ) > 1 ) {
			$style = "\n<style>";

			if ( $h_hide != 'hide' ) {
				$style .= "#header{background-image:url( {$hdr_bg} );}";
			}

			// handle hide on devices

			if ( strpos( $h_hide, 's-hide' ) !== false ) {
				$style .= '.is-phone #header{background-image:none;}';
			}
			if ( strpos( $h_hide, 'm-hide' ) !== false ) {
				$style .= '.is-tablet #header{background-image:none;}';
			}
			if ( strpos( $h_hide, 'l-hide' ) !== false ) {
				$style .= '.is-desktop #header{background-image:none;}';
			}
			$style .= "</style>\n";
			weaverx_echo_sanitized_html( $style );

		}
		echo '<div class="clear-header-image" style="clear:both"></div></div><!-- #header-image -->';

		return;

	} // end of bg image handling

	if ( $hdr_html ) {
		echo( "\n</div><!-- #header-image + HTML -->\n" );

		return;
	}

// Most common case now - either FI replacement, or standard header image
// to here, then want to get an image. Where does it come from?

	if ( weaverx_getopt( 'link_site_image' ) ) {
		?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
	}

	if ( weaverx_fi( $page_type, 'header-image' ) ) {           // Use FI as header image

		$alt = get_bloginfo( 'name', 'display' );
		the_post_thumbnail( 'full', array( 'alt' => esc_attr( $alt ), 'class' => 'wvrx-header-image' ) );

	} elseif ( weaverx_getopt( 'header_actual_size' ) ) {
		?>
		<img src="<?php echo esc_url( get_header_image() ) ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" class="wvrx-header-image" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
		<?php
	} else {        // WP custom header image or header video
		if ( function_exists( 'the_custom_header_markup' ) && ( weaverx_get_video_render() != 'has-header-video-none' ) ) {
			the_custom_header_markup();            // default WP Header Image markup - works for most everything, works with customizer
		} else {
			the_header_image_tag();
		}
	}

	if ( weaverx_getopt( 'link_site_image' ) )
	{ // need to close <a> tag?
		?>
		</a> <?php
	}

	echo "\n</div><!-- #header-image -->\n";

	// end of header image code
}

//--
function weaverx_expanded_allowed_tags() {
	$my_allowed = wp_kses_allowed_html( 'post' );
	// iframe
	$my_allowed['iframe'] = array(
		'src'             => array(),
		'height'          => array(),
		'width'           => array(),
		'frameborder'     => array(),
		'allowfullscreen' => array(),
	);

	return $my_allowed;
}

//--

function weaverx_logo_and_title() {
	// generate output to show logo and the title

	$title_over_image = weaverx_getopt( 'title_over_image' )
	                    && ( weaverx_getopt_default( 'header_image_render', 'header-as-img' ) == 'header-as-img' || weaverx_getopt( 'header_image_html_plus_bg' )
	                         || weaverx_has_header_video() );

	if ( $title_over_image ) {
		echo '<div id="title-over-image">' . "\n";
	}

	$h_class = '';

	if ( weaverx_getopt( 'hide_site_title' ) != 'hide-none' ) {
		$h_class = weaverx_getopt( 'hide_site_title' );
	}

	$t_class = '';
	if ( weaverx_getopt( 'site_title_add_class' ) != 'hide-none' ) {
		$t_class .= ' ' . weaverx_getopt( 'site_title_add_class' );
	}

	echo "    <div id='title-tagline' class='clearfix " . esc_attr( $t_class ) . "'>\n";

	$logo = weaverx_getopt( '_site_logo' );

	$hide_logo = weaverx_getopt( '_hide_site_logo' );

	$the_logo = weaverx_get_wp_custom_logo();

	if ( $the_logo ) {
		$hide_wp_logo = weaverx_getopt( 'hide_wp_site_logo' );
		if ( weaverx_is_checked_page_opt( '_pp_hide_customlogo' ) ) {
			$hide_wp_logo = 'hide';
		}
		$the_logo = str_replace( 'custom-logo-link', 'custom-logo-link ' . $hide_wp_logo, $the_logo );        // fixup hide
	}

	$title = apply_filters( 'weaverx_site_title', esc_html( get_bloginfo( 'name', 'display' ) ) );

	$title_text = $title;

	if ( strlen( $the_logo ) > 0 ) {                               // there is a logo - what to do...
		if ( weaverx_getopt( 'wplogo_for_title' ) ) {
			$title_text = '<img class="site-title-logo" src="' . weaverx_get_wp_custom_logo_url() . '" alt="' . $title . '" />';
			// note: $title_text gets escaped/filtered when it is actually echoed a few lines down from here...
		} else {
			echo "\n" . wp_kses_post( $the_logo ) . "\n";
		}
	}

	?>
	<h1 id="site-title" class="<?php echo esc_attr( weaverx_title_class( 'site_title', true, $h_class ) ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $title ); ?>" rel="home">
			<?php echo wp_kses_post( $title_text ); ?></a></h1>

	<?php
	/* ======== SEARCH BOX ======== */
	$hide_search = weaverx_getopt( 'header_search_hide' );
	if ( $hide_search != 'hide' && ! weaverx_is_checked_page_opt( '_pp_hide_headersearch' ) ) { ?>
		<div id="header-search" class="<?php echo esc_attr( $hide_search ); ?>"><?php get_search_form(); ?></div><?php
	}
	$hide_tag = weaverx_getopt( 'hide_site_tagline' );

	$tagline = apply_filters( 'weaverx_tagline', esc_html( get_bloginfo( 'description' ) ) );

	echo '<h2 id="site-tagline" class="' . $hide_tag . '"><span ' . weaverx_title_class( 'tagline' ) .
	     '>' . $tagline . '</span></h2>';

	if ( $logo ) { ?>
		<div id="site-logo" class="site-logo <?php echo esc_attr( $hide_logo ); ?>"><?php echo do_shortcode( $logo ); ?></div>
	<?php }

	if ( ! weaverx_is_checked_page_opt( '_pp_hide_mini_menu' ) )    // just don't emit at all if per page
	{
		get_template_part( 'templates/menu', 'header-mini' );
	}

	echo "    </div><!-- /.title-tagline -->\n";

	return $title_over_image;   // indicator that needs the closing div after the header image itself
}
