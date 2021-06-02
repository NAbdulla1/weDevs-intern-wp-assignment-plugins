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
		add_action( 'a02_posts_count_increase_count', array( $this, 'update_and_get_view_count' ) );
	}

	/**
	 * Add view counter to post
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function add_view_count( $content ): string {
		if ( is_single() && ! $this->is_count_already_added() ) {
			do_action( 'a02_posts_count_add_view_count_action' );// a custom action hook to indicate that this section already executed
			$postId = get_the_ID();
			$this->init_view_count( $postId );
			$count = $this->update_and_get_view_count( $postId );

			$count = apply_filters( 'a02_posts_view_view_counter_hook', $count );// a custom filter hook

			return $content . "<p>Total View: $count</p>";
		}

		return $content;
	}

	/**
	 * @return bool returns the true if action hook "a02_posts_count_add_view_count_action" has run once already
	 */
	private function is_count_already_added(): bool {
		return did_action( 'a02_posts_count_add_view_count_action' ) === 1;
		//return preg_match( '/<p>Total View: <em>\d+<\/em><\/p>$/', $content ) === 1;
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
		/*if ( substr( $count, 0, min( 4, strlen( $count ) ) ) === '<em>'
			 || ( strlen( $count ) >= 5 && substr( $count, - 5 ) === '</em>' ) ) {
			return $count;
		}*/

		return "<em>$count</em>";
	}
}