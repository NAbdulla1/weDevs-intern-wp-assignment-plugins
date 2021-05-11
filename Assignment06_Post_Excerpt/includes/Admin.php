<?php


namespace A06_Post_Excerpt;


use A06_Post_Excerpt\Admin\Post_Excerpt_Metabox;

class Admin {

	public function __construct() {
		new Post_Excerpt_Metabox();
	}
}