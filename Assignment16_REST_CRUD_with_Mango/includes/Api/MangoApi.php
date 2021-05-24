<?php


namespace A16_Rest_CRUD_Mango\Api;


use stdClass;
use WP_Error;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * Class MangoApi
 * @package A16_Rest_CRUD_Mango\Api
 */
class MangoApi extends WP_REST_Controller {
	private Mangoes_Repository $mango_db;

	/**
	 * MangoApi constructor.
	 */
	public function __construct() {
		$this->mango_db  = new Mangoes_Repository();
		$this->namespace = 'a16_rest_crud/v1';
		$this->rest_base = 'mangoes';
	}

	/**
	 * Registers routes for the the api
	 */
	public function register_routes() {
		register_rest_route( $this->namespace,
			'/' . $this->rest_base,
			array(
				array(//for GET request at '/a16_rest_crud/v1/mangoes'
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, "get_items_permissions_check" ),
					'args'                => $this->get_collection_params()
				),
				array(//for POST request at '/a16_rest_crud/v1/mangoes'
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_item' ),
					'permission_callback' => array( $this, "create_item_permissions_check" ),
					'args'                => $this->get_endpoint_args_for_item_schema(),
				),
				'schema' => [ $this, 'get_item_schema' ],
			),
		);

		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base . '/(?P<id>[\d]+)',
			array(
				'args'   => array(
					'id' => array(//the url parameter
						'description' => __( 'Unique identifier for a Mango object', A16_REST_CRUD_TD ),
						'type'        => 'integer',
					)
				),
				array(//for GET Request at '/a16_rest_crud/v1/mangoes/{integer}
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, "get_item" ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
					'args'                => array(
						'context' => $this->get_context_param( array( 'default' => 'view' ) )
					),
				),
				array(//for DELETE Request at '/a16_rest_crud/v1/mangoes/{integer}
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, "delete_item" ),
					'permission_callback' => array( $this, 'delete_item_permissions_check' ),
					'args'                => array(
						'context' => $this->get_context_param( array( 'default' => 'view' ) )
					),
				),
				array(//for PATCH Request at '/a16_rest_crud/v1/mangoes/{integer}
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, "update_item" ),
					'permission_callback' => array( $this, 'update_item_permissions_check' ),
					'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
				),
				'schema' => $this->get_item_schema()
			)
		);
	}

	/**
	 * Checks if a given request has access to get items. Returning true so that this end point becomes available publicly
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return true True if the request has read access, WP_Error object otherwise.
	 * @since 4.7.0
	 *
	 */
	public function get_items_permissions_check( $request ) {
		/*if ( ! current_user_can( 'read' ) ) {
			return new WP_Error( 'unauthorized', __( 'Unauthorized to access resource', A16_REST_CRUD_TD ), array( 'status' => 401 ) );
		}*/

		return true;
	}

	/**
	 * Retrieves a collection of items.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 * @since 4.7.0
	 *
	 */
	public function get_items( $request ) {
		$args       = array();
		$url_params = $this->get_collection_params();
		foreach ( $url_params as $key => $value ) {
			if ( isset( $request[ $key ] ) ) {
				$args[ $key ] = $request[ $key ];
			}
		}

		$per_page = (int) $args['per_page'];
		$page     = (int) $args['page'];

		$ret_data = array();
		$mangoes  = $this->mango_db->get_mangoes( array(
			'per_page' => $per_page,
			'offset'   => ( $page - 1 ) * $per_page
		) );

		foreach ( $mangoes as $mango ) {
			$item = $this->prepare_item_for_response( $mango, $request );
			array_push( $ret_data, $this->prepare_response_for_collection( $item ) );
		}

		$response = rest_ensure_response( $ret_data );
		$total    = $this->mango_db->get_total_count();
		$pages    = (int) ( ( $total + $per_page - 1 ) / $per_page );

		$response->header( 'X-WP-Total', $total, true );
		$response->header( 'X-WP-TotalPages', $pages, true );

		return $response;
	}

	/**
	 * Checks if a given request has access to get a specific item. Returning true so that this end point becomes available publicly
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return true|WP_Error True if the request has read access for the item, WP_Error object otherwise.
	 * @since 4.7.0
	 *
	 */
	public function get_item_permissions_check( $request ) {
		/*if ( ! current_user_can( 'read' ) ) {
			return new WP_Error( 'unauthorized', __( 'Unauthorized to access resource', A16_REST_CRUD_TD ), array( 'status' => 401 ) );
		}*/
		$mango = $this->get_mango( $request['id'] );

		if ( is_wp_error( $mango ) ) {
			return $mango;
		}

		return true;
	}

	/**
	 * Retrieves one item from the collection.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 * @since 4.7.0
	 *
	 */
	public function get_item( $request ) {
		$mango    = $this->get_mango( $request['id'] );
		$response = $this->prepare_item_for_response( $mango, $request );

		return rest_ensure_response( $response );
	}

	/**
	 * Checks if a given request has access to create items.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return true|WP_Error True if the request has access to create items, WP_Error object otherwise.
	 * @since 4.7.0
	 *
	 */
	public function create_item_permissions_check( $request ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'rest_create_forbidden', __( 'User doesn\'t have sufficient permission', A16_REST_CRUD_TD ),
				array( 'status' => 403 ) );
		}

		return true;
	}

	/**
	 * Creates one item from the collection.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 * @since 4.7.0
	 *
	 */
	public function create_item( $request ) {
		$mango = $this->prepare_item_for_database( $request );

		if ( is_wp_error( $mango ) ) {
			return $mango;
		}

		$new_mango_id = $this->mango_db->create_update_mango( $mango );

		if ( is_wp_error( $new_mango_id ) ) {
			$new_mango_id->add_data( array( 'status' => 400 ) );

			return $new_mango_id;//actually a WP Error object
		}

		$mango    = $this->get_mango( $new_mango_id );
		$response = $this->prepare_item_for_response( $mango, $request );
		$response->set_status( 201 );
		$response->header( 'Location', rest_url( $this->namespace . '/' . $this->rest_base . '/' . $new_mango_id ) );

		return rest_ensure_response( $response );
	}

	/**
	 * Checks if a given request has access to update a specific item.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
	 * @since 4.7.0
	 *
	 */
	public function update_item_permissions_check( $request ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'rest_update_forbidden', __( 'User doesn\'t have sufficient permission', A16_REST_CRUD_TD ),
				array( 'status' => 403 ) );
		}

		$mango = $this->get_mango( $request['id'] );
		if ( is_wp_error( $mango ) ) {
			return $mango;
		}

		return true;
	}

	/**
	 * Updates one item from the collection.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 * @since 4.7.0
	 *
	 */
	public function update_item( $request ) {
		$mango = $this->prepare_item_for_database( $request );

		if ( is_wp_error( $mango ) ) {
			return $mango;
		}

		$mango['id'] = $request['id'];

		$updated = $this->mango_db->create_update_mango( $mango );
		if ( is_wp_error( $updated ) ) {
			return $updated;
		}

		if ( $updated === 0 ) {
			return new WP_Error( 'rest_nothing_to_update',
				__( "Nothing to update.", A16_REST_CRUD_TD ), array( 'status' => 400 ) );
		}

		$mango    = $this->get_mango( $mango['id'] );
		$response = $this->prepare_item_for_response( $mango, $request );

		return rest_ensure_response( $response );
	}

	/**
	 * Checks if a given request has access to delete a specific item.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return true|WP_Error True if the request has access to delete the item, WP_Error object otherwise.
	 * @since 4.7.0
	 *
	 */
	public function delete_item_permissions_check( $request ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'rest_delete_forbidden', __( 'User doesn\'t have sufficient permission', A16_REST_CRUD_TD ),
				array( 'status' => 403 ) );
		}

		$mango = $this->get_mango( $request['id'] );
		if ( is_wp_error( $mango ) ) {
			return $mango;
		}

		return true;
	}

	/**
	 * Deletes one item from the collection.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 * @since 4.7.0
	 *
	 */
	public function delete_item( $request ) {
		$mango    = $this->get_mango( $request['id'] );
		$previous = $this->prepare_item_for_response( $mango, $request );

		if ( ! $this->mango_db->delete_mango( $request['id'] ) ) {
			return new WP_Error( 'rest_mango_not_deleted',
				__( 'Mango can\'t be deleted', A16_REST_CRUD_TD ), [ 'status' => 500 ] );
		}
		$del_item = array(
			'deleted'  => true,
			'previous' => $previous->data
		);

		return rest_ensure_response( $del_item );//can't use 204 No Content, because it does not support sending data back
	}

	/**
	 * Prepares the item for the REST response.
	 *
	 * @param mixed $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 * @since 4.7.0
	 *
	 */
	public function prepare_item_for_response( $item, $request ) {
		$ret_item = array();
		$fields   = $this->get_fields_for_response( $request );
		if ( in_array( 'id', $fields ) ) {
			$ret_item['id'] = $item['id'];
		}
		if ( in_array( 'name', $fields ) ) {
			$ret_item['name'] = $item['name'];
		}
		if ( in_array( 'price', $fields ) ) {
			$ret_item['price'] = $item['price_per_kg'];
		}
		if ( in_array( 'origin', $fields ) ) {
			$ret_item['origin'] = $item['origin_district'];
		}

		$context  = empty( $request['context'] ) ? 'view' : $request['context'];
		$ret_item = $this->filter_response_by_context( $ret_item, $context );

		$response = rest_ensure_response( $ret_item );
		$response->add_links( $this->prepare_links( $item ) );

		return $response;
	}

	/**
	 * Prepares one item for create or update operation.
	 *
	 * @param WP_REST_Request $request Request object.
	 *
	 * @return array The prepared item, or WP_Error object on failure.
	 * @since 4.7.0
	 *
	 */
	protected function prepare_item_for_database( $request ): array {
		$prepared = array();

		if ( isset( $request['name'] ) ) {
			$prepared['name'] = $request['name'];
		}
		if ( isset( $request['price'] ) ) {
			$prepared['price_per_kg'] = $request['price'];
		}
		if ( isset( $request['origin'] ) ) {
			$prepared['origin_district'] = $request['origin'];
		}

		return $prepared;
	}


	/**
	 * Retrieves the item's schema, conforming to JSON Schema.
	 *
	 * @return array Item schema data.
	 * @since 4.7.0
	 *
	 */
	public function get_item_schema(): array {
		if ( $this->schema ) {
			return $this->add_additional_fields_schema( $this->schema );
		}
		$this->schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'mango', //singular form means a single mango item
			'type'       => 'object',
			'properties' => array(
				'id'     => array(
					'description' => __( 'Identifies a Mango uniquely', A16_REST_CRUD_TD ),
					'type'        => 'integer',
					'context'     => array( 'view', 'edit' ),
					'readonly'    => true,
				),
				'name'   => array(
					'description' => __( 'Name of a Mango like Fazli or Harivanga', A16_REST_CRUD_TD ),
					'type'        => 'string',
					'minLength'   => 1,
					'maxLength'   => 50,
					'context'     => array( 'view', 'edit' ),
					'required'    => true,
					'arg_options' => array(
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
				'price'  => array(
					'description'      => __( 'Price of a Mangoes per kilogram', A16_REST_CRUD_TD ),
					'type'             => 'number',
					'minimum'          => 0,
					'exclusiveMinimum' => true,
					'context'          => array( 'view', 'edit' ),
					'required'         => true,
				),
				'origin' => array(
					'description' => __( 'District of origin of the Mango type', A16_REST_CRUD_TD ),
					'type'        => 'string',
					'minLength'   => 1,
					'maxLength'   => 30,
					'context'     => array( 'view', 'edit' ),
					'arg_options' => array(
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
			),
		);

		return $this->add_additional_fields_schema( $this->schema );
	}

	/**
	 * Retrieves the query params for the collections.
	 *
	 * @return array Query parameters for the collection.
	 * @since 4.7.0
	 *
	 */
	public function get_collection_params(): array {
		$params = parent::get_collection_params();
		unset( $params['search'] );

		return $params;
	}

	/**
	 * Returns links to self and collection of an item got from database
	 *
	 * @param $item array|stdClass The object returned from the database
	 *
	 * @return array[]
	 */
	private function prepare_links( $item ): array {
		$route = trailingslashit( $this->namespace ) . $this->rest_base;
		$links = array(
			'self'       => array(
				'href' => rest_url( trailingslashit( $route ) . $item['id'] )
			),
			'collection' => array(
				'href' => rest_url( $route )
			)
		);

		return $links;
	}

	/**
	 * @param $id int The id of the Mango item
	 *
	 * @return array|object|void|WP_Error
	 */
	private function get_mango( int $id ) {
		$mango = $this->mango_db->get_mango( $id );

		if ( ! $mango ) {
			return new WP_Error(
				'rest_mango_invalid_id',
				__( "Mango with the given id is not found", A16_REST_CRUD_TD ),
				array( 'status' => 404 )
			);
		}

		return $mango;
	}
}
