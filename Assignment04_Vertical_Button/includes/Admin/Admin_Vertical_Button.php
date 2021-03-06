<?php


namespace A04_Vertical_Button\Admin;

/**
 * Class Admin_Vertical_Button.
 * @package A04_Vertical_Button\Admin
 */
class Admin_Vertical_Button {
	private string $buttonText = 'btn';

	/**
	 * Admin_Vertical_Button constructor. registers action to builtin and custom hooks
	 */
	public function __construct() {
		add_action( 'admin_footer', [ $this, 'the_button' ] );
		add_action( 'a04_vertical_button_text', [ $this, 'change_text_to' ] );
	}

	/**
	 * Admin panel version of the button
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
					padding: 0 1.5rem;
					color: whitesmoke;
					font-size: 1.5rem;
					background-color: gray;
					cursor: pointer; 
					transform-origin: 100% 100%;
					transform: rotate(-90deg) translate(65%, 0%)'>$this->buttonText</button>
				<p style='text-align: right; transform: translate(0, 200%);'>A sample Description</p>
			</div>
		";
	}

	/**
	 * custom hook callback to change text of the button
	 *
	 * @param $text
	 */
	public function change_text_to( $text ) {
		$this->buttonText = $text;
	}
}