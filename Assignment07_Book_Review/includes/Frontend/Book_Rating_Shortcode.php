<?php


namespace A07_Book_Review\Frontend;


use A07_Book_Review\DB;

/**
 * Class Book_Rating_Shortcode
 * @package A07_Book_Review\Frontend
 */
class Book_Rating_Shortcode {
	const TAG = "a07_br_book_rating_shortcode_tag";

	/**
	 * Book_Rating_Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( self::TAG, array( $this, 'show_book_rating' ) );
	}

	/**
	 * @return false|string
	 */
	public function show_book_rating() {
		$page     = 1;
		$per_page = 2;
		if ( ! empty( $_GET['a07_br_page'] ) ) {
			$page = max( 1, (int) $_GET['a07_br_page'] );
		}
		if ( ! empty( $_GET['a07_br_per_page'] ) ) {
			$per_page = max( 1, (int) $_GET['a07_br_per_page'] );
		}

		global $post;

		$db            = new DB();
		$total_ratings = $db->get_total( array( 'post_id' => $post->ID ) );
		if ( is_wp_error( $total_ratings ) ) {
			return "<div class='wrap'>An error occurred. try again later.</div>";
		}
		$total_pages = (int) ( ( (int) $total_ratings + $per_page - 1 ) / $per_page );

		$ratings = $db->get_ratings_of_post( array(
			'post_id'  => $post->ID,
			'per_page' => $per_page,
			'offset'   => $per_page * ( $page - 1 )
		) );

		global $wp;
		$page_url = home_url( $wp->request );
		$nxt      = $page + 1;
		$prv      = $page - 1;
		ob_start();
		?>
		<?php if ( count( $ratings ) == 0 ) {
			echo "<div>No Rating Found for this Post</div>";
		} else {
			?>
            <table>
                <tr>
                    <th>Rating ID</th>
                    <th>User ID</th>
                    <th>User</th>
                    <th>Rating</th>
                </tr>
				<?php
				foreach ( $ratings as $rating ) {
					$user = get_user_by( 'ID', $rating['user_id'] );
					?>
                    <tr>
                        <th><?php esc_html_e( $rating['id'] ) ?></th>
                        <th><?php esc_html_e( $rating['user_id'] ); ?></th>
                        <th><?php esc_html_e( ( $user === false ) ? 'User Not Found' : $user->display_name ); ?></th>
                        <th><?php esc_html_e( $rating['rating'] ); ?></th>
                    </tr>
					<?php
				}
				?>
            </table>

            <form action="" method="get" id="a17_form_pagination">
                <table class="form-table">
                    <tr>
                        <td colspan="2">Total Ratings</td>
                        <td><?php esc_html_e( $total_ratings ); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <label style="padding: 2px; width: 40%" for="a07_br_page">Page:</label>
                            <input style="padding: 2px; width: 50%" type="number" name="a07_br_page" id="a07_br_page"
                                   value='<?php echo $page ?>'/>
                        </td>
                        <td>
                            <label style=" padding: 2px; width: 40%" for="a07_br_per_page">Per Page:</label>
                            <input style="padding:2px; width: 50%" type="number" name="a07_br_per_page"
                                   id="a07_br_per_page"
                                   value='<?php echo $per_page ?>'/>
                        </td>
                        <td colspan="2" style="text-align: right">
                            <button style="padding: 2px" type="submit">Apply</button>
                        </td>
                    </tr>
					<?php if ( $total_ratings > $per_page ) {
						?>
                        <tr>
                            <td style="text-align: right" colspan="3">
								<?php if ( $page != 1 ) {
									?>
                                    <a type=" submit"
                                       href="<?php echo $page_url . "?a07_br_page=$prv&a07_br_per_page=$per_page" ?>">&lt;
                                        Previous Page
                                    </a>
									<?php
								} ?>
                                <span style="width: 20px"></span>
								<?php if ( $page < $total_pages ) {
									?>
                                    <a type="submit"
                                       href="<?php echo $page_url . "?a07_br_page=$nxt&a07_br_per_page=$per_page" ?>">Next
                                        Page &gt;
                                    </a>
									<?php
								} ?>
                            </td>
                        </tr>
						<?php
					} ?>

                </table>
            </form>
			<?php
		} ?>

		<?php

		return ob_get_clean();
	}
}