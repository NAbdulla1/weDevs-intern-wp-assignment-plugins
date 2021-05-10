<?php


namespace A05_Contact_Form;


use A05_Contact_Form\Shortcode\ContactForm;

class Frontend {
	public function __construct() {
		new ContactForm();
	}
}