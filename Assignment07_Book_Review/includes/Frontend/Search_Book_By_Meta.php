<?php


namespace A07_Book_Review\Frontend;


class Search_Book_By_Meta {
	public function __construct() {
		add_shortcode( 'a07_book_review_book_search', [ $this, 'search_by_book_meta' ] );
		add_action( 'wp_head', [ $this, 'add_select2' ] );
	}

	public function add_select2() {
		echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>';
	}

	public function search_by_book_meta( $atts, $content ) {
		$authors    = empty( $_POST['a07_book_review_author'] ) ? $this->get_distinct_meta_values( '_a07_book_review_author_field_value' ) : $_POST['a07_book_review_author'];
		$count      = empty( $_POST['a07_book_review_count'] ) ? 10 : (int) $_POST['a07_book_review_count'];
		$publishers = empty( $_POST['a07_book_review_publisher'] ) ? $this->get_distinct_meta_values( '_a07_book_review_publisher_field_value' ) : $_POST['a07_book_review_publisher'];
		$books      = get_posts( array(
			'post_type'  => 'a07_book_review_book',
			'meta_query' => array(
				'relation'     => "OR",
				'by_author'    => array(
					'key'     => '_a07_book_review_author_field_value',
					'compare' => 'IN',
					'value'   => $authors,
				),
				'by_publisher' => array(
					'key'     => '_a07_book_review_publisher_field_value',
					'compare' => 'IN',
					'value'   => $authors,
				),
			)
		) );

		ob_start();
		?>
        <form action="" method="post">
            <div style="margin: 5px 0">
                <label style="display: inline-block; width: 24%;" for="auths">Author:</label>
                <select style="width: 75%;" id="auths" multiple="multiple" class="meta_values"
                        name='<?php echo 'a07_book_review_author[]' ?>'>
					<?php
					$all_authors = $this->get_distinct_meta_values( '_a07_book_review_author_field_value', false );
					foreach ( $all_authors as $author ) {
						if ( in_array( $author, $authors ) ) {
							echo "<option selected value='$author'>$author</option>";
						} else {
							echo "<option  value='$author'>$author</option>";
						}
					}
					?>
                </select>
            </div>
            <div style="margin: 5px 0">
                <label style="display: inline-block; width: 24%" for=pubs"">Publisher:</label>
                <select style="width: 75%;" class="meta_values" id="pubs"
                        name='<?php echo 'a07_book_review_publisher[]' ?>'
                        multiple="multiple">
					<?php
					$all_pubs = $this->get_distinct_meta_values( '_a07_book_review_publisher_field_value', false );
					foreach ( $all_pubs as $pub ) {
						if ( in_array( $pub, $publishers ) ) {
							echo "<option selected value='$pub'>$pub</option>";
						} else {
							echo "<option  value='$pub'>$pub</option>";
						}
					}
					?>
                </select>
            </div>
            <div style="margin: 5px 0">
                <label style="display: inline-block; width: 24%">Books:</label>
                <select name='<?php echo 'a07_book_review_count' ?>'>
					<?php
					for ( $cnt = 1; $cnt <= 20; $cnt ++ ) {
						if ( $cnt == $count ) {
							echo "<option selected value='$cnt'>$cnt</option>\n";
						} else {
							echo "<option value='$cnt'>$cnt</option>\n";
						}
					}
					?>
                </select></div>
            <div>
                <button style="float: right; margin: 5px 0" type="submit">Find</button>
            </div>
            <div style="content: ''; display: table; clear: both;"></div>
            <script>
                $(document).ready(function () {
                    $('.meta_values').select2();
                });
            </script>
        </form>
		<?php
		if ( empty( $books ) ) {
			echo '<h3>No Books found</h3>';
		} else {
			echo '<table><tr><th>Book Title</th><th>Author</th><th>Publisher</th></tr>';
			foreach ( $books as $book ) {
				$author    = get_post_meta( $book->ID, '_a07_book_review_author_field_value', true );
				$publisher = get_post_meta( $book->ID, '_a07_book_review_publisher_field_value', true );
				echo "<tr><td>$book->post_title</td><td>$author</td><td>$publisher</td></tr>";
			}
			echo '</table>';
		}

		return ob_get_clean();
	}

	private function get_distinct_meta_values( $meta_key, $limit = true ): array {
		$all_posts = get_posts( array( 'post_type' => 'a07_book_review_book', 'posts_per_page' => - 1 ) );
		$meta      = [];
		foreach ( $all_posts as $post ) {
			array_push( $meta, get_post_meta( $post->ID, $meta_key, true ) );
		}

		if ( $limit ) {
			$meta = array_slice( $meta, 0, 10 );
		}

		return array_unique( $meta );
	}
}