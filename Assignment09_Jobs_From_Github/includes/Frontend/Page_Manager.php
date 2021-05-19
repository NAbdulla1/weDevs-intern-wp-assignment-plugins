<?php


namespace A09_Jobs_From_Github\Frontend;


class Page_Manager {
	const JOB_LIST_PAGE_SLUG_KEY = 'a09_jfg_list_page';
	const SINGLE_JOB_PAGE_SLUG_KEY = 'a09_jfg_single_job_page';

	public function __construct() {
		$this->create_pages();
	}

	private function create_pages() {
		$this->job_list_page();
		$this->single_job_page();
	}

	private function job_list_page() {
		$job_list_page_slug = get_option( self::JOB_LIST_PAGE_SLUG_KEY, false );
		if ( ! $job_list_page_slug ) {
			$post_details = array(
				'post_title'   => 'Job List',
				'post_content' => '[' . Job_List_Shortcode::tag . ']',
				'post_status'  => 'publish',
				'post_author'  => 1,
				'post_type'    => 'page'
			);
			$page_id      = wp_insert_post( $post_details );
			$page         = get_post( $page_id );
			$slug         = $page->post_name;
			update_option( self::JOB_LIST_PAGE_SLUG_KEY, $slug );
		}
	}

	private function single_job_page() {
		$single_job_page_slug = get_option( self::SINGLE_JOB_PAGE_SLUG_KEY, false );
		if ( ! $single_job_page_slug ) {
			$post_details = array(
				'post_title'   => 'Single Job Page',
				'post_content' => '[' . Single_Job_Shortcode::tag . ']',
				'post_status'  => 'publish',
				'post_author'  => 1,
				'post_type'    => 'page'
			);
			$page_id      = wp_insert_post( $post_details );
			$page         = get_post( $page_id );
			$slug         = $page->post_name;
			update_option( self::SINGLE_JOB_PAGE_SLUG_KEY, $slug );
		}
	}
}