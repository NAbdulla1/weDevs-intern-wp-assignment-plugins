<div class="wrap">
    <p><?php if ( isset( $this->errors['create_error'] ) ) {
			echo $this->errors['create_error'];
		} ?>
    </p>
    <p>
		<?php if ( isset( $this->errors['create_success'] ) ) {
			?>
            User created successfully. Please <a href="<?php admin_url(); ?>">Login</a> .
			<?php
		} ?>
    </p>

    <form action="" method="post" id="a15_crf_err_id" novalidate>
        <input hidden name="action" value="a15_crf_registration_form_action">
        <div style='margin-bottom: 20px'>
            <label style='display: block'>Username *</label>
            <input required name="a15_crf_uname" type="text"/>
            <small><?php if ( isset( $this->errors['a15_crf_nuname'] ) ) {
					echo $this->errors['a15_crf_nuname'];
				}
				if ( isset( $this->errors['a15_crf_euname'] ) ) {
					echo $this->errors['a15_crf_euname'];
				} ?></small>
        </div>
        <div style='margin-bottom: 20px'>
            <label style='display: block'>First Name *</label>
            <input required name="a15_crf_fname" type="text"/>
            <small><?php if ( isset( $this->errors['a15_crf_nfname'] ) ) {
					echo $this->errors['a15_crf_nfname'];
				} ?></small>
        </div>
        <div style='margin-bottom: 20px'>
            <label style='display: block'>Last Name</label>
            <input name="a15_crf_lname" type="text"/>
        </div>
        <div style='margin-bottom: 20px'>
            <label style='display: block'>Email *</label>
            <input required name="a15_crf_email" type="email"/>
            <small><?php if ( isset( $this->errors['a15_crf_nemail'] ) ) {
					echo $this->errors['a15_crf_nemail'];
				}
				if ( isset( $this->errors['a15_crf_eemail'] ) ) {
					echo $this->errors['a15_crf_eemail'];
				} ?></small>
        </div>
        <div style='margin-bottom: 20px'>
            <label style='display: block'>Password *</label>
            <input required name="a15_crf_password" type="password"/>
            <small><?php if ( isset( $this->errors['a15_crf_npassword'] ) ) {
					echo $this->errors['a15_crf_npassword'];
				}
				if ( isset( $this->errors['a15_crf_nmatch'] ) ) {
					echo $this->errors['a15_crf_nmatch'];
				} ?></small>
        </div>
        <div style='margin-bottom: 20px'>
            <label style='display: block'>Confirm Password *</label>
            <input required name="a15_crf_password2" type="password"/>
        </div>
        <label style='display: block'>Select Capabilities</label>
        <select multiple="multiple" name="a15_crf_capabilities[]">
            <option value="edit_comment">Edit Comment</option>
            <option value="edit_posts">Edit Posts</option>
        </select>

        <div style='margin-bottom: 20px'>
            <button type="submit">Register</button>
        </div>
    </form>
</div>
