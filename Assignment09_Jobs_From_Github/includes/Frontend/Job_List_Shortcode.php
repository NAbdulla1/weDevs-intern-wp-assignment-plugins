<?php


namespace A09_Jobs_From_Github\Frontend;


class Job_List_Shortcode {
	const tag = 'a09_jfg_job_list_shortcode';
	const baseUrl = 'https://jobs.github.com/positions';

	public function __construct() {
		add_shortcode( self::tag, [ $this, 'job_list_page_content' ] );
	}

	public function job_list_page_content() {
		$single_job_page_slug = get_option( Page_Manager::SINGLE_JOB_PAGE_SLUG_KEY );
		$search_string        = false;
		$jobs                 = wp_remote_get( self::baseUrl . '.json?page=1&limit=10', array( 'timeout' => 100 ) );
		$msg                  = wp_remote_retrieve_response_message( $jobs );
		$msg                  = json_encode( $jobs );
		if ( wp_remote_retrieve_response_code( $jobs ) != 200 ) {
			return "<div class='wrap'>Something went wrong in remote request. $msg</div>";
		}
		$jobs = wp_remote_retrieve_body( $jobs );
		$jobs = json_decode( $jobs );
		ob_start();
		?>
        <div class="wrap">
			<?php
			foreach ( $jobs as $job ) {
				$href = "/$single_job_page_slug?a09_jfg_job_id={$job->id}";
				?>
                <div style="display:flex; border: black 1px solid; background-color: #dfdfdf; box-shadow: #0f0f0f; margin: 5px; padding: 5px; border-radius: 5px">
                    <div style="width: 75%">
                        <p><a href="<?php echo $href ?>"><?php echo $job->title ?></a></p>
                        <p><?php echo $job->type ?> job</p>
                        <p>Location: <?php echo $job->location ?></p>
                        <p>Posted at: <?php echo $job->created_at ?></p>
                    </div>
                    <div style="width: 25%;margin: auto 0;">
                        <a href="<?php echo $job->company_url ?>">
                            <img style=" width: 100%; float: right"
                                 src="<?php echo $job->company_logo ?>"
                                 alt="<?php $job->company ?>"/>
                        </a>
                    </div>
                </div>
				<?php
			}
			?>
        </div>
		<?php
		return ob_get_clean();
	}
}