<?php


namespace A07_Book_Review;


use A07_Book_Review\Admin\Books_Meta_Boxes;

/**
 * Class Admin
 * @package A07_Book_Review
 */
class Admin {
	public function __construct() {
		new Books_Meta_Boxes();
	}
}
