<?php


namespace A09_Jobs_From_Github\Frontend;


/**
 * a shortcode to display job lists
 * Class Job_List_Shortcode
 * @package A09_Jobs_From_Github\Frontend
 */
class Job_List_Shortcode {
	const tag = 'a09_jfg_job_list_shortcode';
	const baseUrl = 'https://jobs.github.com/positions';

	public function __construct() {
		add_shortcode( self::tag, [ $this, 'job_list_page_content' ] );
	}

	/**
     * displays searched jobs in page by page.
	 * @return false|string
	 */
	public function job_list_page_content() {
		$single_job_page_slug = get_option( Page_Manager::SINGLE_JOB_PAGE_SLUG_KEY );
		$search_string        = empty( $_GET['search'] ) ? '' : $_GET['search'];
		$page                 = empty( $_GET['a09_page'] ) ? 1 : (int) $_GET['a09_page'];
		$queryString          = "?page=" . $page;
		$queryString          .= ( ! empty( $search_string ) ) ? "&description=$search_string" : "";
		$jobs                 = wp_remote_get( self::baseUrl . ".json$queryString", array( 'timeout' => 100 ) );
		$msg                  = '';
		if ( is_wp_error( $jobs ) ) {
			$msg = $jobs->get_error_message();
		} else if ( wp_remote_retrieve_response_code( $jobs ) != 200 ) {
			$msg = wp_remote_retrieve_response_message( $jobs );
		}
		if ( ! empty( $msg ) ) {
			return "<div class='wrap'>Something went wrong in remote request. $msg</div>";
		}
		$jobs = wp_remote_retrieve_body( $jobs );
		$jobs = json_decode( $jobs );
		ob_start();
		?>
        <div class="wrap">
            <div style="text-align: right; margin: 10px;">
                <form action="" method="get">
                    <input required type="text" name="search" placeholder="Search"
                           value="<?php echo $search_string ?>"/>
                    <button type="submit">Search</button>
                </form>
            </div>
			<?php
			if ( empty( $jobs ) ) {
				echo '<h2>No Jobs Found</h2>';
			} else {
				foreach ( $jobs as $job ) {
					$href = "/$single_job_page_slug?a09_jfg_job_id={$job->id}";
					?>
                    <div style="display:flex; border: black 1px solid; background-color: #dfdfdf; margin: 10px; padding: 5px; border-radius: 5px">
                        <div style="width: 75%">
                            <p><a href="<?php echo $href ?>"><?php echo $job->title ?></a></p>
                            <p><?php echo $job->type ?> job</p>
                            <p>Location: <?php echo $job->location ?></p>
                            <p>Posted at: <?php echo date_format( date_create( $job->created_at ), "d M, Y" ) ?></p>
                        </div>
                        <div style="width: 25%;margin: auto 0;">
                            <a href="<?php echo $job->company_url ?>">
                                <img style=" width: 100%;"
                                     src="<?php echo $job->company_logo ?>"
                                     alt="<?php echo $job->company ?>"/>
                            </a>
                        </div>
                    </div>
					<?php
				}
			}
			$page ++;
			$nextPageUrl = get_option( Page_Manager::JOB_LIST_PAGE_SLUG_KEY );
			$nextPageUrl .= "?a09_page=$page";
			if ( ! empty( $search_string ) ) {
				$nextPageUrl .= "&search=$search_string";
			}
			if ( count( $jobs ) == 50 ) {
				echo "<a href='/$nextPageUrl'>More</a>";
			}
			?>
        </div>
		<?php
		return ob_get_clean();
	}
}