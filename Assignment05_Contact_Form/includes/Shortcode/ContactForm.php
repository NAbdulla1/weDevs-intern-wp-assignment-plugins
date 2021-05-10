<?php


namespace A05_Contact_Form\Shortcode;


use A05_Contact_Form\Log;

class ContactForm {
	public function __construct() {
		add_shortcode( 'a05_contact_form', [ $this, 'contact_form_handler' ] );
	}

	public function contact_form_handler( $attrs, $content ) {
		$fname_error   = false;
		$lname_error   = false;
		$email_error   = false;
		$message_error = false;
		$email_sent    = false;
		if ( ! empty( $_POST ) ) {
			if ( empty( trim( $_POST['fname'] ) ) ) {
				$fname_error = true;
			}
			if ( empty( trim( $_POST['lname'] ) ) ) {
				$lname_error = true;
			}
			if ( empty( trim( $_POST['email'] ) ) || ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
				$email_error = true;
			}
			if ( empty( trim( $_POST['message'] ) ) ) {
				$message_error = true;
			}

			if ( ! $message_error && ! $fname_error && ! $lname_error && ! $email_error ) {
				$email            = $_POST["email"];
				$name             = $_POST["fname"] . " " . $_POST['lname'];
				$message          = $_POST['message'];
				$message_to_admin = "From: $email\nName: $name\n\nMessage: $message";
				$_POST['email']   = $_POST["fname"] = $_POST['lname'] = $_POST['message'] = '';

				Log::dbg( "sending mail to \"$email\" with message:\n\"$message_to_admin\"" );
				//send actual email
				$email_sent = true;
			}
		}
		ob_start();
		?>
        <form method='post' action=''>
			<?php if ( $email_sent )
				echo '<h2 style="color: forestgreen">Email sent successfully</h2>' ?>
            <h3 style="text-align: center">Contact us</h3>
            <fieldset>
                <div style="margin-bottom: 20px">
                    <label for='fname'
                           style='margin: 0; padding: 5px 10px; border: none; display: inline-block; width: 29%'>First
                        Name: </label>
                    <input required style='margin: 0; padding: 5px 10px; border: none; width: 70%' type='text'
                           id='fname' name='fname' placeholder='First Name'
                           value='<?php echo ! empty( $_POST['fname'] ) ? $_POST['fname'] : '' ?>'/>
					<?php if ( $fname_error )
						echo '<small style="color: mediumvioletred; display: block; text-align: right;">First Name is required</small>' ?>
                </div>
                <div style="margin-bottom: 20px">
                    <label for='lname'
                           style='margin: 0; padding: 5px 10px; border: none; display: inline-block; width: 29%'>Last
                        Name: </label>
                    <input required style='margin: 0; padding: 5px 10px; border: none; width: 70%' type='text'
                           id='lname' name='lname' placeholder='Last Name'
                           value='<?php echo ! empty( $_POST['lname'] ) ? $_POST['lname'] : '' ?>'/>
					<?php if ( $lname_error )
						echo '<small style="color: mediumvioletred; display: block; text-align: right;">Last Name is required</small>' ?>
                </div>
                <div style="margin-bottom: 20px">
                    <label for='email'
                           style='margin: 0; padding: 5px 10px; border: none; display: inline-block; width: 29%'>Email
                        Address: </label>
                    <input required style='margin: 0; padding: 5px 10px; border: none; width: 70%' type='text'
                           id='email' name='email' placeholder='Email Address'
                           value='<?php echo ! empty( $_POST['email'] ) ? $_POST['email'] : '' ?>'/>
					<?php if ( $email_error )
						echo '<small style="color: mediumvioletred; display: block; text-align: right;">Invalid email</small>' ?>
                </div>
                <div style="margin-bottom: 20px">
                    <label for='message' style="margin: 0; padding: 5px 10px">Message: </label>
                    <textarea id='message' name='message'
                              style='border: none; min-width: 100%; max-width: 100%; margin: 0;'
                              placeholder='Write message here'><?php echo ! empty( $_POST['message'] ) ? $_POST['message'] : '' ?></textarea>
					<?php if ( $message_error )
						echo '<small style="color: mediumvioletred; display: block; text-align: right;">Message is required</small>' ?>
                </div>
                <div>
                    <button type='submit' style='float: right; padding: 5px 30px; margin: 0;'>Submit</button>
                </div>
            </fieldset>
        </form>
		<?php
		return ob_get_clean();
	}
}
