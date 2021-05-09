<?php


namespace A04_Vertical_Button\Frontend;

/**
 * Class Frontend_Vertical_Button
 * @package A04_Vertical_Button\Frontend
 */
class Frontend_Vertical_Button {
	private string $buttonText = 'btn';

	/**
	 * Frontend_Vertical_Button constructor. adds a builtin and a custom hook
	 */
	public function __construct() {
		add_action( 'wp_footer', [ $this, 'the_button' ] );
		add_action( 'a04_vertical_button_text', [ $this, 'change_text_to' ] );
	}

	/**
	 * making the button and fixing it's position
	 */
	public function the_button() {
		echo "
			<div style='
					padding: 0;
					position: fixed;
					right: 0;
					bottom: 50vh;
					transform: translate(0%, 50%);
				'>
				<button style='
					position: absolute;
					right: 0;
					padding: 0 1.5rem;
					color: whitesmoke;
					border-top-right-radius: 5px;
					border-top-left-radius: 5px; 
					font-size: 1.5rem;
					background-color: gray;
					cursor: pointer;
					transform-origin: 100% 100%;
					transform: rotate(-90deg) translate(75%, 0%)'>$this->buttonText</button>
				<p style='text-align: right; transform: translate(0, 210%);'>A sample Description</p>
			</div>
		";
	}

	/**
	 * change text callback for custom hook
	 *
	 * @param $text
	 */
	public function change_text_to( $text ) {
		$this->buttonText = $text;
	}
}