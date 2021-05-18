<?php


namespace A07_Book_Review;


use A05_Contact_Form\Log;

class DB {
	public function insert_rating( $args = [] ) {
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
}