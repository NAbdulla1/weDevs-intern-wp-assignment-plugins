<?php


namespace A12_RELATED_POSTS;


class Related_Posts_Finder {
	public static function find_related_posts( $post ): array {
		$id   = $post->ID;
		$args = array(
			'category__in' => wp_get_post_categories( $id ),
			'post__not_in' => array( $id ),
			'numberposts'  => 5
		);

		return get_posts( $args );
	}
}