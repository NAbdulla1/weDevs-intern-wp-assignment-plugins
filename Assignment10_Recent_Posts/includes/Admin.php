<?php


namespace A10_RP;


use A10_RP\Admin\Recent_Posts_Widget;

class Admin {
	public function __construct() {
		new Recent_Posts_Widget();
	}
}