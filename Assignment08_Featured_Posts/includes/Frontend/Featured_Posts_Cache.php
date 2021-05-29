<?php


namespace A08_Featured_Post\Frontend;

/**
 * retrieves the posts from database and caches them until the database query parameters changes
 * Class Featured_Posts_Cache
 * @package A08_Featured_Post\Frontend
 */
class Featured_Posts_Cache {
	const group = 'a08_featured_posts';

	/**
	 * retrieves and returns posts from database if query parameters change or returns from cache.
	 * @return array
	 */
	public static function get_posts(): array {
		$order = get_option( 'a08_featured_post_order' );
		$args  = $order == 'rand' ? array(
			'category__in' => get_option( 'a08_featured_post_categories' ),
			'numberposts'  => get_option( 'a08_featured_posts_no_of_posts' ),
			'orderby'      => $order,
		) : array(
			'category__in' => get_option( 'a08_featured_post_categories' ),
			'numberposts'  => get_option( 'a08_featured_posts_no_of_posts' ),
			'orderby'      => 'title',
			'order'        => $order,
		);

		$args_hash     = md5( serialize( $args ) );
		$args_hash_old = wp_cache_get( 'a08_args_prev', self::group );

		if ( $args_hash == $args_hash_old ) {
			$posts = wp_cache_get( 'a08_prev_fet_posts', self::group );
		} else {
			$posts = get_posts( $args );
			wp_cache_set( 'a08_args_prev', $args_hash, self::group );
			wp_cache_set( 'a08_prev_fet_posts', $posts, self::group );
		}

		return $posts;
	}
}