<?php


namespace A02_Posts_View_Counter;


use A02_Posts_View_Counter\Frontend\View_Counter;

class Frontend {

	public function __construct() {
		new View_Counter();
	}
}