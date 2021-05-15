<?php


namespace A07_Book_Review;

use A07_Book_Review\Frontend\Copy_Custom_Post_Template;
use A07_Book_Review\Frontend\Search_Book_By_Meta;

class Frontend {
	public function __construct() {
		new Copy_Custom_Post_Template();
		new Search_Book_By_Meta();
	}
}