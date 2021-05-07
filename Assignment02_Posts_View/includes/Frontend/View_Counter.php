<?php


namespace A02_Posts_View_Counter\Frontend;

/**
 * Class View_Counter
 * @package A02_Posts_View_Counter\Frontend
 */
class View_Counter {

	/**
	 * View_Counter constructor.
	 */
	public function __construct() {
		add_filter( 'the_content', [ $this, 'add_view_count' ], 10, 1 );
		add_filter( 'a02_posts_view_view_counter_hook', [ $this, 'emphasise_count_value' ], 10, 1 );
	}

	/**
	 * Add view counter to post
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function add_view_count( $content ): string {
		if ( is_single() ) {
			$postId = get_the_ID();
			$this->init_view_count( $postId );
			$count = $this->update_and_get_view_count( $postId );

			$count = apply_filters( 'a02_posts_view_view_counter_hook', $count );

			return $content . "<p>Total View: $count</p>";
		}

		return $content;
	}

	/**
	 * Initialize the view counter
	 *
	 * @param int $postId
	 */
	public function init_view_count( int $postId ): void {
		if ( empty( get_post_meta( $postId, 'view_count' ) ) ) {
			add_post_meta( $postId, 'view_count', 0 );
		}
	}

	/**
	 * Update the view counter
	 *
	 * @param int $postId
	 *
	 * @return int
	 */
	public function update_and_get_view_count( int $postId ): int {
		$count = (int) get_post_meta( (int) $postId, 'view_count', true );
		$count ++;
		update_post_meta( $postId, 'view_count', $count );

		return $count;
	}

	/**
	 * @param $count
	 *
	 * @return string
	 */
	public function emphasise_count_value( $count ): string {
		return "<em>$count</em>";
	}
}