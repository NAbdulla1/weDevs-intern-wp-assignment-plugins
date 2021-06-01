<?php


namespace A07_Book_Review;


use WP_Error;

/**
 * Class DB
 * @package A07_Book_Review
 */
class DB {
	/**
	 * Inserts new rating to the database
	 *
	 * @param array $args insert data user_id, post_id, rating
	 *
	 * @return int|WP_Error insert id or error
	 */
	public function insert_rating( $args = array() ) {
		global $wpdb;
		$curTime = current_time( 'mysql' );
		$data    = wp_parse_args( $args, [
			'user_id'    => '',
			'post_id'    => '',
			'rating'     => 0,
			'created_at' => $curTime,
			'updated_at' => $curTime,
		] );
		if ( false === $wpdb->insert( "{$wpdb->prefix}a07_book_review_ratings", $data, [
				'%d',
				'%d',
				'%d',
				'%s',
				'%s'
			] ) ) {
			return new \WP_Error( 'failed with error: ' . $wpdb->last_error );
		}

		return $wpdb->insert_id;
	}

	/**
	 * Updates a rating
	 *
	 * @param array $args An array containing the columns and new values
	 *
	 * @return bool|WP_Error
	 */
	public function update_rating( $args ) {
		global $wpdb;
		$curTime = current_time( 'mysql' );
		$data    = [
			'rating'     => empty( $args['rating'] ) ? 0 : (int) $args['rating'],
			'updated_at' => $curTime,
		];
		$where   = [
			'user_id' => $args['user_id'],
			'post_id' => $args['post_id'],
		];

		if ( false === $wpdb->update( "{$wpdb->prefix}a07_book_review_ratings", $data, $where,
				[ '%d', '%s' ], [ '%d', '%d' ] ) ) {
			return new \WP_Error( 'failed with error: ' . $wpdb->last_error );
		}

		return true;
	}

	/**
	 * Check if a user already exists
	 *
	 * @param $uid int User id
	 * @param $pid int Post id
	 *
	 * @return string|null
	 */
	public function rating_already_exists( $uid, $pid ) {
		global $wpdb;

		$rating_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$wpdb->prefix}a07_book_review_ratings WHERE user_id=%d AND post_id=%d",
				[ (int) $uid, (int) $pid ]
			)
		);

		return $rating_id;
	}

	/**
	 * get rating of a specified post with pagination
	 *
	 * @param array $args an array with arguments: post_id, offset, per_page
	 *
	 * @return array|WP_Error
	 */
	public function get_ratings_of_post( $args = array() ): array {
		$defaults = array(
			"offset"   => 1,
			"per_page" => 2,
		);
		$args     = wp_parse_args( $args, $defaults );
		if ( empty( $args['post_id'] ) ) {
			return new WP_Error( 'no-post-id', 'No Post Id provided' );
		}

		global $wpdb;
		$ratings = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}a07_book_review_ratings WHERE post_id=%d LIMIT %d OFFSET %d",
				$args['post_id'],
				$args['per_page'],
				$args['offset']
			),
			ARRAY_A
		);

		if ( $ratings === false ) {
			return new WP_Error( 'db-error', $wpdb->last_error );
		}

		return $ratings;
	}

	/**
	 * Get total number of ratings for a given post
	 *
	 * @param array $args an array containing the post_id key.
	 *
	 * @return string|WP_Error|null
	 */
	public function get_total( $args = array() ) {
		if ( empty( $args['post_id'] ) ) {
			return new WP_Error( 'no-post-id', 'No Post Id provided' );
		}

		global $wpdb;
		$total = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}a07_book_review_ratings WHERE post_id=%d", $args['post_id'] )
		);

		if ( $total === false ) {
			return new WP_Error( 'db-error', $wpdb->last_error );
		}

		return $total;
	}
}
