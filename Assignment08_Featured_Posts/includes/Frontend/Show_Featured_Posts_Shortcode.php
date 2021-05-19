<?php

namespace A08_Featured_Post\Frontend;
class Show_Featured_Posts_Shortcode {
	public function __construct() {
		add_shortcode( 'a08_show_featured_posts', [ $this, 'get_shortcode' ] );
	}

	public function get_shortcode( $attrs, $content ) {
		$posts = Featured_Posts_Cache::get_posts();
		ob_start();
		?>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
            </tr>
			<?php foreach ( $posts as $post ) {
				?>
                <tr>
                    <td><?php echo $post->post_title ?></td>
                    <td><?php echo get_userdata( $post->post_author )->display_name ?></td>
                    <td><?php
						echo join( ", ",
							array_map( function ( $cid ) {
								return get_category( $cid )->name;
							}, $post->post_category )
						);
						?></td>
                </tr>
				<?php
			} ?>
        </table>
		<?php
		return ob_get_clean();
	}
}