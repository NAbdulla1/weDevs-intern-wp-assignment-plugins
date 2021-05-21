<?php


namespace A14_Author_Box\Admin;


class User_Meta_Fields {
	const user_meta_fields = array(
		"fb" => 'a14_umf_fb_field',
		"tw" => 'a14_umf_tw_field',
		"li" => 'a14_umf_li_field',
	);
	const user_meta_texts = array(
		'fb' => "Facebook",
		'tw' => "Twitter",
		'li' => "LinkedIn",
	);

	public function __construct() {
		add_action( 'show_user_profile', [ $this, 'add_meta_fields' ] );
		add_action( 'personal_options_update', [ $this, 'update_meta_fields' ] );
	}

	public function add_meta_fields( $user ) {
		?>
        <table class="form-table">
			<?php foreach ( self::user_meta_fields as $key => $value ) {
				$option_value = get_user_meta( $user->ID, $value, true );
				?>
                <tr>
                    <th>
                        <label for="<?php echo $value ?>"><?php _e( self::user_meta_texts[ $key ], A14_AUTHOR_BOX_TD ); ?></label>
                    </th>
                    <td><input value="<?php echo $option_value ?>" type="text" name="<?php echo $value ?>"
                               id="<?php echo $value ?>"></td>
                </tr>
				<?php
			} ?>
        </table>
		<?php
	}

	public function update_meta_fields( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}
		foreach ( self::user_meta_fields as $key ) {
			update_user_meta( $user_id, $key, $_POST[ $key ] );
		}
	}
}