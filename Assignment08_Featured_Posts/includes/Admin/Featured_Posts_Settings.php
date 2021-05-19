<?php

namespace A08_Featured_Post\Admin;

class Featured_Posts_Settings {
	public function __construct() {
		add_action( 'admin_init', [ $this, 'init_settings' ] );
		add_action( 'admin_footer', [ $this, 'add_select2' ] );
	}

	public function init_settings() {
		register_setting( 'a08_featured_posts', 'a08_featured_post_categories' );
		register_setting( 'a08_featured_posts', 'a08_featured_posts_no_of_posts' );
		register_setting( 'a08_featured_posts', 'a08_featured_post_order' );

		add_settings_section( 'setting_section', __( "Featured Posts Settings", 'a08_featured_posts' ), [
			$this,
			'setting_section_callback'
		], 'a08_featured_posts' );
	}

	function setting_section_callback() {
		add_settings_field( 'a08_featured_posts_no_of_posts', 'No of Posts', [
			$this,
			'no_of_posts'
		], 'a08_featured_posts', 'setting_section' );

		add_settings_field( 'a08_featured_post_order', 'Post Order', [
			$this,
			'post_order'
		], 'a08_featured_posts', 'setting_section' );

		add_settings_field( 'a08_featured_post_categories', 'Post Categories', [
			$this,
			'post_categories'
		], 'a08_featured_posts', 'setting_section' );
	}

	public function no_of_posts() {
		$posts = get_option( "a08_featured_posts_no_of_posts" );
		$posts = empty( $posts ) ? "0" : $posts;
		?>
        <input name="a08_featured_posts_no_of_posts" id="a08_featured_posts_no_of_posts" type="text"
               value="<?php echo $posts ?>"/>
		<?php
	}

	public function post_order() {
		$curOrder = get_option( "a08_featured_post_order" );
		$options  = [ [ 'random', 'Random' ], [ 'asc', 'Ascending' ], [ 'desc', 'Descending' ] ];
		?>
        <select name="a08_featured_post_order" id="a08_featured_post_order">
			<?php foreach ( $options as $option ) { ?>
                <option <?php echo( ( $option[0] === $curOrder ) ? 'selected' : '' ) ?>
                        value='<?php echo $option[0] ?>'><?php _e( $option[1], 'a08_featured_posts' ) ?>
                </option>
			<?php } ?>
        </select>
		<?php
	}

	public function post_categories() {
		$categories = get_categories();
		$curCat     = get_option( 'a08_featured_post_categories' );
		$curCat     = empty( $curCat ) ? array() : $curCat;
		?>
        <select class="selectable" multiple="multiple" name="a08_featured_post_categories[]"
                id="a08_featured_post_categories">

			<?php foreach ( $categories as $category ) { ?>
                <option <?php echo( ( in_array( $category->slug, $curCat ) ) ? 'selected' : '' ) ?>
                        value='<?php echo $category->slug ?>'>
					<?php _e( $category->name, 'a08_featured_posts' ) ?>
                </option>
			<?php } ?>
        </select>
		<?php
	}

	public function add_select2() {
		echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function () {
                    $(".selectable").select2();
                });
            </script>';
	}
}
