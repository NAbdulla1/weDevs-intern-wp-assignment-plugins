<?php


namespace A07_Book_Review;

/**
 * Class Book_Types Custom Taxonomy for Book_CPT
 * @package A07_Book_Review
 */
class Book_Types {
	/**
	 * Book_Types constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_book_types_taxonomy' ] );
	}

	/**
	 * Prepare and register the taxonomy
	 */
	function register_book_types_taxonomy() {
		$labels = [
			'menu_name'                  => esc_html__( 'Book Types', 'a07_book_review_text_domain' ),
			'all_items'                  => esc_html__( 'All Book Types', 'a07_book_review_text_domain' ),
			'edit_item'                  => esc_html__( 'Edit Book Type', 'a07_book_review_text_domain' ),
			'view_item'                  => esc_html__( 'View Book Type', 'a07_book_review_text_domain' ),
			'update_item'                => esc_html__( 'Update Book Type', 'a07_book_review_text_domain' ),
			'add_new_item'               => esc_html__( 'Add new Book Type', 'a07_book_review_text_domain' ),
			'new_item'                   => esc_html__( 'New Book Type', 'a07_book_review_text_domain' ),
			'parent_item'                => esc_html__( 'Parent Book Type', 'a07_book_review_text_domain' ),
			'parent_item_colon'          => esc_html__( 'Parent Book Type', 'a07_book_review_text_domain' ),
			'search_items'               => esc_html__( 'Search Book Types', 'a07_book_review_text_domain' ),
			'popular_items'              => esc_html__( 'Popular Book Types', 'a07_book_review_text_domain' ),
			'separate_items_with_commas' => esc_html__( 'Separate Book Types with commas', 'a07_book_review_text_domain' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Book Types', 'a07_book_review_text_domain' ),
			'choose_from_most_used'      => esc_html__( 'Choose most used Book Types', 'a07_book_review_text_domain' ),
			'not_found'                  => esc_html__( 'No Book Types found', 'a07_book_review_text_domain' ),
			'name'                       => esc_html__( 'Book Types', 'a07_book_review_text_domain' ),
			'singular_name'              => esc_html__( 'Book Type', 'a07_book_review_text_domain' ),
		];
		$args   = [
			'label'                => esc_html__( 'Book Types', 'a07_book_review_text_domain' ),
			'labels'               => $labels,
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'show_tagcloud'        => true,
			'show_in_quick_edit'   => true,
			'show_admin_column'    => false,
			'show_in_rest'         => true,
			'hierarchical'         => false,
			'query_var'            => true,
			'sort'                 => false,
			'rewrite_no_front'     => false,
			'rewrite_hierarchical' => false,
			'rewrite'              => true,
		];
		register_taxonomy( 'a07_book_review_book_types', [ 'a07_book_review_book' ], $args );
	}
}
