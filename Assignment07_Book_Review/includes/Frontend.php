<?php


namespace A07_Book_Review;

use A07_Book_Review\Frontend\Copy_Custom_Post_Template;

class Frontend {
	public function __construct() {
		new Copy_Custom_Post_Template();
	}
}