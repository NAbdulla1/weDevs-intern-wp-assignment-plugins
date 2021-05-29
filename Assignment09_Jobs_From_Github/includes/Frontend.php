<?php


namespace A09_Jobs_From_Github;


use A09_Jobs_From_Github\Frontend\Job_List_Shortcode;
use A09_Jobs_From_Github\Frontend\Single_Job_Shortcode;

/**
 * manages frontend specific class initialization
 * Class Frontend
 * @package A09_Jobs_From_Github
 */
class Frontend {
	public function __construct() {
		new Job_List_Shortcode();
		new Single_Job_Shortcode();
	}
}