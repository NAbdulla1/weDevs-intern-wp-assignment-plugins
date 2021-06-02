<?php


namespace A06_Post_Excerpt\Frontend;

use A06_Post_Excerpt\Constants;

/**
 * A short code which shows and filters the post excerpts
 *
 * This shortcode will have parameters:
 * post_ids => a comma separated list of post ids
 * a06_pe_category => a single valid category, if category is invalid then it will user all categories
 * post_count => the number of posts to show
 *
 * Class Latext_Post_Excerpts
 * @package A06_Post_Excerpt\Frontend
 */
class Latext_Post_Excerpts {
	public function __construct() {
		add_shortcode( Constants::plugin_prefix . '_excerpt_list', [ $this, 'excerpt_list_with_filter' ] );
	}

	/**
	 * shows the list of excerpts and the filter parameter presentations
	 *
	 * @param array $atts
	 * @param $content
	 *
	 * @return false|string
	 */
	public function excerpt_list_with_filter( $atts, $content ) {
		$all_posts    = get_posts( array( 'posts_per_page' => - 1 ) );
		$all_post_ids = ( $all_posts == null ) ? array() : array_map( fn( $pst ) => $pst->ID, $all_posts );

		$all_categories   = get_categories();
		$all_category_ids = ( $all_categories == null ) ? array( 1 ) : array_map( fn( $cat ) => $cat->term_id, $all_categories );
		$defaults         = array(
			'numberposts'  => 10,
			'include'      => $all_post_ids,
			'category__in' => $all_category_ids,
		);

		$arguments = array();
		$atts      = array_change_key_case( $atts, CASE_LOWER );
		if ( ! empty( $atts['post_ids'] ) ) {
			$arguments['include'] = wp_parse_id_list( $atts['post_ids'] );
		}
		if ( ! empty( $atts['post_count'] ) && is_numeric( $atts['post_count'] ) ) {
			$arguments['numberposts'] = (int) $atts['post_count'];
		}
		if ( ! empty( $atts ['a06_pe_category'] ) &&
		     ! empty( array_filter( $all_categories, fn( $cat ) => strtolower( $cat->name ) == strtolower( $atts['a06_pe_category'] ) ) ) ) {
			$arguments['category__in'] = array_map( fn( $cat ) => $cat->term_id, array_filter( $all_categories, fn( $cat ) => $cat->name == $atts['a06_pe_category'] ) );
		}
		$arguments = shortcode_atts( $defaults, $arguments, Constants::plugin_prefix . '_excerpt_list' );
		$posts     = array_filter( $all_posts, function ( $pst ) use ( $arguments ) {
			return in_array( $pst->ID, $arguments['include'] )
			       && ! empty( array_intersect( $pst->post_category, $arguments['category__in'] ) );

		} );
		$posts     = array_slice( $posts, 0, $arguments['numberposts'] );

		ob_start();
		if ( empty( $posts ) ) {
			echo '<h3>No posts found</h3>';
		} else {
			echo '<table><tr><th>Post ID</th><th>Post Title</th><th>Excerpt</th></tr>';
			foreach ( $posts as $post ) {
				$excerpt = get_post_meta( $post->ID, '_a06_post_excerpt_field_value', true );
				if ( ! empty( $excerpt ) ) {
					echo "<tr><td>$post->ID</td><td>$post->post_title</td><td>$excerpt</td></tr>";
				} else {
					echo "<tr><td>$post->ID</td><td>$post->post_title</td><td>{empty}</td></tr>";
				}
			}
			echo '</table>';
		}

		return ob_get_clean();
	}
}