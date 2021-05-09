<?php

namespace A03_Posts_Email_Notification;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log {
	private static Logger $logger;

	private function __construct() {
	}

	public static function dbg( $message ) {
		if ( ! isset( self::$logger ) ) {
			self::$logger = new Logger( 'debug-channel' );
			self::$logger->pushHandler( new StreamHandler( __DIR__ . "/../../logs.log", Logger::DEBUG ) );
		}
		self::$logger->debug( $message );
	}
}