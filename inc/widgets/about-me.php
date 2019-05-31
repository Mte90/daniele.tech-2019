<?php

class About_Me_Widget extends WPH_Widget {

    /**
     * Initialize the widget
     *
     * @return void
     */
    public function __construct() {
        // Configure widget array
        $args = array(
            'label'       => __( 'About Me', 'understrap' ),
            'description' => __( 'Me and Myself', 'understrap' ),
            'slug'        => 'about-me'
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
		$out .= 'Ciao <img class="emoji" alt="Italy flag" src="https://s.w.org/images/core/emoji/11/svg/1f1ee-1f1f9.svg"> I am Daniele';
		$out .= $args[ 'after_title' ];

		$out .= '<p><img alt="Daniele in pixels" src="' . get_template_directory_uri() . '/img/pixel.png">';
		$out .= __( 'Full Stack Developer, OpenSource addicted. Involved in WordPress, ClassicPress and Mozilla projects.', 'understrap' );
		$out .= '</p>';

		$out .= $args[ 'after_widget' ];
		echo $out;
	}

}

// Register widget
if ( !function_exists( 'load_about_me' ) ) {

	/**
	 * Initialize the widget
	 *
	 * @return void
	 */
	function load_about_me() {
		register_widget( 'About_Me_Widget' );
	}

	add_action( 'widgets_init', 'load_about_me', 1 );
}
