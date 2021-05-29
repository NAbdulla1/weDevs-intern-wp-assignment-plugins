<?php


namespace A11_CF;

use A11_CF\Admin\Cats_Fact_Widget;

/**
 * Class to maintain Admin section tasks
 */
class Admin {
	/**
	 * Constructor
	 */
	public function __construct() {
		new Cats_Fact_Widget();
	}
}