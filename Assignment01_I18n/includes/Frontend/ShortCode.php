<?php


namespace A01\i18n\Frontend;


class ShortCode {
	public function __construct() {
		add_shortcode( 'a01-i18n', [ $this, 'render_shortcode' ] );
	}

	public function render_shortcode( $attrs, $content ) {
		return "Hello from ShortCode";
	}
}