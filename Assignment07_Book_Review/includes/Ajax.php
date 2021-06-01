<?php


namespace A07_Book_Review;

/**
 * Class Ajax Ajax Request Handler
 * @package A07_Book_Review
 */
class Ajax {
	private $errors = [];

	/**
	 * Ajax constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_a07_rating_save', [ $this, 'save_rating' ] );
		add_action( 'wp_ajax_nopriv_a07_rating_save', [ $this, 'unauthorized' ] );
	}

	/**
	 * save the ratings found from ajax request body
	 */
	public function save_rating() {
		if ( empty( $_POST['a07_r_nonce'] ) || ! wp_verify_nonce( $_POST['a07_r_nonce'], 'a07_rating_save_act' ) ) {
			wp_send_json_error( [ 'message' => 'Nonce verification failed' ] );
		}

		$this->errors = [];
		$this->validate();
		if ( ! empty( $this->errors ) ) {
			wp_send_json_error( [ 'message' => 'Invalid data provided', 'errros' => $this->errors ], 400 );
		}

		$user_id = $_POST['user_id'];
		$post_id = $_POST['post_id'];
		$rating  = $_POST['rating'];

		$db = new DB();
		if ( $db->rating_already_exists( $user_id, $post_id ) ) {
			$success = $db->update_rating( [ 'user_id' => $user_id, 'post_id' => $post_id, 'rating' => $rating ] );
			if ( is_wp_error( $success ) ) {
				wp_send_json_error( [ 'message' => $success->get_error_message() . 'errrrrrrrrrrr' ] );
			}
		} else {
			$insert_id = $db->insert_rating( [ 'user_id' => $user_id, 'post_id' => $post_id, 'rating' => $rating ] );
			if ( is_wp_error( $insert_id ) ) {
				wp_send_json_error( [ 'message' => $insert_id->get_error_message() . 'errrrrrrrrrrr' ] );
			}
		}
		wp_send_json_success( [ 'message' => 'Post rated successfully' ] );
	}

	/**
	 * Sends proper response for unauthorized access
	 */
	public function unauthorized() {
		wp_send_json_error( [
			'message' => 'Must be logged in to rate a post'
		], 403 );
	}

	/**
	 * Validate the ajax body data and store error on $errors array
	 */
	public function validate(): void {
		if ( empty( $_POST['post_id'] ) ) {
			array_push( $this->errors, [ 'post-id', 'no post id provided' ] );
		} else if ( ! get_post( $_POST['post_id'] ) ) {
			array_push( $this->errors, [ 'post-id', 'Post Not Found' ] );
		}

		if ( empty( $_POST['user_id'] ) ) {
			array_push( $this->errors, [ 'user-id', 'no user id provided' ] );
		} else if ( ! get_users( [ 'include' => $_POST['user_id'], 'fields' => 'ID' ] ) ) {
			array_push( $this->errors, [ 'user-id', 'User Not Found' ] );
		}
		if ( empty( $_POST['rating'] ) ) {
			array_push( $this->errors, [ 'user-id', 'no rating value provided' ] );
		} else if ( ( (int) $_POST['rating'] ) <= 0 || 5 < ( (int) $_POST['rating'] ) ) {
			array_push( $this->errors, [ 'user-id', 'Invalid rating value, must be between 0 and 5' ] );
		}
	}
}
