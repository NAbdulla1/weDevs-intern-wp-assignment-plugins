<?php


namespace A13_Subscription_Form\Widgets;

use WP_Widget;

class Subscription_Form_Widget extends WP_Widget {

	function __construct() {

		parent::__construct(
			'a13_subscription_form_widget',
			'Subscription Form'
		);

		add_action( 'widgets_init', function () {
			register_widget( 'A13_Subscription_Form\\Widgets\\Subscription_Form_Widget' );
		} );
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
        //todo my content
        <input type="email" placeholder="email from widget section"/>
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
