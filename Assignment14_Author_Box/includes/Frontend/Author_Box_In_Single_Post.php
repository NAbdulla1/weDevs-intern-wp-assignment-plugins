<?php


namespace A14_Author_Box\Frontend;


use A14_Author_Box\Admin\User_Meta_Fields;

class Author_Box_In_Single_Post {
	public function __construct() {
		add_filter( 'the_content', [ $this, 'add_author_box' ] );
	}

	public function add_author_box( $content ): string {
		remove_filter( 'the_content', [ $this, 'add_author_box' ] );
		$content_to_add = '';
		if ( is_single() ) {
			$content_to_add = '<div style="width: fit-content; background-color:lightgoldenrodyellow; border: 2px hotpink dashed; padding: 10px"><u>Author Box</u>';
			global $post;
			$author_id = $post->post_author;
			foreach ( User_Meta_Fields::user_meta_fields as $key => $value ) {
				$link           = get_user_meta( $author_id, $value, true );
				$text           = User_Meta_Fields::user_meta_texts[ $key ];
				$link           = "<div style='padding-left: 20px;'><a href='$link'>$text</a></div>";
				$content_to_add .= $link;
			}
			$content_to_add .= '</div>';
		}

		return $content . $content_to_add;
	}
}