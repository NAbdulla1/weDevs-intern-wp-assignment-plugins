<?php


namespace A05_Contact_Form\Shortcode;


/**
 * A shortcode to show and handle a contact form
 * Class ContactForm
 * @package A05_Contact_Form\Shortcode
 */
class ContactForm {
	public function __construct() {
		add_shortcode( 'a05_contact_form', [ $this, 'contact_from_renderer' ] );
	}

	/**
     * Loads the contact form script and renders a contact form
	 * @param $attrs
	 * @param $content
	 *
	 * @return false|string
	 */
	public function contact_from_renderer( $attrs, $content ) {
		wp_enqueue_script( 'contact_form_script' );
		$fname_error   = false;
		$lname_error   = false;
		$email_error   = false;
		$message_error = false;
		$email_sent    = false;
		/*if ( ! empty( $_POST ) ) {
			if ( empty( trim( $_POST['a05_contact_form_fname'] ) ) ) {
				$fname_error = true;
			}
			if ( empty( trim( $_POST['a05_contact_form_lname'] ) ) ) {
				$lname_error = true;
			}
			if ( empty( trim( $_POST['a05_contact_form_email'] ) ) || ! filter_var( $_POST['a05_contact_form_email'], FILTER_VALIDATE_EMAIL ) ) {
				$email_error = true;
			}
			if ( empty( trim( $_POST['a05_contact_form_message'] ) ) ) {
				$message_error = true;
			}

			if ( ! $message_error && ! $fname_error && ! $lname_error && ! $email_error ) {
				$email                           = $_POST["a05_contact_form_email"];
				$name                            = $_POST["a05_contact_form_fname"] . " " . $_POST['a05_contact_form_lname'];
				$message                         = $_POST['a05_contact_form_message'];
				$message_to_admin                = "From: $email\nName: $name\n\nMessage: $message";
				$_POST['a05_contact_form_email'] = $_POST["a05_contact_form_fname"] = $_POST['a05_contact_form_lname'] = $_POST['a05_contact_form_message'] = '';

				Log::dbg( "sending mail to \"$email\" with message:\n\"$message_to_admin\"" );
				//send actual email
				$email_sent = true;
			}
		}*/
		ob_start();
		?>
        <form novalidate id="a05_cf_id">
			<?php if ( $email_sent )
				echo '<h2 style="color: forestgreen">Email sent successfully</h2>' ?>
            <h3 style="text-align: center">Contact us</h3>
            <fieldset>
                <div style="margin-bottom: 20px">
                    <label for='a05_contact_form_fname'
                           style='margin: 0; padding: 5px 10px; border: none; display: inline-block; width: 29%'>First
                        Name: </label>
                    <input required style='margin: 0; padding: 5px 10px; border: none; width: 70%' type='text'
                           id='a05_contact_form_fname' name='a05_contact_form_fname' placeholder='First Name'
                           value='<?php echo ! empty( $_POST['a05_contact_form_fname'] ) ? $_POST['a05_contact_form_fname'] : '' ?>'/>
					<?php if ( $fname_error )
						echo '<small style="color: mediumvioletred; display: block; text-align: right;">First Name is required</small>' ?>
                </div>
                <div style="margin-bottom: 20px">
                    <label for='a05_contact_form_lname'
                           style='margin: 0; padding: 5px 10px; border: none; display: inline-block; width: 29%'>Last
                        Name: </label>
                    <input required style='margin: 0; padding: 5px 10px; border: none; width: 70%' type='text'
                           id='a05_contact_form_lname' name='a05_contact_form_lname' placeholder='Last Name'
                           value='<?php echo ! empty( $_POST['a05_contact_form_lname'] ) ? $_POST['a05_contact_form_lname'] : '' ?>'/>
					<?php if ( $lname_error )
						echo '<small style="color: mediumvioletred; display: block; text-align: right;">Last Name is required</small>' ?>
                </div>
                <div style="margin-bottom: 20px">
                    <label for='a05_contact_form_email'
                           style='margin: 0; padding: 5px 10px; border: none; display: inline-block; width: 29%'>Email
                        Address: </label>
                    <input required style='margin: 0; padding: 5px 10px; border: none; width: 70%' type='text'
                           id='a05_contact_form_email' name='a05_contact_form_email' placeholder='Email Address'
                           value='<?php echo ! empty( $_POST['a05_contact_form_email'] ) ? $_POST['a05_contact_form_email'] : '' ?>'/>
					<?php if ( $email_error )
						echo '<small style="color: mediumvioletred; display: block; text-align: right;">Invalid email</small>' ?>
                </div>
                <div style="margin-bottom: 20px">
                    <label for='a05_contact_form_message' style="margin: 0; padding: 5px 10px">Message: </label>
                    <textarea id='a05_contact_form_message' name='a05_contact_form_message'
                              style='border: none; min-width: 100%; max-width: 100%; margin: 0;'
                              placeholder='Write message here'><?php echo ! empty( $_POST['a05_contact_form_message'] ) ? $_POST['a05_contact_form_message'] : '' ?></textarea>
					<?php if ( $message_error )
						echo '<small style="color: mediumvioletred; display: block; text-align: right;">Message is required</small>' ?>
                </div>
				<?php wp_nonce_field( 'a05_contact_form__nonce' ) ?>
                <input type="hidden" name="action" value="a05_contact_form"/>
                <div>
                    <button type='submit' style='float: right; padding: 5px 30px; margin: 0;'>Submit</button>
                </div>
            </fieldset>
        </form>
		<?php
		return ob_get_clean();
	}
}
