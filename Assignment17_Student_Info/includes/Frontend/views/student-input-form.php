<form action="" method="post" novalidate>
    <fieldset style="margin-bottom: 20px; display: inline-block; width: 50%">
        <legend style="display: inline-block">Student Info</legend>
		<?php
		$cnt = 0;
		foreach ( self::fields as $field_name => $field_info ) {
			$cnt ++;
			if ( $cnt > 5 ) {
				break;
			}
			?>
            <div style="margin-bottom: 30px;">
                <label for="<?php echo $field_name ?>"
                       style="width: 25%; display: inline-block"><?php echo $field_info[1] ?></label>
                <input <?php echo $field_info[0] ? 'required' : '' ?>
                        style="width: 70%; margin: 0 2px"
                        name="<?php echo $field_name ?>"
                        id="<?php echo $field_name ?>"
                        type="text"
                        value="<?php echo ! empty( $_POST[ $field_name ] ) ? $_POST[ $field_name ] : '' ?>"/>
				<?php if ( isset( $this->errors[ $field_name ] ) ) {
					?>
                    <smalL style="display: block"><?php echo $this->errors[ $field_name ] ?></smalL>
					<?php
				} ?>
            </div>
			<?php
		}
		?>
    </fieldset>
    <fieldset style=" margin-bottom: 20px; display: inline-block; width: 40%">
        <legend style="display: inline-block;"><small>Subject and Marks</small></legend>
		<?php
		$cnt = 0;
		foreach ( self::fields as $field_name => $field_info ) {
			$cnt ++;
			if ( $cnt <= 5 ) {
				continue;
			}
			?>
            <div style="margin-bottom: 30px;">
                <label for="<?php echo $field_name ?>"
                       style="display: block"><?php echo $field_info[1] ?></label>
                <input <?php echo $field_info[0] ? 'required' : '' ?>
                        style="width: 100%; margin: 0 2px"
                        name="<?php echo $field_name ?>"
                        id="<?php echo $field_name ?>"
                        type="number"
                        min="0"
                        max="100"
                        value="<?php echo ! empty( $_POST[ $field_name ] ) ? $_POST[ $field_name ] : '' ?>"/>
				<?php if ( isset( $this->errors[ $field_name ] ) ) {
					?>
                    <smalL style="display: block"><?php echo $this->errors[ $field_name ] ?></smalL>
					<?php
				} ?>
            </div>
			<?php
		}
		?>
    </fieldset>
	<?php wp_nonce_field( \A17_STUDENT_INFO\Frontend\Student_Input_Shortcode::nonce_action ) ?>
    <input required hidden name="action"
           value="<?php echo \A17_STUDENT_INFO\Frontend\Student_Input_Shortcode::form_action ?>"/>
    <div style="text-align: center">
        <button type="submit">Submit Info</button>
    </div>
</form>