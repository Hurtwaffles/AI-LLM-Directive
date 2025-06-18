<?php

// namespace
namespace Semplice\Admin\Customize;

// use
use Semplice\Admin\Customize;
use Semplice\Helper\Get;
use Semplice\Helper\Typography;

// -----------------------------------------
// customize grid
// -----------------------------------------

class CustomizeTypography extends Customize {

	// -----------------------------------------
	// constructor
	// -----------------------------------------

	public function __construct() {}

	// -----------------------------------------
	// init
	// -----------------------------------------

	public function init() {
		return '
			<div class="admin-column" data-xl-width="12">
				<div id="content-holder" class="typography-wrapper" data-active-tab="defaults">
					<div class="typography-tabs">
						<div class="typography-tab defaults click-handler active-tab" data-handler="run" data-action-type="customize" data-setting-type="typography" data-action="toggleTab" data-tab="defaults">Defaults</div>
						<div class="typography-tab custom click-handler"  data-handler="run" data-action-type="customize" data-setting-type="typography" data-action="toggleTab" data-tab="custom">Custom Styles</div>
					</div>
					<div class="typography-defaults">
						<div class="heading-1 typography-heading">
							<p class="title">Heading H1</p>
							<h1 class="preview-h1">Designed to be used and loved by millions. Made with pride by HOVS.</h1>
						</div>
						<div class="full-width-img full-width-top">
							<img src="' . SEMPLICE_URI . '/assets/images/admin/customize/typography/full-width.svg">
						</div>
						<div class="two-columns">
							<div class="left">
								<div class="heading-2 typography-heading">
									<p class="title">Heading H2</p>
									<h2 class="preview-h2">Designed to be used and loved by millions. Made with pride by HOVS.</h2>
								</div>
							</div>
							<div class="right">
								<div class="paragraph is-content">
									<p class="title">Paragraph<span class="line-height-px">test</p>
									<p class="preview-p">For the first time in a half-century, an American-built spacecraft has landed on the moon. The robotic lander was the first U.S. vehicle on the moon since Apollo 17 in 1972, the closing chapter in humanity’s astonishing achievement of sending people to the moon and bringing them all back alive. That is a feat that has not been repeated since.
									</p>
									<p class="preview-p">The lander, named Odysseus and a bit bigger than a telephone booth, arrived in the south polar region of the moon at 6:23 p.m. Eastern time on Thursday. The landing time came and went in silence as flight controllers waited to hear confirmation of success. A brief communication pause was expected, but minutes passed.
									</p>
								</div>
							</div>
						</div>
						<div class="two-columns">
							<div class="left">
								<div class="full-width-img">
									<img src="' . SEMPLICE_URI . '/assets/images/admin/customize/typography/full-width-2.svg">
								</div>
							</div>
							<div class="right">
								<div class="heading-3 typography-heading">
									<p class="title">Heading H3</p>
									<h3 class="preview-h3">Designed to be used and loved by millions. Made with pride by HOVS.</h3>
								</div>
							</div>
						</div>
						<div class="heading-4 typography-heading">
							<p class="title">Heading H4</p>
							<h4 class="preview-h4">Designed to be used and loved by millions. Made with pride by HOVS.</h4>
						</div>
						<div class="two-columns">
							<div class="left">
								<div class="heading-5 typography-heading">
									<p class="title">Heading H5</p>
									<h5 class="preview-h5">Designed to be used and loved by millions. Made with pride by HOVS.</h5>
								</div>
							</div>
							<div class="right">
								<div class="heading-6 typography-heading">
									<p class="title">Heading H6</p>
									<h6 class="preview-h6">Designed to be used and loved by millions. Made with pride by HOVS.</h6>
								</div>
							</div>
						</div>
					</div>
					<div class="typography-custom">
						<div class="add-custom-style-wrapper">
							<button class="add-custom-style" data-button-color="dark-gray" data-button-icon="plus" data-button-icon-color="white"><span></span>Add Custom Style</button>
							<div class="custom-style-buttons">
								<div class="click-handler inline" data-handler="run" data-action-type="customStyles" data-action="add" data-type="inline">
									<div class="icon">' . Get::svg('admin', 'customize/typography/inline') . '</div>
									<p>Inline Style<span>Your style is only applied to your active text selection.</span></p>
								</div>
								<div class="click-handler inline" data-handler="run" data-action-type="customStyles" data-action="add" data-type="block">
									<div class="icon">' . Get::svg('admin', 'customize/typography/block') . '</div>
									<p>Block<span>Your style is applied to the complete text block.</span></p>
								</div>
							</div>
						</div>
						<ul class="custom-styles"></ul>
					</div>
				</div>
			</div>
		';
	}

	// -----------------------------------------
	// get
	// -----------------------------------------

	public function get($is_admin, $is_customize) {
		// vars
		$output = '';
		$fonts = array();
		// get navigation json
		$typography = Get::customize('typography');
		// has changes?
		if(is_array($typography)) {
			// elements
			$elements = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');
			// iterate elements
			foreach ($elements as $attribute) {
				// set default to fonts array
				$fonts[$attribute] = '';
				// is paragraph?
				if($attribute == 'p') {
					$attribute_css = 'p, #content-holder smp-content li';
				} else {
					$attribute_css = $attribute;
				}
				// prefix
				$prefix = '#content-holder ' . $attribute_css . ' { ';
				// is customization on?
				if(isset($typography[$attribute . '_customize']) && $typography[$attribute . '_customize'] == 'on' || $attribute == 'p') {
					// attribute css
					$attr_css = '';
					// font family
					if(isset($typography[$attribute . '_font_family'])) {
						// add font to array
						$fonts[$attribute] = ' data-font="' . $typography[$attribute . '_font_family'] . '"';
					}
					// font size
					if(isset($typography[$attribute . '_font_size'])) {
						$attr_css .= 'font-size: ' . $typography[$attribute . '_font_size'] . ';';
					}
					// line height
					if(isset($typography[$attribute . '_line_height'])) {
						$attr_css .= 'line-height: ' . $typography[$attribute . '_line_height'] . ';';
					}
					// letter spacing
					if(isset($typography[$attribute . '_letter_spacing'])) {
						$attr_css .= 'letter-spacing: ' . $typography[$attribute . '_letter_spacing'] . ';';
					}
					// is empty?
					if(!empty($attr_css)) {
						// css open
						$output .= $prefix;
						// add attr css
						$output .= $attr_css;
						// css close
						$output .= '}';
					}
				}
			}
			// change margin bottom of the paragraph
			if(isset($typography['p_line_height'])) {
				$output .= '#content-holder .is-content p { margin-bottom: ' . $typography['p_line_height'] . 'rem; }';
			}
		} else {
			$fonts = array(
				'h1' => '',
				'h2' => '',
				'h3' => '',
				'h4' => '',
				'h5' => '',
				'h6' => '',
				'p'  => '',
			);
		}
		// add custom styles css
		$output .= $this->custom_styles($typography, $is_admin, $is_customize);
		// add mobile scaling to css
		$output .= $this->mobile_scaling($typography, $is_admin);
		// return
		return $output;
	}

	// -----------------------------------------
	// custom styles
	// -----------------------------------------

	public function custom_styles($typography, $is_admin, $is_customize) {
		// define vars
		$output = '';
		// get breakpoints
		$breakpoints = Get::breakpoints();
		// css attributes
		$css_attributes = array('color', 'text-transform', 'font-family', 'font-size', 'line-height', 'letter-spacing', 'text-decoration', 'text-decoration-color', 'background-color', 'text-stroke', 'padding', 'border-color', 'border-width', 'border-style');
		// has any custom styles?
		if(isset($typography['custom']) && is_array($typography['custom'])) {
			// iterate custom styles
			foreach ($typography['custom'] as $id => $style) {
				// css
				$css = '';
				// empty mobile css
				$mobile_css = array(
					'lg' => '',
					'md' => '',
					'sm' => '',
					'xs' => ''
				);
				// styles list
				$styles_list = $css_attributes;
				// element
				$element = 'span';
				if($style['custom_style_element'] == 'block') {
					$element = 'p';
				} else {
					// remove line-height and font-size from inline styles
					unset($styles_list[3]);
					unset($styles_list[4]);
				}
				// start output
				$custom_blog_selector = '#content-holder .blogposts .blogposts-column .blogposts-content p.is-style-' . $id;
				$default_blog_selector = '#content-holder .posts .post .post-content p.is-style-' . $id;
				$selector = '#customize #' . $id . ' ' . $element . ', #content-holder .' . $id . ', ' . $custom_blog_selector . ', ' . $default_blog_selector;
				// search and replace
				$search = array('custom_style_', '_', '-lg', '-md', '-sm', '-xs');
				$replace = array('', '-', '', '', '', '');
				// iterate styles
				foreach ($style as $attribute => $value) {
					$css_attribute = str_replace($search, $replace, $attribute);
					if(in_array($css_attribute, $styles_list)) {
						// is mobile style
						$is_mobile = false;
						// mobile css
						foreach ($breakpoints as $breakpoint => $width) {
							if(strpos($attribute, '_' . $breakpoint) !== false) {
								$mobile_css[$breakpoint] .= $this->custom_style_css($css_attribute, $value, $style['custom_style_text_stroke_color']);
								$is_mobile = true;
							}
						}
						// regular css
						if(!$is_mobile) {
							$css .= $this->custom_style_css($css_attribute, $value, $style['custom_style_text_stroke_color']);
						}
					}
				}
				// add regular css
				$output .= $selector . ' { ' . $css . ' }';
				// iterate breakpoints for mobile css
				foreach ($breakpoints as $breakpoint => $width) {
					if(!empty($mobile_css[$breakpoint])) {
						if($is_admin) {
							$selector = '[data-breakpoint="' . $breakpoint . '"] #content-holder .' . $id;
							$output .= $selector . ' { ' . $mobile_css[$breakpoint] . ' }';
						} else {
							$output .= '@media screen' . $width['min'] . $width['max'] . ' { ' . $selector . ' { ' . $mobile_css[$breakpoint] . ' } }';
						}
					}
				}
			}
		}
		// return
		return $output;
	}

	// -----------------------------------------
	// custom styles css
	// -----------------------------------------

	public function custom_style_css($attribute, $value, $text_stroke_color) {
		// switch attribute
		switch($attribute) {
			case 'text-stroke':
				return '-webkit-text-stroke: ' . $value . ' ' . $text_stroke_color . ';';
			break;
			case 'font-family':
				return Typography::get_font_family($value);
			break;
			default:
				return $attribute . ':' . $value . ';';
		}
	}

	// -----------------------------------------
	// mobile scaling
	// -----------------------------------------

	public function mobile_scaling($typography, $is_admin) {
		// output start
		$output = '';
		// get typography settings
		$typography = Get::customize('typography');
		// breakpoints
		$breakpoints = array(
			'lg' => '@media screen and (min-width: 992px) and (max-width: 1169.98px) { ',
			'md' => '@media screen and (min-width: 768px) and (max-width: 991.98px) { ',
			'sm' => '@media screen and (min-width: 544px) and (max-width: 767.98px) { ',
			'xs' => '@media screen and (max-width: 543.98px) { ',
		);
		// values
		$attributes = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');
		// loop through
		foreach ($breakpoints as $breakpoint => $prefix) {
			// empty css
			$css = '';
			// is editor
			if($is_admin) {
				$attr_prefix = '[data-breakpoint="' . $breakpoint . '"] #content-holder ';
			} else {
				$attr_prefix = '#content-holder ';
			}
			// loop throught defaults
			foreach ($attributes as $attribute) {
				// check if user has a size set in typography
				if(isset($typography[$attribute . '_font_size_' . $breakpoint])) {
					$size = str_replace('rem', '', $typography[$attribute . '_font_size_' . $breakpoint]) * 18;
					// add to css
					$css .= $attr_prefix . $attribute . ' { font-size: ' . round($size / 18, 2) . 'rem;}';
				}
				// check if user has a line height set in typography, if not use semplice multiplier
				if(isset($typography[$attribute . '_line_height_' . $breakpoint])) {
					if($attribute == 'p') {
						$lh = $typography[$attribute . '_line_height_' . $breakpoint];
					} else {
						$lh = str_replace('rem', '', $typography[$attribute . '_line_height_' . $breakpoint]) * 18;
						$lh = round($lh / 18, 2) . 'rem';
					}
					// add to css
					$css .= $attr_prefix . $attribute . ' { line-height: ' . $lh . '; }';
				}
				// check if user has a letter spacing set in typography
				if(isset($typography[$attribute . '_letter_spacing_' . $breakpoint])) {
					$size = str_replace('rem', '', $typography[$attribute . '_letter_spacing_' . $breakpoint]) * 18;
					// add to css
					$css .= $attr_prefix . $attribute . ' { letter-spacing: ' . round($size / 18, 2) . 'rem;}';
				}
			}
			// output start
			$output .= ($is_admin) ? $css : $prefix . $css . '}';
		}
		// return
		return $output;
	}
}

Customize::$setting['typography'] = new CustomizeTypography;