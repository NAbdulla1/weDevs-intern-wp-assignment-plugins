<?php


namespace A02_Posts_View_Counter\Frontend;

use A05_Contact_Form\Log;

class Post_View_Filter {
	public function __construct() {
		add_shortcode( 'a02_posts_count_list', [ $this, 'post_title_list' ] );
		add_action( 'wp_head', [ $this, 'add_select2' ] );
	}

	public function add_select2() {
		echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>';
	}

	public function post_title_list( $atts, $content ) {
		$category = empty( $_POST[ 'a02_posts_count' . '_category' ] ) ? 0 : (int) $_POST[ 'a02_posts_count' . '_category' ];
		$count    = empty( $_POST[ 'a02_posts_count' . '_count' ] ) ? 10 : (int) $_POST[ 'a02_posts_count' . '_count' ];
		$post_ids = empty( $_POST[ 'a02_posts_count' . '_pid' ] ) ? array() : array_filter( $_POST[ 'a02_posts_count' . '_pid' ], function ( $pid ) {
			return strlen( $pid ) > 0;
		} );
		$order    = empty( $_POST['a02_posts_order'] ) ? 'asc' : $_POST['a02_posts_order'];

		$posts = get_posts( array(
			'category'    => $category,
			'include'     => $post_ids,
			'numberposts' => $count,
			'orderby'     => 'meta_value_num',
			'order'       => $order,
			'meta_query'  => array(
				array(
					'key' => 'view_count',
				)
			)
		) );

		ob_start();
		?>
        <form action="" method="post">
            <select name='<?php echo 'a02_posts_count' . '_category' ?>'>
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
            <select name='<?php echo 'a02_posts_count' . '_count' ?>'>
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
            <select name='a02_posts_order'>
                <option <?php echo $order == 'asc' ? 'selected' : '' ?> value="asc">Ascending</option>
                <option <?php echo $order == 'desc' ? 'selected' : '' ?> value="desc">Descending</option>
            </select>
            <label for="post_ids">Post IDs:</label>
            <select id="post_ids" name='<?php echo 'a02_posts_count' . '_pid[]' ?>' multiple="multiple">
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
			echo '<table><tr><th>Post ID</th><th>Excerpt</th><th>View Count</th></tr>';
			foreach ( $posts as $post ) {
				echo "<tr><td>$post->ID</td><td>$post->post_title</td><td>$post->view_count</td></tr>";
			}
			echo '</table>';
		}

		return ob_get_clean();
	}
}