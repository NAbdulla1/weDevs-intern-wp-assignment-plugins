<?php


namespace A04_Vertical_Button\Frontend;

/**
 * Class Frontend_Vertical_Button
 * @package A04_Vertical_Button\Frontend
 */
class Frontend_Vertical_Button {
	private $buttonText = 'btn';

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
			<button type='button'
				style='
					position: fixed;
					right: 0;
					bottom: 50vh;
					padding: 0 1.5rem;
					color: whitesmoke;
					font-size: 1.5rem;
					background-color: gray;
					cursor: pointer;
					border-top-left-radius: 10px;
					border-top-right-radius: 10px;
					transform-origin: 100% 100%;
					transform: rotate(-90deg)  translate(50%, 0%);'>
			$this->buttonText
			</button>
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