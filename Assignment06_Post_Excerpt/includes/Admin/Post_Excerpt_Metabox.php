<?php


namespace A06_Post_Excerpt\Admin;


use A06_Post_Excerpt\Log;

/**
 * creates and shows a Metabox at the post edit screen
 * Class Post_Excerpt_Metabox
 * @package A06_Post_Excerpt\Admin
 */
class Post_Excerpt_Metabox {
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_post_excerpt_custom_box' ] );
		add_action( 'save_post', [ $this, 'store_post_excerpt' ] );
	}

	/**
	 * registers the meta box
	 */
	public function add_post_excerpt_custom_box() {
		add_meta_box( 'a06_post_excerpt_metabox_id01', 'Post Excerpt', [ $this, 'html' ], 'post' );
	}

	/**
	 * the content of the box to be shown
	 * @param $postt
	 */
	public function html( $post ) {
		$excerpt = get_post_meta( $post->ID, '_a06_post_excerpt_field_value', true );
		$excerpt = ( empty( $excerpt ) ? '' : $excerpt );
		echo "<textarea style='width: 100%' name='a06_post_excerpt_field'>$excerpt</textarea>";
	}

	/**
	 * storing the data in database shown by the 'html' function
	 * @param $post_id
	 */
	public function store_post_excerpt( $post_id ) {
		if ( array_key_exists( 'a06_post_excerpt_field', $_POST ) ) {
			update_post_meta( $post_id, '_a06_post_excerpt_field_value', $_POST['a06_post_excerpt_field'] );
		}
	}
}