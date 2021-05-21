<?php


namespace A14_Author_Box;


use A14_Author_Box\Frontend\Author_Box_In_Single_Post;

class Frontend {
	public function __construct() {
		new Author_Box_In_Single_Post();
	}
}