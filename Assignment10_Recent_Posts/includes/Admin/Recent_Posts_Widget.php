<?php


namespace A10_RP\Admin;


class Recent_Posts_Widget {
	const widget_id = 'a10_recent_posts_wid1';

	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'widget' ] );
	}

	public function widget() {
		wp_add_dashboard_widget( self::widget_id, __( "Recent Posts", A10_RECENT_POSTS_TD ), [
			$this,
			'widget_view'
		], [
			$this,
			'widget_form_control'
		],
		);
	}

	public function widget_view() {
		$args  = Widget_Options_Manager::get_dashboard_widget_option( self::widget_id, self::widget_id . '_args' );
		$order = $args['order'];
		unset( $args['order'] );
		$posts = get_posts( $args );

		//using custom filed to sort latest posts by title
		usort( $posts, fn( $f, $s ) => $order == 'asc'
			? strcasecmp( $f->post_title, $s->post_title )
			: strcasecmp( $s->post_title, $f->post_title ) );

		if ( empty( $posts ) ) {
			echo '<h3>No posts found</h3>';
		} else {
			echo '<table style="padding: 5px;"><tr style="padding: 5px;"><th style="padding: 5px;">SL</th><th style="padding: 5px;">Post ID</th><th style="padding: 5px;">Title</th></tr>';
			$sl = 1;
			foreach ( $posts as $post ) {
				echo "<tr style='padding: 5px;'><td style='padding: 5px;'>$sl</td><td style='padding: 5px; text-align: center'>$post->ID</td><td style='padding: 5px;'>$post->post_title</td></tr>";
				$sl ++;
			}
			echo '</table>';
		}
	}

	public function widget_form_control() {
		$args_old = Widget_Options_Manager::get_dashboard_widget_option( self::widget_id, self::widget_id . '_args' );
		$category = ( ! isset( $args_old['cat'] ) || empty( $args_old['cat'] ) ) ? 0 : $args_old['cat'];
		$order    = ( ! isset( $args_old['order'] ) || empty( $args_old['order'] ) ) ? 'desc' : $args_old['order'];
		$count    = ( ! isset( $args_old['numberposts'] ) || empty( $args_old['numberposts'] ) ) ? 5 : $args_old['numberposts'];

		if ( isset( $_POST['widget_id'] ) && ! empty( $_POST['widget_id'] && $_POST['widget_id'] == self::widget_id ) ) {
			$category = ( $_POST['a10_recent_posts_category'] != 0 && empty( $_POST['a10_recent_posts_category'] ) ) ? $category : (int) $_POST['a10_recent_posts_category'];
			$count    = empty( $_POST['a10_recent_posts_count'] ) ? $count : (int) $_POST['a10_recent_posts_count'];
			$order    = empty( $_POST['a10_recent_posts_order'] ) ? $order : $_POST['a10_recent_posts_order'];

			$args_for_get_post_in_widget_view = array(
				'cat'         => $category,
				'order'       => $order,
				'numberposts' => $count,
			);
			Widget_Options_Manager::update_dashboard_widget_options(
				self::widget_id,
				array( self::widget_id . '_args' => $args_for_get_post_in_widget_view )
			);
		}
		?>
        <label for="a10_recent_posts_pcat">Category:</label>
        <select id="a10_recent_posts_pcat" name='a10_recent_posts_category'>
            <option value="0" <?php echo ( $category == 0 ) ? 'selected' : '' ?> >All Categories</option>
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
        <!--<br/>-->
        <label for="a10_recent_posts_pcount">Number of Posts:</label>
        <select id="a10_recent_posts_pcount" name='a10_recent_posts_count'>
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
        <!--<br/>-->
        <label for="a10_recent_posts_order">Order:</label>
        <select id="a10_recent_posts_order" name='a10_recent_posts_order'>
            <option <?php echo $order === 'asc' ? 'selected' : '' ?> value="asc">Ascending</option>
            <option <?php echo $order === 'desc' ? 'selected' : '' ?> value="desc">Descending</option>
        </select>
		<?php
	}
}
