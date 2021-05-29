<?php


namespace A05_Contact_Form;


use A05_Contact_Form\Shortcode\ContactForm;

/**
 * Class Frontend
 * @package A05_Contact_Form
 */
class Frontend {
	public function __construct() {
		new ContactForm();
	}
}