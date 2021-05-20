<?php


namespace A11_CF\Admin;


class Cats_Fact_Widget {
	const cats_fact_transient_key = 'a11_cf_trans_k';

	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'widget' ] );
	}

	public function widget() {
		wp_add_dashboard_widget( 'a11_cf_wid1',
			__( "Cats Fact", A11_CF_TD ),
			[ $this, 'creator' ]
		);
	}

	public function creator() {
		$url   = "https://cat-fact.herokuapp.com/facts/random?animal_type=cat&amount=5";
		$facts = get_transient( self::cats_fact_transient_key );
		if ( $facts === false ) {
			$response = wp_remote_get( $url );
			if ( is_wp_error( $response ) ) {
				echo "Error: <strong>{$response->get_error_message()}</strong>";

				return;
			} else if ( wp_remote_retrieve_response_code( $response ) != 200 ) {
				echo "Error: <strong>{wp_remote_retrieve_response_message($response)}</strong>";

				return;
			} else {
				$facts = json_decode( wp_remote_retrieve_body( $response ) );
				set_transient( self::cats_fact_transient_key, $facts, 24 * 60 * 60 );
			}
		}
		?>
        <ol>
			<?php foreach ( $facts as $fact ) {
				?>
                <li><?php echo $fact->text;
					if ( $fact->status->verified === true ) {
						echo ' <span class="dashicons dashicons-yes-alt"></span>';
					} else {
						echo ' <span class="dashicons dashicons-dismiss"></span>';
					} ?></li>
				<?php
			} ?>
        </ol>
		<?php

	}
}