<?php


namespace A06_Post_Excerpt\Frontend;

use A06_Post_Excerpt\Constants;

class Latext_Post_Excerpts {
	public function __construct() {
		add_shortcode( Constants::plugin_prefix . '_excerpt_list', [ $this, 'excerpt_list_with_filter' ] );
		add_action( 'wp_head', [ $this, 'add_select2' ] );
	}

	public function add_select2() {
		echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>';
	}

	public function excerpt_list_with_filter( $atts, $content ) {
		$category = empty( $_POST[ Constants::plugin_prefix . '_category' ] ) ? 0 : (int) $_POST[ Constants::plugin_prefix . '_category' ];
		$count    = empty( $_POST[ Constants::plugin_prefix . '_count' ] ) ? 10 : (int) $_POST[ Constants::plugin_prefix . '_count' ];
		$post_ids = empty( $_POST[ Constants::plugin_prefix . '_pid' ] ) ? array() : array_filter( $_POST[ Constants::plugin_prefix . '_pid' ], function ( $pid ) {
			return strlen( $pid ) > 0;
		} );
		$posts    = get_posts( array(
			'category'    => $category,
			'include'     => $post_ids,
			'numberposts' => $count
		) );

		ob_start();
		?>
        <form action="" method="post">
            <select name='<?php echo Constants::plugin_prefix . '_category' ?>'>
                <option value="0" <?php echo ( $category === 0 ) ? 'selected' : '' ?> >All Categories</option>
				<?php
				$cats = get_categories();
				foreach ( $cats as $cat ) {
					if ( $cat->term_id == $category ) {
						echo "<option selected value='$cat->term_id'>$cat->name</option>\n";
					} else {
						echo "<option value='$cat->term_id'>$cat->name</option>\n";
					}
				}
				?>
            </select>
            <select name='<?php echo Constants::plugin_prefix . '_count' ?>'>
				<?php
				for ( $cnt = 1; $cnt <= 20; $cnt ++ ) {
					if ( $cnt == $count ) {
						echo "<option selected value='$cnt'>$cnt</option>\n";
					} else {
						echo "<option value='$cnt'>$cnt</option>\n";
					}
				}
				?>
            </select>
            <label for="post_ids">Post IDs:</label>
            <select id="post_ids" name='<?php echo Constants::plugin_prefix . '_pid[]' ?>' multiple="multiple">
				<?php
				$all_posts = get_posts( array( 'posts_per_page' => - 1 ) );
				foreach ( $all_posts as $pst ) {
					$id = $pst->ID;
					if ( in_array( $id, $post_ids ) ) {
						echo "<option selected value='$id'>$id</option>";
					} else {
						echo "<option  value='$id'>$id</option>";
					}
				}
				?>
            </select>
            <script>
                $(document).ready(function () {
                    $('#post_ids').select2();
                });
            </script>
            <button type="submit">Filter</button>
        </form>
		<?php
		if ( empty( $posts ) ) {
			echo '<h3>No posts found</h3>';
		} else {
			echo '<table><tr><th>Post ID</th><th>Excerpt</th></tr>';
			foreach ( $posts as $post ) {
				$excerpt = get_post_meta( $post->ID, '_a06_post_excerpt_field_value', true );
				if ( ! empty( $excerpt ) ) {
					echo "<tr><td>$post->ID</td><td>$excerpt</td></tr>";
				}
			}
			echo '</table>';
		}

		return ob_get_clean();
	}
}