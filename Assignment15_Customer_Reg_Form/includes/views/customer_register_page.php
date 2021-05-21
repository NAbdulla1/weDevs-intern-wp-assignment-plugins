<div class="wrap">
    <form action="__action__?action=a15_crf_registration_form_action" method="post">
        <div style='margin-bottom:15px'>
            <label>First Name</label>
            <input required name="a15_crf_fname" type="text"/>
        </div>
        <div style='margin-bottom:15px'>
            <label>Last Name</label>
            <input required name="a15_crf_lname" type="text"/>
        </div>
        <div style='margin-bottom:15px'>
            <label>Email</label>
            <input required name="a15_crf_email" type="email"/>
        </div>
        <div style='margin-bottom:15px'>
            <label>Password</label>
            <input required name="a15_crf_password" type="password"/>
        </div>
        <div style='margin-bottom:15px'>
            <label>Confirm Password</label>
            <input required name="a15_crf_password2" type="password"/>
        </div>
        <label>Select Capabilities</label>
        <select required multiple="multiple" name="a15_crf_capabilities[]">
            <option value="edit_comment">Edit Comment</option>
            <option value="edit_posts">Edit Posts</option>
        </select>
        <div style='margin-bottom:15px'>
            <button type="submit">Register</button>
        </div>
    </form>
</div>
