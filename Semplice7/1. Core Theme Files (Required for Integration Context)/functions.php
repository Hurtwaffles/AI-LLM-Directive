<?php

// namespace
namespace Semplice;

// use
use Semplice\Content;
use Semplice\Admin\Customize;
use Semplice\Admin\Onboarding;
use Semplice\Helper\Basic;
use Semplice\Helper\Get;
use Semplice\Helper\Styles;
use Semplice\Helper\Typography;
use Semplice\Helper\Image;
use Semplice\Helper\RestApi;

// wpdb
global $wpdb;

// constants
define('SEMPLICE_VER', wp_get_theme()->get('Version'));
define('SEMPLICE_EDITION', 'studio');
define('SEMPLICE_DIR', get_template_directory());
define('SEMPLICE_URI', get_template_directory_uri());
define('SEMPLICE_STYLE_DIR', get_stylesheet_directory());
define('SEMPLICE_STYLE_URI', get_stylesheet_uri());
define('SEMPLICE_REV_TABLE', $wpdb->prefix . 'semplice_revisions');
define('SEMPLICE_BLOCKS_TABLE', $wpdb->prefix . 'semplice_content_blocks');

// -----------------------------------------
// semplice main class
// -----------------------------------------

class ThemeCore {

	// -----------------------------------------
	// constructor
	// -----------------------------------------

	public function __construct() {
		// basic theme setup
		add_action('after_setup_theme',array(&$this, 'theme_setup'));
		// include files
		$this->setup_files();
		// get content
		add_action('template_redirect', array(&$this, 'get_content'));
		// enqueue scripts and styles
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
		// frontend css
		add_action('wp_head', array(&$this, 'frontend_css'));
		// frontend js
		add_action('wp_footer', array(&$this, 'frontend_js'), 300);
		// custom js
		add_action('wp_footer', array(&$this, 'custom_js'), 300);
		// body classes
		add_filter('body_class', array(&$this, 'body_classes'));
		// launch semplice
		add_action('after_switch_theme', array(&$this, 'launch_admin'));
		// languages
		add_action('after_setup_theme', array(&$this, 'language'));
		// mime types
		add_filter('upload_mimes', array(&$this, 'mime_types'));
		// make sure allowed mime types can upload
		add_filter('wp_check_filetype_and_ext', array(&$this, 'disable_mime_check'), 10, 4);
		// allow svg (fix for recent 6.8 changes)
		add_filter( 'wp_prevent_unsupported_mime_type_uploads', array(&$this, 'allow_svg_rest'), 10, 2);
		// init templates
		add_action('init', array(&$this, 'init_templates'));
		// password form
		add_filter('the_password_form', array(&$this, 'post_password'), 10, 1);
		// big image treshhold
		$this->big_image_treshold();
	}

	// -----------------------------------------
	// basic theme setup
	// -----------------------------------------

	public function theme_setup() {
		// add post-thumbnail support
		add_theme_support('post-thumbnails');
		// html5 support for the search form
		add_theme_support('html5', array('search-form'));
		// remove wp-texturize
		remove_filter('the_content', 'wptexturize');
		// add title tag support
		add_theme_support('title-tag');
		// register main menu
		register_nav_menu('semplice-main-menu', 'Semplice Main Menu');
		// update permalinks for the use with semplice
		global $wp_rewrite;
		if($wp_rewrite->permalink_structure != '/%postname%') {
			$wp_rewrite->set_permalink_structure('/%postname%');
			add_action('admin_notices', array(&$this, 'rewrite_notice'));
		}
	}

	// -----------------------------------------
	// load required files
	// -----------------------------------------

	public function setup_files() {
		// dir shortcut
		$dir = SEMPLICE_DIR;
		// mobile detect
		if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
			require $dir . '/includes/third-party/mobile-detect/standalone/autoloader.php';
			require $dir . '/includes/third-party/mobile-detect/src/MobileDetectStandalone.php';
		}
		// helper functions
		require $dir . '/includes/helper/core.php';
		require $dir . '/includes/helper/ram.php';
		require $dir . '/includes/helper/walker.php';
		require $dir . '/includes/helper/menu.php';
		require $dir . '/includes/helper/masonry.php';
		require $dir . '/includes/helper/styles.php';
		require $dir . '/includes/helper/background.php';
		require $dir . '/includes/helper/get.php';
		require $dir . '/includes/helper/covers.php';
		require $dir . '/includes/helper/restapi.php';
		require $dir . '/includes/helper/typography.php';
		require $dir . '/includes/helper/post_queries.php';
		require $dir . '/includes/helper/image.php';
		require $dir . '/includes/helper/generate.php';
		require $dir . '/includes/helper/thumbnails.php';
		require $dir . '/includes/helper/color.php';
		require $dir . '/includes/helper/license.php';
		// atts
		require $dir . '/includes/atts/atts.php';
		// editor core
		require $dir . '/includes/content.php';
		require $dir . '/editor/editor.php';
		require $dir . '/editor/styles.php';
		require $dir . '/editor/blocks.php';
		require $dir . '/editor/components.php';
		require $dir . '/editor/sidebar.php';
		require $dir . '/editor/revisions.php';
		require $dir . '/editor/placeholder.php';
		// editor types
		require $dir . '/editor/types/cover.php';
		require $dir . '/editor/types/section.php';
		require $dir . '/editor/types/row.php';
		require $dir . '/editor/types/column.php';
		require $dir . '/editor/types/subrow.php';
		require $dir . '/editor/types/content.php';
		// editor animate
		require $dir . '/editor/animate.php';
		require $dir . '/editor/animate/get.php';
		require $dir . '/editor/animate/styles.php';
		// editor modules
		require $dir . '/editor/modules/text.php';
		require $dir . '/editor/modules/fluidtext.php';
		require $dir . '/editor/modules/paragraph.php';
		require $dir . '/editor/modules/image.php';
		require $dir . '/editor/modules/video.php';
		require $dir . '/editor/modules/oembed.php';
		require $dir . '/editor/modules/youtube.php';
		require $dir . '/editor/modules/vimeo.php';
		require $dir . '/editor/modules/code.php';
		require $dir . '/editor/modules/share.php';
		require $dir . '/editor/modules/blogposts.php';
		require $dir . '/editor/modules/blogarchives.php';
		require $dir . '/editor/modules/blogsearch.php';
		require $dir . '/editor/modules/blogcomments.php';
		require $dir . '/editor/modules/button.php';
		require $dir . '/editor/modules/socialprofiles.php';
		require $dir . '/editor/modules/marquee.php';
		require $dir . '/editor/modules/accordion.php';
		require $dir . '/editor/modules/portfoliogrid.php';
		require $dir . '/editor/modules/singleproject.php';
		require $dir . '/editor/modules/gallery.php';
		require $dir . '/editor/modules/spacer.php';
		require $dir . '/editor/modules/advancedportfoliogrid.php';
		require $dir . '/editor/modules/lottie.php';
		// studio modules
		if(SEMPLICE_EDITION == 'studio') {
			require $dir . '/editor/modules/mailchimp.php';
			require $dir . '/editor/modules/gallerygrid.php';
			require $dir . '/editor/modules/beforeafter.php';
		}
		// admin rest api
		require $dir . '/includes/rest-api/admin/core.php';
		require $dir . '/includes/rest-api/admin/customize.php';
		require $dir . '/includes/rest-api/admin/settings.php';
		require $dir . '/includes/rest-api/admin/posts.php';
		require $dir . '/includes/rest-api/admin/media.php';
		require $dir . '/includes/rest-api/admin/post-settings.php';
		// editor rest api
		require $dir . '/includes/rest-api/editor/core.php';
		require $dir . '/includes/rest-api/editor/revisions.php';
		require $dir . '/includes/rest-api/editor/blocks.php';
		require $dir . '/includes/rest-api/editor/save.php';
		require $dir . '/includes/rest-api/editor/blog.php';
		// customize
		require $dir . '/admin/customize.php';
		require $dir . '/admin/customize/grid.php';
		require $dir . '/admin/customize/webfonts.php';
		require $dir . '/admin/customize/typography.php';
		require $dir . '/admin/customize/navigations.php';
		require $dir . '/admin/customize/transitions.php';
		require $dir . '/admin/customize/intro.php';
		require $dir . '/admin/customize/projectnav.php';
		require $dir . '/admin/customize/thumbhover.php';
		require $dir . '/admin/customize/advanced.php';
		require $dir . '/admin/customize/cursor.php';
		require $dir . '/admin/customize/ppc.php';
		require $dir . '/admin/customize/footer.php';
		require $dir . '/admin/customize/blog.php';
		// navigations classes
		require $dir . '/admin/customize/navigations/module-atts.php';
		require $dir . '/admin/customize/navigations/module-css.php';
		// navigations modules
		require $dir . '/admin/customize/navigations/modules/menu.php';
		require $dir . '/admin/customize/navigations/modules/link.php';
		require $dir . '/admin/customize/navigations/modules/text.php';
		require $dir . '/admin/customize/navigations/modules/image.php';
		require $dir . '/admin/customize/navigations/modules/button.php';
		require $dir . '/admin/customize/navigations/modules/spacer.php';
		require $dir . '/admin/customize/navigations/modules/lottie.php';
		require $dir . '/admin/customize/navigations/modules/code.php';
		// admin core
		require $dir . '/admin/onboarding.php';
		require $dir . '/admin/dashboard.php';
		require $dir . '/admin/post-settings.php';
		// frontend rest api
		require $dir . '/includes/rest-api/frontend/core.php';
		// custom post types
		require $dir . '/includes/post-types/portfolio.php';
		require $dir . '/includes/post-types/footer.php';
		// admin functions
		if(is_admin()) {
			require $dir . '/admin/functions.php';
		}
	}

	// -----------------------------------------
	// get content
	// -----------------------------------------

	public function get_content() {
		// make sure its not the backend
		if(!is_admin()) {
			// post object
			global $post;
			// get advanced
			$advanced = Get::customize('advanced');
			// paged
			if(!is_home() && is_front_page()) {
				$paged = (get_query_var('page')) ? get_query_var('page') : 1;
			} else {
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			}
			// filter
			$filter = false;
			if(is_home()) {
				$filter = array('type' => 'overview', 'meta' => false);
			} else if(is_category()) {
				$filter = array('type' => 'category', 'meta' => get_term_by('id', get_query_var('cat'), 'category'));
			} else if(is_tag()) {
				$filter = array('type' => 'tag', 'meta' => get_term_by('id', get_queried_object()->term_id, 'post_tag'));
			} else if(is_author()) {
				$filter = array('type' => 'author', 'meta' => get_query_var('author'));
			} else if(is_search()) {
				$filter = array('type' => 'searchresults', 'meta' => get_query_var('s'));
			} else if(is_single()) {
				$filter = array('type' => 'singlepost', 'meta' => $post->ID);
			}
			// post id
			if(is_object($post)) {
				$post_id = $post->ID;
			} else {
				$post_id = 'notfound';
			}
			// get content
			$content = Content::get(Basic::format_post_id($post_id, false), is_preview(), $paged, $filter, false, false);
			// get navbar if not defined yet
			$exclusive_nav = Basic::is_exclusive_nav();
			if($exclusive_nav) {
				$content['navbar'] = Customize::$setting['navigations']->get($exclusive_nav, true, false);
			} else if(!isset($content['navbar'])) {
				$content['navbar'] = Customize::$setting['navigations']->get(false, true, false);
			}
			// add intro
			$content['intro'] = Get::intro();
			// fetch content
			define('SEMPLICE_CONTENT', $content);
		}
	}

	// -----------------------------------------
	// enqueue scripts and styles
	// -----------------------------------------

	public function enqueue() {
		// shortcut
		$uri = SEMPLICE_URI;
		$ver = SEMPLICE_VER;
		// style.css
		wp_enqueue_style('semplice-stylesheet', SEMPLICE_STYLE_URI, array(), $ver);
		// frontend stylesheet
		wp_enqueue_style('semplice-frontend-stylesheet', $uri . '/assets/css/frontend.css', false, $ver);
		// shared scripts
		wp_enqueue_script('semplice-shared-scripts', $uri . '/assets/js/shared.scripts.js', '', $ver, true);
		// share frontend scripts
		wp_enqueue_script('semplice-frontend-scripts', $uri . '/assets/js/frontend.scripts.js', '', $ver, true);
		// frontend js
		wp_enqueue_script('semplice-frontend-js', $uri . '/assets/js/frontend.js', array('jquery', 'mediaelement'), $ver, true);
		// frontend js localize script
		wp_localize_script('semplice-frontend-js', 'sempliceWp', $this->localize_script());
	}

	// -----------------------------------------
	// frontend css
	// -----------------------------------------

	public function frontend_css() {
		// vars
		$content = SEMPLICE_CONTENT;
		$post_id = Get::post_id();
		$exclusive_nav = Basic::is_exclusive_nav();
		// webfonts first
		$css = Customize::$setting['webfonts']->get();
		// inter webfont
		$css .= '<style type="text/css" id="smp-css-default-fonts">' . Typography::setup_default_fonts() . '</style>';
		// custom css
		$css .= '
			<style type="text/css" id="smp-css-custom">
				' . Customize::$setting['grid']->css(true) . '
				' . Customize::$setting['typography']->get(false, false) . '
				' . (($exclusive_nav) ? Styles::frontend($content['navbar']['css'], $post_id) : '') . '
				' . Customize::$setting['projectnav']->css(true) . '
				' . Customize::$setting['cursor']->css(true) . '
				' . Customize::$setting['ppc']->css(true) . '
				' . Customize::$setting['thumbhover']->css(false, false, true, '', false) . '
				' . Customize::$setting['advanced']->css(true) . '
			</style>
		';
		// post css
		$css .= '
			<style type="text/css" id="smp-css-post-' . $post_id . '">
				' . ((!$exclusive_nav) ? Styles::frontend($content['navbar']['css'], $post_id) : '') . '
				' . (($content['intro']) ? Styles::frontend($content['intro']['css'], $post_id) : '') . '
				' . Styles::frontend($content['css'], $post_id) . '
			</style>
		';
		// user css
		$css .= '
			<style type="text/css" id="smp-css-user">
				' . Customize::$setting['advanced']->user_css() . '
			</style>
		';
		// echo
		echo $css;
	}

	// -----------------------------------------
	// frontend js
	// -----------------------------------------

	public function frontend_js() {
		// vars
		$content = SEMPLICE_CONTENT;
		$post_id = Get::post_id();
		$intro = Get::customize('intro');
		$intro_delay = (isset($intro) && isset($intro['delay'])) ? $intro['delay'] : 500;
		$ppc = (post_password_required()) ? 'true' : 'false';
		// add intro motion js
		if($content['intro'] && !empty($content['intro']['js'])) {
			echo '
				<script type="text/javascript" id="intro-motion-js">
					' . $content['intro']['js'] . '
					semplice.intro(' . intval($intro_delay) . ', ' . $ppc . ');
				</script>
			';
		} else if(!empty($post_id) && !empty($content['js']) && !post_password_required()) {
			echo '<script type="text/javascript" id="' . $post_id . '-motion-js">' . $content['js'] . '</script>';
		}
	}

	// -----------------------------------------
	// custom js
	// -----------------------------------------

	public function custom_js() {
		// get frontend mode
		$mode = Get::frontend_mode();
		// get advanced content
		$advanced = Get::customize('advanced');
		// is array?
		if(is_array($advanced)) {
			// check if custom js is there and not empty
			if(isset($advanced['custom_js']) && !empty($advanced['custom_js'])) {
				// custom js spa behavior
				if(isset($advanced['custom_js_spa']) && $advanced['custom_js_spa'] == 'pagechange' && $mode == 'dynamic') {
					$advanced['custom_js'] = '
						// custom javascript function
						function smp_custom_js() {
							' . $advanced['custom_js'] . '
						}
						// call custom javascript
						smp_custom_js();
						// call it again for every page change
						window.addEventListener("sempliceAppendContent", function (e) {
							smp_custom_js();
						}, false);
					';
				}
				// add custom javascript
				echo '<script type="text/javascript" id="semplice-custom-javascript">' . $advanced['custom_js'] . '</script>';
			}
		}
	}

	// -----------------------------------------
	// localize script defaults
	// -----------------------------------------

	public function localize_script() {
		// vars
		$content = SEMPLICE_CONTENT;
		$frontend_mode = Get::frontend_mode();
		$front_page = get_option('page_on_front') ? get_option('page_on_front') : 'posts';
		// return
		$output = array(
			'nonce'  			=> wp_create_nonce('wp_rest'),
			'version' 			=> SEMPLICE_VER,
			'frontendMode'		=> $frontend_mode,
			'api'				=> array(
				'default' 		=> untrailingslashit(RestApi::rest_url()),
				'frontend'		=> untrailingslashit(RestApi::rest_url()) . '/semplice/v1/frontend',
			),
			'siteName'				=> get_bloginfo('name'),
			'baseUrl'				=> home_url(),
			'frontpageId'			=> $front_page,
			'blogHome'				=> get_post_type_archive_link('post'),
			'categoryBase'			=> Get::category_base(),
			'tagBase'				=> Get::tag_base(),
			'ram'	  				=> SEMPLICE_CONTENT['ram'],
			'isPreview'				=> is_preview(),
			'exclusiveNav'			=> Basic::is_exclusive_nav(),
			'afterIntro'			=> ($content['intro'] && !empty($content['intro']['js'])) ? $content['js'] : false,
			'passwordForm' 			=> $this->post_password(),
			'cursor'				=> Get::customize('cursor')
		);
		// add items for the dynamic version
		if($frontend_mode != 'static') {
			// assign post ids
			$output['postIds'] = Get::post_ids();
			// transitions
			$output['transitions'] = Get::transitions();
			$output['transitionPresets'] = json_decode(file_get_contents(SEMPLICE_DIR . '/assets/json/defaults/transition-presets.json'), true);
		}
		// return
		return array('atts' => $output);
	}

	// -----------------------------------------
	// body classes
	// -----------------------------------------

	public function body_classes($classes) {
		// check if dashboard or not
		if(!is_admin()) {
			$classes[] = 'is-frontend';
			// intro
			if(SEMPLICE_CONTENT['intro']) {
				$classes[] = 'site-intro';
			}
		}
		// app mode
		$classes[] = (Get::frontend_mode() == 'static') ? 'static-mode' : 'dynamic-mode';
		// preview
		if(is_preview()) {
			$classes[] = 'is-preview';
		}
		// custom cusor
		$cursor = Customize::$setting['cursor']->get('classes');
		if($cursor['status']) {
			$classes[] = $cursor['classes'];
		}
		return $classes;
	}

	// -----------------------------------------
	// launch admin
	// -----------------------------------------

	public function launch_admin() {
		wp_redirect(admin_url('admin.php?page=semplice-admin'));
	}

	// -----------------------------------------
	// add mime types needed for semplice
	// -----------------------------------------

	public function mime_types($mimes) {
		return array_merge($mimes,array (
			// webp images
			'webp' => 'image/webp',
			// svg images
			'svg' => 'image/svg+xml',
			// fonts
			'ttf' => 'font/ttf',
			'otf' => 'font/otf',
			'woff' => 'font/woff',
			'woff2' => 'font/woff2',
			// json
			'json' => 'application/json'
		));
	}

	// -----------------------------------------
	// make sure allowed mime types can upload
	// -----------------------------------------

	public function disable_mime_check($data, $file, $filename, $mimes) {
		$wp_filetype = wp_check_filetype( $filename, $mimes );	
		$ext = $wp_filetype['ext'];
		$type = $wp_filetype['type'];
		$proper_filename = $data['proper_filename'];
		return compact('ext', 'type', 'proper_filename');
	}

	// -----------------------------------------
	// init templates
	// -----------------------------------------

	public function init_templates() {
		// templates
		$templates = array('overview', 'singlepost', 'archive', 'searchresults', 'intro');
		// iterate templates
		foreach($templates as $template) {
			// add to db if not there yet
			if(!get_option('semplice_template_' . $template)) {
				// get template
				$content_json = file_get_contents(SEMPLICE_DIR . '/assets/json/wp-templates/' . $template . '.json');
				// save default to template
				update_option('semplice_template_' . $template, $content_json);
			}
		}
		// change archive url
		global $wp_rewrite;
    	$wp_rewrite->date_structure = 'archives/%year%/%monthnum%/%day%';
	}

	// ----------------------------------------
	// semplice password form
	// ----------------------------------------

	public function post_password() {
		// post object
		global $post;
		// check if post is active
		$post_id = (is_object($post)) ? $post->ID : 0;
		// atts
		$atts = array(
			'submit' => '',
			'theme' => '',
		);
		// mode defaults
		$frontend_mode = Get::frontend_mode();
		// get an alternative submit button for the single page app form
		if($frontend_mode == 'dynamic') {
			$atts['submit'] = '<a class="post-password-submit click-handler" data-handler="run" data-action-type="spa" data-action="postPassword" data-id="' . $post_id . '">Submit</a>';
		} else {
			$atts['submit'] = '<input type="submit" class="post-password-submit" name="Submit" value="Submit" />';
		}
		// get advanced content
		$advanced = Get::customize('advanced');
		// version
		$atts['theme'] = '';
		if(isset($advanced['password_form_theme']) && $advanced['password_form_theme'] == 'dark') {
			$atts['theme'] = ' post-password-form-dark';
		}
		// form template
		$output = Get::template('password_form', $atts);
		// only use the password form for pages and projects
		if(get_post_type($post_id) == 'page' || get_post_type($post_id) == 'project' || $frontend_mode == 'dynamic' || is_single()) {
			return $output;
		} else {
			return '';
		}
	}

	// ----------------------------------------
	// languages
	// ----------------------------------------

	public function language() {
		load_theme_textdomain('semplice', get_template_directory() . '/languages');
	}

	// ----------------------------------------
	// rewrite notice
	// ----------------------------------------

	public function rewrite_notice() {
		?>
		<div class="notice notice-warning is-dismissible">
			<div class="warning"><?php _e('In order for Semplice to work properly we changed your permalink structure automatically to <b>\'%postname\'</b>. <br /><i>Example: http://www.domain.com/post-name.</i>', 'semplice'); ?></div>
		</div>
		<?php
	}

	// ----------------------------------------
	// big image treshold
	// ----------------------------------------

	public function big_image_treshold() {
		$advanced = Get::customize('advanced');
		if(isset($advanced['big_image_treshold']) && $advanced['big_image_treshold'] == 'disabled') {
			add_filter( 'big_image_size_threshold', '__return_false' );
		}
	}

	// ----------------------------------------
	// allow svg after recent 6.8 changes
	// ----------------------------------------

	public function allow_svg_rest($prevent_upload, $mime_type) {
		if ( 'image/svg+xml' === $mime_type ) {
			return false;
		}
		return $prevent_upload;
	}
}

// init
new ThemeCore;
?>