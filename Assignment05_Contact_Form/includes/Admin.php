<?php


namespace A05_Contact_Form;


use A05_Contact_Form\Admin\Menu;

/**
 * Class Admin
 * @package A05_Contact_Form
 */
class Admin {
	public function __construct() {
		new Menu();
	}
}