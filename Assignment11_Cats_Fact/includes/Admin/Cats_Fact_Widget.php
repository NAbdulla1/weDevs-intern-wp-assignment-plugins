<?php


namespace A11_CF\Admin;

/**
 * A class to create and register a dashboard widget
 */
class Cats_Fact_Widget {
	const CATS_FACT_TRANSIENT_KEY = 'a11_cf_trans_k';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'widget' ) );
	}

	/**
	 * Register a widget
	 *
	 * @return void
	 */
	public function widget() {
		wp_add_dashboard_widget( 'a11_cf_wid1', __( 'Cats Fact', A11_CF_TD ), array( $this, 'creator' ) );
	}

	/**
	 * Create and render the widget with data from ;facts api'
	 *
	 * @return void
	 */
	public function creator() {
		$url   = 'https://cat-fact.herokuapp.com/facts/random?animal_type=cat&amount=5';
		$facts = get_transient( self::CATS_FACT_TRANSIENT_KEY );
		if ( false === $facts ) {
			$response = wp_remote_get( $url );
			if ( is_wp_error( $response ) ) {
				echo esc_html( "Error: <strong>{$response->get_error_message()}</strong>" );

				return;
			} elseif ( wp_remote_retrieve_response_code( $response ) != 200 ) {
				echo esc_html( "Error: <strong>{wp_remote_retrieve_response_message($response)}</strong>" );

				return;
			} else {
				$facts = json_decode( wp_remote_retrieve_body( $response ) );
				set_transient(
					self::CATS_FACT_TRANSIENT_KEY,
					$facts,
					24 * 60 * 60
				);
			}
		}
		?>
		<ol>
			<?php
			foreach ( $facts as $fact ) {
				?>
				<li>
				<?php
				echo esc_html( $fact->text );
				if ( true === $fact->status->verified ) {
					echo ' <span class="dashicons dashicons-yes-alt"></span>';
				} else {
					echo ' <span class="dashicons dashicons-dismiss"></span>';
				}
				?>
					</li>
				<?php
			}
			?>
		</ol>
		<?php

	}
}
