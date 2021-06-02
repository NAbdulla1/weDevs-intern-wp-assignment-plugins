<?php


namespace A03_Posts_Email_Notification;

/**
 * Class Daily_Notifier_Cron_Job
 * @package A03_Posts_Email_Notification
 */
class Daily_Notifier_Cron_Job {
	/**
	 * Daily_Notifier_Cron_Job constructor.
	 */
	public function __construct() {
		if ( ! has_action( "a03_pen_daily_notifier_hook" ) ) {
			add_action( 'a03_pen_daily_notifier_hook', array( $this, 'notify' ) );
		}
	}

	/**
	 * Notifier hook callback function
	 */
	public function notify() {
		$summ = $this->summary();

		wp_mail( get_option( 'admin_email' ), 'Daily Report', $summ, );

		$timestamp = wp_next_scheduled( 'a03_pen_daily_notifier_hook' );
		Log::dbg( 'next scheduled at ' . date( 'c', $timestamp ) );
	}

	/**
	 * Starting a cron scheduler to run after midnight
	 */
	public function start_cron_scheduler() {
		$timestamp = strtotime( 'today midnight' ) + 1;
		if ( ! wp_next_scheduled( 'a03_pen_daily_notifier_hook' ) ) {
			$succ = wp_schedule_event( $timestamp, 'daily', 'a03_pen_daily_notifier_hook', array(), true );
			if ( is_wp_error( $succ ) ) {
				Log::dbg( 'error: ' . $succ->get_error_message() );
				wp_mail( get_option( 'admin_email' ), 'test scheduled error', 'test scheduled error' . $succ->get_error_message() );
			}
		}
	}

	/**
	 * Stopping the previously started scheduler
	 */
	public function stop_cron_scheduler() {
		$timestamp = wp_next_scheduled( 'a03_pen_daily_notifier_hook' );
		Log::dbg( 'scheduler ending... next scheduled ' . date( 'c', $timestamp ) );
		if ( $timestamp !== false ) {
			wp_unschedule_event( $timestamp, 'a03_pen_daily_notifier_hook' );
		}
	}

	private function summary(): string {
		$today     = time();
		$yesterday = $today - 24 * 60 * 60;
		$yesterday = getdate( $yesterday );
		$posts     = get_posts(
			array(
				'status'     => 'published',
				'date_query' => array(
					'after'     => array(
						'day'   => $yesterday['mday'],
						'month' => $yesterday['mon'],
						'year'  => $yesterday['year'],
					),
					'before'    => array(
						'day'   => $yesterday['mday'],
						'month' => $yesterday['mon'],
						'year'  => $yesterday['year'],
					),
					'inclusive' => true,
				),
			)
		);

		$count         = count( $posts );
		$titles        = array_map( fn( $pst ) => $pst->post_title, $posts );
		$email_content = "Dear Admin,\nYesterday we have total $count posts published.\nThe post titles are here:\n";
		$email_content .= join( "\n", $titles );
		$email_content .= "\nYours Sincerely\nDaily Notifier Plugin\n";

		return $email_content;
	}
}
