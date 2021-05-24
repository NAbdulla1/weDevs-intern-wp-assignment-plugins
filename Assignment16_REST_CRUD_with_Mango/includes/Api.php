<?php


namespace A16_Rest_CRUD_Mango;


use A16_Rest_CRUD_Mango\Api\MangoApi;

/**
 * Class Api
 * This class is responsible to initializing the REST API by calling other functionality classes
 * @package A16_Rest_CRUD_Mango
 */
class Api {
	/**
	 * Api constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'initialize_rest_api' ] );
	}

	/**
	 * initializes the Api routes and endpoints
	 */
	public function initialize_rest_api() {
		$mango = new MangoApi();
		$mango->register_routes();
	}
}
