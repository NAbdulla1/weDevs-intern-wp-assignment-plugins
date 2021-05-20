<?php


namespace A12_RELATED_POSTS\Widgets;


use A12_RELATED_POSTS\Related_Posts_Finder;
use WP_Widget;

class Related_Posts_Widget extends WP_Widget {

	function __construct() {

		parent::__construct(
			'a12_related_posts_widget',
			'Related Posts'
		);

		add_action( 'widgets_init', function () {
			register_widget( 'A12_RELATED_POSTS\\Widgets\\Related_Posts_Widget' );
		} );

	}

	public $args = array(
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>',
		'before_widget' => '<div class="widget-wrap">',
		'after_widget'  => '</div></div>'
	);

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		if ( is_single() ) {
			global $post;
			$title = 'Related to ' . $post->post_title;

			echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];


			echo '<div class="textwidget">';
			$related = Related_Posts_Finder::find_related_posts( $post );
			echo "<ol>";
			foreach ( $related as $pst ) {
				$link = get_permalink( $pst );
				echo "<li><a href='$link'>{$pst->post_title}</a></li>";
			}
			echo "</ol>";
			echo '</div>';
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		//no form needed
	}

	public function update( $new_instance, $old_instance ) {
		//no update needed
	}

}
