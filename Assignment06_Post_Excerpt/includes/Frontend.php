<?php


namespace A06_Post_Excerpt;


use A06_Post_Excerpt\Frontend\Latext_Post_Excerpts;

class Frontend {
	public function __construct() {
		new Latext_Post_Excerpts();
	}
}