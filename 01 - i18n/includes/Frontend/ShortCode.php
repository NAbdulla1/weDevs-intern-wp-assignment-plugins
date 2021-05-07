<?php


namespace WeDevs\Academy\Frontend;


class ShortCode {
	public function __construct() {
		add_shortcode( 'wedevs-academy', [ $this, 'render_shortcode' ] );
	}

	public function render_shortcode( $attrs, $content ) {
		return "Hello from ShortCode";
	}
}