<?php


namespace A02_Posts_View_Counter\Frontend;

/**
 * A shortcode to show 10 latest post with view count
 * Class Post_View_Filter
 * @package A02_Posts_View_Counter\Frontend
 */
class Post_View_Filter {
	/**
	 * Post_View_Filter constructor.
	 */
	public function __construct() {
		add_shortcode( 'a02_posts_count_list', [ $this, 'post_title_list' ] );
		add_action( 'wp_head', [ $this, 'add_select2' ] );
	}

	/**
	 * add select2 library
	 */
	public function add_select2() {
		echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>';
	}

	/**
	 * Shortcode renderer and filter form handler.
	 *
	 * @param $atts
	 * @param $content
	 *
	 * @return false|string
	 */
	public function post_title_list( $atts, $content ) {
		$category = 0;
		$count    = 10;
		$post_ids = array();
		$order    = 'asc';
		if ( ! empty( $_POST['a02_posts_view_form_id'] ) && $_POST['a02_posts_view_form_id'] === 'a02_posts_view_recent_posts_and_view_count' ) {
			$category = empty( $_POST[ 'a02_posts_count' . '_category' ] ) ? 0 : (int) $_POST[ 'a02_posts_count' . '_category' ];
			$count    = empty( $_POST[ 'a02_posts_count' . '_count' ] ) ? 10 : (int) $_POST[ 'a02_posts_count' . '_count' ];
			$post_ids = empty( $_POST[ 'a02_posts_count' . '_pid' ] ) ? array() : array_filter( $_POST[ 'a02_posts_count' . '_pid' ], function ( $pid ) {
				return strlen( $pid ) > 0;
			} );
			$order    = empty( $_POST['a02_posts_order'] ) ? 'asc' : $_POST['a02_posts_order'];
		}

		$posts = get_posts( array(
			'category'    => $category,
			'include'     => $post_ids,
			'numberposts' => $count,
			'orderby'     => 'view_count_numer',
			'order'       => $order,
			'meta_query'  => array(
				'view_count_numer' => array(
					'key'  => 'view_count',
					'type' => 'NUMERIC'
				),
			),
		) );

		ob_start();
		?>
        <form action="" method="post">
            <input hidden name="a02_posts_view_form_id" value="a02_posts_view_recent_posts_and_view_count"
            <select name='<?php echo esc_attr( 'a02_posts_count_category' ); ?>'>
                <option value="0" <?php echo esc_attr( ( $category === 0 ) ? 'selected' : '' ) ?> ><?php esc_html_e( 'All Categories', 'a02_posts_view_textdomain' ); ?></option>
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
            <select name='<?php echo esc_attr( 'a02_posts_count_count' ) ?>'>
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
            <select name=<?php echo esc_attr( 'a02_posts_order' ) ?>>
                <option <?php echo $order == 'asc' ? 'selected' : '' ?>
                        value="asc"><?php esc_html_e( 'Ascending', 'a02_posts_view_textdomain' ); ?></option>
                <option <?php echo $order == 'desc' ? 'selected' : '' ?>
                        value="desc"><?php esc_html_e( 'Descending', 'a02_posts_view_textdomain' ); ?></option>
            </select>
            <label for="post_ids">Post IDs:</label>
            <select style="width: 100px" id="post_ids" name='<?php echo 'a02_posts_count_pid[]' ?>' multiple="multiple">
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
            <button type="submit"><?php esc_html_e( 'Filter', 'a02_posts_view_textdomain' ); ?></button>
        </form>
		<?php
		if ( empty( $posts ) ) {
			?>
            <h3>
				<?php esc_html_e( 'No posts found', 'a02_posts_view_textdomain' ); ?>
            </h3>
			<?php
		} else {
			echo '<table><tr><th>';
			esc_html_e( 'Post ID', 'a02_posts_view_textdomain' );
			echo '</th><th>';
			esc_html_e( 'Title', 'a02_posts_view_textdomain' );
			echo '</th><th>';
			esc_html_e( 'View Count', 'a02_posts_view_textdomain' );
			echo '</th></tr>';
			foreach ( $posts as $post ) {
				echo "<tr><td>$post->ID</td><td>$post->post_title</td><td>$post->view_count</td></tr>";
			}
			echo '</table>';
		}

		return ob_get_clean();
	}
}