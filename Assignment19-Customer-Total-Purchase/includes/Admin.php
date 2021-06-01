<?php


namespace A19_Custom_Total_Purchase;


use A19_Custom_Total_Purchase\Admin\Customer_Label_Box;

class Admin {
	public function __construct() {
		new Customer_Label_Box();
	}
}