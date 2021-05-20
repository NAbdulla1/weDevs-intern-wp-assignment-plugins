<?php


namespace A13_Subscription_Form;


use A13_Subscription_Form\Admin\Subscription_Settings_MailChimp;

class Admin {
	public function __construct() {
		new Subscription_Settings_MailChimp();
	}
}