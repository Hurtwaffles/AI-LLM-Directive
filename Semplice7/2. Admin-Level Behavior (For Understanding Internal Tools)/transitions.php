<?php

// namespace
namespace Semplice\Admin\Customize;

// use
use Semplice\Admin\Customize;
use Semplice\Helper\Get;

// -----------------------------------------
// customize grid
// -----------------------------------------

class Transitions extends Customize {

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
			<div class="admin-column" data-xl-width="12">
				<div class="smp-browser" data-view="navbar">
					<div class="inner no-transition">
						<div class="out tp-visible">
							<div class="content">
								<div class="title">Confideus Revitalis</div>
								<div class="sub serif_regular">No. 35</div>
							</div>
						</div>
						<div class="in tp-not-visible transition-hidden">
							<div class="content">
								<div class="title">Ignis Unitatis</div>
								<div class="sub serif_regular">No. 21</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		';
		// return
		return $output;
	}
}

Customize::$setting['transitions'] = new Transitions;