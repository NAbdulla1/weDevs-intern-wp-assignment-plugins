<?php


namespace A07_Book_Review;


use A07_Book_Review\Admin\Books_Meta_Boxes;

class Admin {
	public function __construct() {
		new Books_Meta_Boxes();
	}
}
