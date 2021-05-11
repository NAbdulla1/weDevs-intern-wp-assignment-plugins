<?php

namespace A06_Post_Excerpt;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log {
	private static Logger $logger;

	private function __construct() {
	}

	public static function dbg( $message ) {
		if ( ! isset( self::$logger ) ) {
			self::$logger = new Logger( 'debug-channel' );
			self::$logger->pushHandler( new StreamHandler( __DIR__ . "/../logs.log", Logger::DEBUG ) );
		}
		self::$logger->debug( $message );
	}
}