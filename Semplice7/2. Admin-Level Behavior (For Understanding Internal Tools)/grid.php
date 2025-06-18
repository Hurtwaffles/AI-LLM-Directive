<?php

// namespace
namespace Semplice\Admin\Customize;

// use
use Semplice\Admin\Customize;
use Semplice\Helper\Get;

// -----------------------------------------
// customize grid
// -----------------------------------------

class Grid extends Customize {

	// -----------------------------------------
	// constructor
	// -----------------------------------------

	public function __construct() {}

	// -----------------------------------------
	// init
	// -----------------------------------------

	public function init() {
		// uri
		$uri = SEMPLICE_URI;
		// define output
		$output = '
			<div class="admin-column browser-pb" data-xl-width="12">
				<div class="smp-browser" data-view="navbar">
					<div class="inner">
						' . Get::background_grid('customize-bg-grid') . '
						<div id="content-holder" class="grid-content" data-breakpoint="xl">
							<smp-section>
								<smp-container>
									<smp-row>
										<smp-column data-xl-width="6">
											<smp-content-wrapper>
												<smp-content><img src="' . $uri . '/assets/images/admin/customize/grid/header-top.svg' . '" alt="grid-content"></smp-content>
											</smp-content-wrapper>
										</smp-column>
									</smp-row>
									<smp-row class="header-sub">
										<smp-column data-xl-width="4">
											<smp-content-wrapper>
												<smp-content><img src="' . $uri . '/assets/images/admin/customize/grid/header-sub.svg' . '" alt="grid-content"></smp-content>
											</smp-content-wrapper>
										</smp-column>
									</smp-row>
									<smp-row>
										<smp-column data-xl-width="4">
											<smp-content-wrapper>
												<smp-content><img src="' . $uri . '/assets/images/admin/customize/grid/left-top.svg' . '" alt="grid-content"></smp-content>
												<smp-content><img src="' . $uri . '/assets/images/admin/customize/grid/left-bottom.png' . '" alt="grid-content"></smp-content>
											</smp-content-wrapper>
										</smp-column>
										<smp-column data-xl-width="4">
											<smp-content-wrapper>
												<smp-content><img src="' . $uri . '/assets/images/admin/customize/grid/center.png' . '" alt="grid-content"></smp-content>
											</smp-content-wrapper>
										</smp-column>
										<smp-column data-xl-width="4">
											<smp-content-wrapper>
												<smp-content><img src="' . $uri . '/assets/images/admin/customize/grid/right-top.png' . '" alt="grid-content"></smp-content>
												<smp-content><img src="' . $uri . '/assets/images/admin/customize/grid/right-bottom.svg' . '" alt="grid-content"></smp-content>
											</smp-content-wrapper>
										</smp-column>
									</smp-row>
								</smp-container>
							</smp-section>
						</div>
					</div>
				</div>
			</div>
		';
		// return
		return $output;
	}

	// -----------------------------------------
	// css
	// -----------------------------------------

	public function css($is_frontend) {
		// get grid
		$values = Get::customize('grid');
		// is array?
		if(is_array($values)) {
			// defaults
			$grid = array(
				'width' 			=> 1170,
				'outer_padding' 	=> 30,
				'gutter' 			=> 30,
				'responsive_gutter'	=> 30
			);
			// iterate
			foreach($grid as $attr => $val) {
				if(isset($values[$attr])) {
					$grid[$attr] = intVal($values[$attr]);
				}
			}
			// make sure grid with is 1170 minimum
			$grid['width'] = ($grid['width'] < 1170) ? 1170 : $grid['width'];
			// assign to css variables
			$css = '
				smp-container {
					--smp-grid-width-desktop: ' . ($grid['width'] + ($grid['outer_padding'] * 2)) . 'px;
				}
				smp-row, .grid-row, .admin-row, smp-column, .grid-column, .admin-column {
					--smp-grid-gap-desktop: ' . (round($grid['gutter'] / 18, 5)) . 'rem;
					--smp-grid-gap-mobile: ' . (round($grid['responsive_gutter'] / 18, 5)) . 'rem;
				}
			';
			// add outer padding only for frontend
			if($is_frontend) {
				$css .= '
					smp-container {
						--smp-grid-outer-desktop: ' . (round($grid['outer_padding'] / 18, 5)) . 'rem;
					}
				';
			}
			return $css;
		}
	}
}

Customize::$setting['grid'] = new Grid;