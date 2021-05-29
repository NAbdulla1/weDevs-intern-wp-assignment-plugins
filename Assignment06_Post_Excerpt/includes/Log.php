<?php

namespace A06_Post_Excerpt;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class Log
 * @package A06_Post_Excerpt
 */
class Log {
	private static Logger $logger;

	private function __construct() {
	}

	/**
	 * prints a log message to the specified file
	 * @param $message
	 */
	public static function dbg( $message ) {
		if ( ! isset( self::$logger ) ) {
			self::$logger = new Logger( 'debug-channel' );
			self::$logger->pushHandler( new StreamHandler( __DIR__ . "/../logs.log", Logger::DEBUG ) );
		}
		self::$logger->debug( $message );
	}
}