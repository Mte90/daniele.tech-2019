<?php

class Codeat_Widget extends WPH_Widget {

    /**
     * Initialize the widget
     *
     * @return void
     */
    public function __construct() {
        // Configure widget array
        $args = array(
            'label'       => __( 'Codeat', 'understrap' ),
            'description' => __( 'My company', 'understrap' ),
            'slug'        => 'codeat'
        );
        // Create widget
        $this->create_widget( $args );
    }

    /**
     * Output function
     *
     * @param array $args     The argument shared to the output from WordPress.
     * @param array $instance The settings saved.
     *
     * @return void
     */
    public function widget( $args, $instance ) {
        $out  = $args[ 'before_widget' ];
        $out .= $args[ 'before_title' ];
		$out .= 'Codeat <img alt="Codeat logo" src="' . get_template_directory_uri() . '/img/codeat.svg">';
		$out .= $args[ 'after_title' ];

		$out .= '<p>';
		$out .= __( 'My <a href="https://codeat.co">Web Agency in Rome</a> about Web consultancy. We produce WP freemium plugins, custom web applications but also AI and SAAS development.', 'understrap' );
		$out .= '</p>';

		$out .= $args[ 'after_widget' ];
		echo $out;
	}

}

// Register widget
if ( !function_exists( 'load_codeat' ) ) {

	/**
	 * Initialize the widget
	 *
	 * @return void
	 */
	function load_codeat() {
		register_widget( 'Codeat_Widget' );
	}

	add_action( 'widgets_init', 'load_codeat', 1 );
}
