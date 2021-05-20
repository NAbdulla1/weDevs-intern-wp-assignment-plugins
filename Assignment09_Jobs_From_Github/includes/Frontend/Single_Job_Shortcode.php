<?php


namespace A09_Jobs_From_Github\Frontend;


class Single_Job_Shortcode {
	const tag = 'a09_jfg_single_job_shortcode';

	public function __construct() {
		add_shortcode( self::tag, [ $this, 'single_job_page_content' ] );
	}

	public function single_job_page_content() {
		$job_id      = empty( $_GET['a09_jfg_job_id'] ) ? '0' : $_GET['a09_jfg_job_id'];
		$url         = Job_List_Shortcode::baseUrl . "/$job_id.json";
		$job_details = wp_remote_get( $url );
		if ( is_wp_error( $job_details ) ) {
			return "<div class='wrap'>{$job_details->get_error_message()}</div>";
		}
		if ( wp_remote_retrieve_response_code( $job_details ) != 200 ) {
			$msg = wp_remote_retrieve_response_message( $job_details );

			return "<div class='wrap'>$msg</div>";
		}
		$job = json_decode( wp_remote_retrieve_body( $job_details ) );
		?>
        <div class="wrap">
            <h3><?php echo $job->title ?></h3>
            <img style=" width: 20%; float: right"
                 src="<?php echo $job->company_logo ?>"
                 alt="<?php echo $job->company ?>"/>
            <p><?php echo $job->type ?> job</p>
            <p>Company: <a href="<?php echo $job->company_url ?>"><?php echo $job->company ?></a></p>
            <p>Location: <?php echo $job->location ?></p>
            <p>Posted at: <?php echo date_format( date_create( $job->created_at ), "d M, Y" ) ?></p>
            <div>
                <strong>Description:</strong>
				<?php echo $job->description ?>
                <strong>How to appy:</strong>
				<?php echo $job->how_to_apply ?>
            </div>
        </div>
		<?php
	}
}