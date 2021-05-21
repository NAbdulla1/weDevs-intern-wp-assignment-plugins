<?php


namespace A13_Subscription_Form\Widgets;

use WP_Widget;

class Subscription_Form_Widget extends WP_Widget {
	const form_ajax_action = "a13_subscription_form_action";
	const form_nonce_action = "a13_sauhbndfwas";

	function __construct() {

		parent::__construct(
			'a13_subscription_form_widget',
			'Subscription Form'
		);

		add_action( 'widgets_init', function () {
			register_widget( 'A13_Subscription_Form\\Widgets\\Subscription_Form_Widget' );
		} );

		add_action( 'wp_enqueue_scripts', fn() => wp_enqueue_script( 'a13_subs_form_submit' ) );
	}

	public $args = array(
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget-wrap">',
		'after_widget'  => '</div></div>'
	);

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		$title = 'Subscribe';

		echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];


		echo '<div class="textwidget">';
		?>
        <div style="color:whitesmoke; display: none; padding: 0 10px; border-radius: 10px; border: 1px blue solid;"
             id="a13_sfw_status"></div>
        <form id="a13_sfw" method="post">
            <input style="padding: 0 5px; margin: 5px 0" name="email" type="email" placeholder="Email Address"/>
			<?php wp_nonce_field( self::form_nonce_action ); ?>
            <input hidden name="action" value="<?php echo self::form_ajax_action ?>"/>
            <button style="padding: 0 5px; margin: 5px 0" type="submit">Subscribe</button>
        </form>
		<?php
		echo '</div>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		//no form needed
	}

	public function update( $new_instance, $old_instance ) {
		//no update needed
	}

}
