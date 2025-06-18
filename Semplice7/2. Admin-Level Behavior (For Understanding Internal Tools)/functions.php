<?php

// namespace
namespace Semplice\Admin;

// use
use Semplice\Admin\Customize;
use Semplice\Admin\Onboarding;
use Semplice\Helper\Basic;
use Semplice\Helper\Get;
use Semplice\Helper\RestApi;
use Semplice\Helper\Typography;
use Semplice\Helper\Generate;
use Semplice\Helper\PostQueries;
use Semplice\Helper\Menu;
use Semplice\Helper\License;
use Semplice\Helper\Image;
use Semplice\Helper\Covers;
use Semplice\Helper\Color;
use Semplice\Atts;

// -----------------------------------------
// semplice admin functions
// -----------------------------------------

class ThemeAdmin {

	public $db;

	// -----------------------------------------
	// constructor
	// -----------------------------------------

	public function __construct() {
		global $wpdb;
		$this->db = $wpdb;
		// styles and scripts
		add_action('admin_enqueue_scripts', array(&$this, 'enqueue'));
		// admin menu
		add_action('admin_menu', array(&$this, 'admin_menu'));
		// admin node
		add_action('admin_bar_menu', array(&$this, 'admin_node'), 999);
		// admin head
		add_action('admin_head', array(&$this, 'wp_admin_head'));
		// meta box
		add_action('add_meta_boxes', array(&$this, 'metabox'));
		// remove revisions from permanently removed posts
		add_action('admin_init', array(&$this, 'revisions'));
		// save post
		add_action('save_post', array(&$this, 'save_post'));
		// update check
		License::update_check();
	}

	// -----------------------------------------
	// admin menu
	// -----------------------------------------

	public function admin_menu() {
		// global semplice admin page
		global $semplice_admin_page;
		// url of current page
		$current_page = substr(strrchr(rtrim($_SERVER["REQUEST_URI"], '/'), '/'), 1);
		$semplice_admin_page = add_menu_page(
			'Semplice',
			'Semplice',
			'manage_options',
			'semplice-admin',
			array(&$this, 'admin_template'),
			'dashicons-admin-generic',
			999
		);
	}

	// -----------------------------------------
	// admin node
	// -----------------------------------------

	public function admin_node($wp_admin_bar) {
		// url of current page
		$current_page = substr(strrchr(rtrim($_SERVER["REQUEST_URI"], '/'), '/'), 1);
		// args
		$args = array(
			'id'    => 'semplice-admin',
			'title' => '<span class="adler-icon">' . Get::svg('admin', 'logo/eagle') . '</span> Launch Semplice',
			'href'  => admin_url('admin.php?page=semplice-admin&ref=' . $current_page),
			'meta'  => array('class' => 'semplice-admin-button')
		);
		$wp_admin_bar->add_node($args);
	}

	// -----------------------------------------
	// admin page
	// -----------------------------------------

	public function admin_template() {
		require SEMPLICE_DIR . '/admin/index.php';
	}

	// -----------------------------------------
	// admin head
	// -----------------------------------------

	public function wp_admin_head($hook) {
		// get current screen
		$screen = get_current_screen();
		// show custom css only on semplice admin
		if($screen->id == 'toplevel_page_semplice-admin') {
			// webfonts
			$output = Customize::$setting['webfonts']->get();
			// css output
			$output .= '<style type="text/css" id="smp-css-default-fonts">' . Typography::setup_default_fonts() . '</style>';
			// placeholders (webfonts comes from webfonts->get())
			$head_placeholders = array(
				'grid',
				'typography',
				'typography-custom',
				'post',
				'nav',
				'projectnav',
				'advanced',
				'fluid-text',
				'thumbhover',
				'thumbhover-scale',
				'animate-post',
				'animate',
				'coverslider',
				'ov',
			);
			foreach ($head_placeholders as $key => $placeholder) {
				$output .= '<style type="text/css" id="smp-css-' . $placeholder . '"></style>';
			}
			// output
			echo $output;
		}
	}

	// -----------------------------------------
	// admin styles and scripts
	// -----------------------------------------

	public function enqueue($hook) {
		// ver
		$ver = SEMPLICE_VER;
		$uri = SEMPLICE_URI;
		// global semplice admin page
		global $semplice_admin_page;
		// get ref
		$ref = isset($_GET['ref']) ? $_GET['ref'] : '';
		// add to every page
		wp_enqueue_style('semplice-wp-css', $uri . '/assets/css/wp.css', false, $ver);
		// wp globals
		wp_enqueue_script('semplice-wp-globals', $uri . '/assets/js/wp.js', '', $ver, true);
		// only add scripts and styles for the semplice admin
		if ($hook == $semplice_admin_page) {
			// jquery ui parts
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-resizable');
			wp_enqueue_script('jquery-ui-tabs');
			// shared scripts
			wp_enqueue_script('semplice-shared-scripts', $uri . '/assets/js/shared.scripts.js', '', $ver, true);
			// admini scripts
			wp_enqueue_script('semplice-admin-scripts', $uri . '/assets/js/admin.scripts.js', '', $ver, true);
			// semplice admin
			wp_enqueue_script('semplice-admin', $uri . '/assets/js/admin.js', '', $ver, true);
			// frontend style.css
			wp_enqueue_style('semplice-stylesheet', SEMPLICE_STYLE_URI, array(), $ver);
			// fronted styles
			wp_enqueue_style('semplice-frontend-stylesheet', $uri . '/assets/css/frontend.css', false, $ver);
			// admin styles
			wp_enqueue_style('semplice-admin-stylesheet', $uri . '/assets/css/admin.css', false, $ver);
			// admin js localize script
			wp_localize_script('semplice-admin', 'sempliceWp', $this->localize_script());
		} else {
			// register gutenberg styles
			wp_enqueue_script('semplice-gutenberg', get_template_directory_uri() . '/assets/js/gutenberg.js', array('wp-blocks','wp-dom'), $ver, true);
			// gutenberg styles
			wp_enqueue_style('semplice-gutenberg-stylesheet', get_template_directory_uri() . '/assets/css/gutenberg.css', false, $ver);
			// localize script
			wp_localize_script('semplice-gutenberg', 'sempliceGutenberg', $this->localize_gutenberg());
		}
	}

	// -----------------------------------------
	// localize script
	// -----------------------------------------

	public function localize_script() {
		$semplice = array(
			'nonce'  			=> wp_create_nonce('wp_rest'),
			'info'				=> array(
				'version' 		=> SEMPLICE_VER,
				'edition'		=> SEMPLICE_EDITION
			),
			'siteName'			=> get_bloginfo('name'),
			'api'				=> array(
				'default' 		=> untrailingslashit(RestApi::rest_url()),
				'admin'			=> untrailingslashit(RestApi::rest_url()) . '/semplice/v1/admin',
				'editor'		=> untrailingslashit(RestApi::rest_url()) . '/semplice/v1/editor'
			),
			'url'				=> array(
				'origin'		=> isset($_GET['ref']) ? $_GET['ref'] : '',
				'admin'			=> admin_url(),
				'base'			=> home_url()
			),
			'epSize'			=> (get_option('semplice_ep_size')) ? get_option('semplice_ep_size') : 'regular',
			'phpError'			=> version_compare(phpversion(), '7.0', '<'),
			'templateDir'		=> SEMPLICE_URI,
			'customize'			=> array(),
			'settings'			=> array(
				'general'		=> Get::general_settings()
			),
			'atts'				=> Atts::generate(),
			'defaults'			=> array(
				'ram'			=> json_decode(file_get_contents(SEMPLICE_DIR . '/assets/json/defaults/ram.json')),
				'navRam'		=> json_decode(file_get_contents(SEMPLICE_DIR . '/assets/json/defaults/nav-ram.json'))
			),
			'navigations'		=> array(
				'presetIds'		=> Get::nav_preset_ids(),
				'presets'		=> Get::nav_presets()
			),
			'defaultFonts'		=> json_decode(file_get_contents(SEMPLICE_DIR . '/assets/json/fonts.json')),
			'icons'				=> Get::admin_icons(),
			'upload'			=> array(
				'mimeTypes'		=> Get::mime_types(),
				'maxSize'		=> Get::max_upload_size()
			),
			'postQueries'		=> array(
				'taxonomy'		=> array(
					'category'		=> PostQueries::taxonomy_checklist('category'),
					'post_tag'		=> PostQueries::taxonomy_checklist('tag'),
					'author'		=> PostQueries::taxonomy_checklist('author'),
				),
				'apg'			=> PostQueries::get_apg_posts('content', false),
				'blogposts'		=> PostQueries::blogposts_checklist('')
			),
			'socialProfiles'	=> Get::social_profiles(),
			'license'			=> License::get(),
			'update'			=> License::has_update(),
			'projectsView'		=> Get::projects_view(),
			'adminImages'		=> Image::admin_images(),
			'colors'			=> Color::get_custom(),
			'transitionPresets' => json_decode(file_get_contents(SEMPLICE_DIR . '/assets/json/defaults/transition-presets.json'), true),
			'animatePresets'	=> Get::animate_presets(),
			'editorNotices'		=> Get::editor_notices(),
			'whatsNew'			=> Basic::whats_new(),
			'hasYoast'			=> (is_plugin_active('wordpress-seo/wp-seo.php') || is_plugin_active('wordpress-seo-premium/wp-seo-premium.php')) ? true : false,
			'onboarding'		=> array(
				'setup'			=> Onboarding::setup(),
				'content'		=> Onboarding::content()
			)
		);
		// get customize settings
		$customize = array('grid', 'webfonts', 'navigations', 'typography', 'projectnav', 'thumbhover', 'transitions', 'intro', 'blog', 'advanced', 'cursor', 'ppc');
		foreach($customize as $setting) {
			// change setting for project nav
			$db_setting = ($setting == 'projectnav') ? 'projectpanel' : $setting;
			$semplice['customize'][$setting] = json_decode(get_option('semplice_customize_' . $db_setting));
		}
		// return
		return $semplice;
	}

	// -----------------------------------------
	// localize script
	// -----------------------------------------

	public function localize_gutenberg() {
		// output
		$options = array(
			'customStyles' => false
		);
		// typography
		$typography = Get::customize('typography');
		if($typography && !empty($typography['custom'])) {
			// make array
			$options['customStyles'] = array();
			// itearte custom styles
			foreach($typography['custom'] as $id => $attributes) {
				$options['customStyles'][$id] = $attributes['custom_style_name'];
			}
		}
		// return
		return $options;
	}

	// -----------------------------------------
	// meta box
	// -----------------------------------------

	public function metabox() {
		// add our semplice status metabox
		add_meta_box('_is_semplice', 'Semplice Status', array(&$this, 'metabox_output'), 'page', 'normal', 'high', null);
	}

	// -----------------------------------------
	// meta box output
	// -----------------------------------------

	public function metabox_output($object) {
		// metabox nonce
		wp_nonce_field(basename(__FILE__), 'semplice_metabox_nonce');
		// get is semplice
		$is_semplice = get_post_meta($object->ID, '_is_semplice', true);
		// button prefix
		$prefix = 'Activate';
		// set status
		if(empty($is_semplice)) {
			// set vars
			$is_semplice = 0;
			$status = 'inactive';
		} else {
			if(false !== $is_semplice) {
				$status = 'active';
				$prefix = 'Deactivate';
			} else {
				$status = 'inactive';
			}
		}
		// output html
		echo '
			<div class="activate-semplice" data-semplice-status="' . $status . '">
				<div class="content">
					<div class="active">' . Get::svg('admin', 'meta-box/is_semplice') . '</div>
					<div class="inactive">' . Get::svg('admin', 'meta-box/is_not_semplice') . '</div>
					<p>If activated the content from our editor will get displayed in the frontend instead of the content from the default WordPress editor.</p>
					<a class="activate-semplice-button">' . $prefix . ' Semplice</a>
				</div>
			</div>
			<input name="_is_semplice" class="is-semplice" type="text" value="' . $is_semplice . '">
		';
	}

	// -----------------------------------------
	// remove revisions from deleted posts
	// -----------------------------------------

	public function revisions() {
		add_action('delete_post', array(&$this, 'syncH_revisions'), 10);
	}

	// -----------------------------------------
	// synch revisions
	// -----------------------------------------

	public function synch_revisions($post_id) {
		// if post id is still in revisions, delete it
		if ($this->db->get_var("SELECT post_id FROM " . SEMPLICE_REV_TABLE . " WHERE post_id = '$post_id'")) {
			$this->db->delete(SEMPLICE_REV_TABLE, array('post_id' => $post_id), array( '%d'));
		}
	}

	// -----------------------------------------
	// save post
	// -----------------------------------------

	public function save_post($post_id) {
		// Checks save status
		$is_autosave = wp_is_post_autosave($post_id);
		$is_revision = wp_is_post_revision($post_id);
		$is_valid_nonce = (isset($_POST['semplice_metabox_nonce']) && isset($_POST['prfx_nonce']) && wp_verify_nonce($_POST['prfx_nonce'], basename( __FILE__ ))) ? 'true' : 'false';
		// Exits script depending on save status
		if ($is_autosave || $is_revision || !$is_valid_nonce) {
			 return;
		}
		// Checks for input and sanitizes/saves if needed
		if(isset($_POST['_is_semplice'])) {
			update_post_meta($post_id, '_is_semplice', sanitize_text_field($_POST['_is_semplice']));
		}
		// save portfolio order
		PostQueries::save_portfolio_order($post_id);
	}
}

new ThemeAdmin;