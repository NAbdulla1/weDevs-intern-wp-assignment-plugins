<?php
/**
 * Plugin Name: Assignment03 Posts Email Notification
 * Description: A plugin to send email to admin when a new post is published
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment03_Posts_Email_Notification
 * Author: Md. Abdulla Al Mamun
 * Author URI: https://github.com/NAbdulla1
 * Version: 1.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class Assignment03_Posts_Email_Notification
 */
final class Assignment03_Posts_Email_Notification {
	/**
	 * Assignment03_Posts_Email_Notification constructor.
	 */
	private function __construct() {
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * @return Assignment03_Posts_Email_Notification|false
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Do actions after plugin loaded
	 */
	public function init_plugin() {
		new \A03_Posts_Email_Notification\Email_Notifier();
		$this->register_other_users();
		new \A03_Posts_Email_Notification\Daily_Notifier_Cron_Job();
		new \A03_Posts_Email_Notification\CapitalizeTitle();
	}

	/**
	 * Register other users, this is to simulate action of custom action hook
	 */
	public function register_other_users() {
		do_action( 'a03_add_other_user_email', [
			'user1@abc.com',
			'user2@abc.com',
			'user3@abc.com'
		] );//apply custom hook
	}

	/**
	 * Register a cron job at the activation
	 */
	public function activate() {
		$daily_notifier = new \A03_Posts_Email_Notification\Daily_Notifier_Cron_Job();
		$daily_notifier->start_cron_scheduler();
	}

	/**
	 * Deregister the cron job at deactivation
	 */
	public function deactivate() {
		$daily_notifier = new \A03_Posts_Email_Notification\Daily_Notifier_Cron_Job();
		$daily_notifier->stop_cron_scheduler();
	}
}

/**
 * Helper function
 */
function a03_posts_email_notification() {
	Assignment03_Posts_Email_Notification::init();
}

/**
 * Entry Point of plugin
 */
a03_posts_email_notification();
