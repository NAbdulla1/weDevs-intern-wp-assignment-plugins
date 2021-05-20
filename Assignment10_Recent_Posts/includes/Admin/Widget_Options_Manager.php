<?php


namespace A10_RP\Admin;


class Widget_Options_Manager {
	/**
	 * Gets all widget options, or only options for a specified widget if a widget id is provided.
	 *
	 * @param string $widget_id Optional. If provided, will only get options for that widget.
	 *
	 * @return array An associative array
	 */
	static function get_dashboard_widget_options(
		$widget_id = ''
	) {
		// Fetch ALL dashboard widget options from the db
		$options = get_option( 'dashboard_widget_options' );

		// If no widget is specified, return everything
		if ( empty( $widget_id ) ) {
			return $options;
		}

		// If we request a widget and it exists, return it
		if ( isset( $options[ $widget_id ] ) ) {
			return $options[ $widget_id ];
		}

		// Something went wrong...
		return false;
	}

	/**
	 * Gets one specific option for the specified widget.
	 *
	 * @param string $widget_id Widget ID.
	 * @param string $option Widget option.
	 * @param string $default Default option.
	 *
	 * @return string            Returns single widget option.
	 */
	static function get_dashboard_widget_option( $widget_id, $option, $default = null ) {
		$options = self::get_dashboard_widget_options( $widget_id );

		// If widget options don't exist, return false.
		if ( ! $options ) {
			return false;
		}

		// Otherwise fetch the option or use default
		if ( isset( $options[ $option ] ) && ! empty( $options[ $option ] ) ) {
			return $options[ $option ];
		} else {
			return ( isset( $default ) ) ? $default : false;
		}
	}

	/**
	 * Saves an array of options for a single dashboard widget to the database.
	 * Can also be used to define default values for a widget.
	 *
	 * @param string $widget_id The name of the widget being updated
	 * @param array $args An associative array of options being saved.
	 * @param bool $add_only Set to true if you don't want to override any existing options.
	 */
	static function update_dashboard_widget_options( $widget_id, $args = array(), $add_only = false ) {
		// Fetch ALL dashboard widget options from the db...
		$options = get_option( 'dashboard_widget_options' );

		// Get just our widget's options, or set empty array.
		$widget_options = ( isset( $options[ $widget_id ] ) ) ? $options[ $widget_id ] : array();

		if ( $add_only ) {
			// Flesh out any missing options (existing ones overwrite new ones).
			$options[ $widget_id ] = array_merge( $args, $widget_options );
		} else {
			// Merge new options with existing ones, and add it back to the widgets array.
			$options[ $widget_id ] = array_merge( $widget_options, $args );
		}

		// Save the entire widgets array back to the db.
		return update_option( 'dashboard_widget_options', $options );
	}
}