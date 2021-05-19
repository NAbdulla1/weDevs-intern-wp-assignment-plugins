<?php


namespace A09_Jobs_From_Github\Frontend;


class Single_Job_Shortcode {
	const tag = 'a09_jfg_single_job_shortcode';

	public function __construct() {
		add_shortcode( self::tag, [ $this, 'single_job_page_content' ] );
	}

	public function single_job_page_content() {
		$job_id = empty( $_GET['a09_jfg_job_id'] ) ? '0' : $_GET['a09_jfg_job_id'];

		return 'Job ID: ' . $job_id;
		?>

		<?php
	}
}