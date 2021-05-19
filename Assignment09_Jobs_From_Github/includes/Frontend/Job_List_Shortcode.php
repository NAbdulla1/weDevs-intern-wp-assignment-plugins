<?php


namespace A09_Jobs_From_Github\Frontend;


class Job_List_Shortcode {
	const tag = 'a09_jfg_job_list_shortcode';

	public function __construct() {
		add_shortcode( self::tag, [ $this, 'job_list_page_content' ] );
	}

	public function job_list_page_content() {
		$single_job_page_slug = get_option( Page_Manager::SINGLE_JOB_PAGE_SLUG_KEY );
		ob_start();
		?>
        <div class="wrap">
			<?php
			for ( $i = 1; $i <= 5; $i ++ ) {
				$href = "/$single_job_page_slug?a09_jfg_job_id=$i";
				?>
                <a href='<?php echo $href ?>'>page-<?php echo $i ?></a>
                <br/>
				<?php
			}
			?>
        </div>
		<?php
		return ob_get_clean();
	}
}