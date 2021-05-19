<?php


namespace A08_Featured_Post;


use A08_Featured_Post\Frontend\Show_Featured_Posts_Shortcode;

class Frontend {
	public function __construct() {
		new Show_Featured_Posts_Shortcode();
	}
}