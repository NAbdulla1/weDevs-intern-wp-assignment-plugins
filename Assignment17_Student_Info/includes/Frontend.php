<?php


namespace A17_STUDENT_INFO;


use A17_STUDENT_INFO\Frontend\Student_Info_Display_Shortcode;
use A17_STUDENT_INFO\Frontend\Student_Input_Shortcode;

/**
 * Manages frontend specific features
 * Class Frontend
 * @package A17_STUDENT_INFO
 */
class Frontend {
	public function __construct() {
		new Student_Input_Shortcode();
		new Student_Info_Display_Shortcode();
	}
}