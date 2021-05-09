<?php


namespace A04_Vertical_Button;


use A04_Vertical_Button\Admin\Admin_Vertical_Button;

/**
 * Admin section activity of this plugin starts here
 * @package A04_Vertical_Button
 */
class Admin {
	public function __construct() {
		new Admin_Vertical_Button();
	}
}