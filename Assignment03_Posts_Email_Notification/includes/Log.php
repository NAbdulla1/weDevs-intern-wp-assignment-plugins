<?php

namespace A03_Posts_Email_Notification;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class Log
 * @package A03_Posts_Email_Notification
 */
class Log {
	private static Logger $logger;

	private function __construct() {
	}

	/**
	 * Debug log function
	 *
	 * @param mixed $message A message to write to log file.
	 */
	public static function dbg( $message ) {
		if ( ! isset( self::$logger ) ) {
			self::$logger = new Logger( 'debug-channel' );
			self::$logger->pushHandler( new StreamHandler( __DIR__ . "/../logs.log", Logger::DEBUG ) );
		}
		self::$logger->debug( $message );
	}
}