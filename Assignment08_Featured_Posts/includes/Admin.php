<?php


namespace A08_Featured_Post;


use A08_Featured_Post\Admin\Featured_Posts_Settings;
use A08_Featured_Post\Admin\Settings_Options_Page;

class Admin {
	public function __construct() {
		new Featured_Posts_Settings();
		new Settings_Options_Page();
	}
}